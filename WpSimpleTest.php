<?php

require_once 'simpletest/unit_tester.php';
require_once 'simpletest/mock_objects.php';

class WpSimpleTest {
    private $version = '1.1';
    private $cssFileName = 'simpletest.css';
    private $functionsFacade;
    private $shortcodeDefaults = array(
        'name' => 'Test Results',
        'path' => '',
        'passes' => '');
    private $fullTestFilePath;

    public function __construct(ToppaFunctionsFacade $functionsFacade) {
        $this->functionsFacade = $functionsFacade;
    }

    public function run() {
        add_action('wp_enqueue_scripts', array($this, 'enqueueStyle'));
        add_shortcode('simpletest', array($this, 'handleShortcode'));
    }

    public function enqueueStyle() {
        $cssUrl = $this->functionsFacade->getUrlForCustomizableFile($this->cssFileName, __FILE__);
        wp_enqueue_style('simpletest_css', $cssUrl, false, $this->version);
    }

    public function handleShortcode(array $userShortcode) {
        try {
            array_walk($userShortcode, array('ToppaFunctions', 'trimCallback'));
            $this->setShortcode($userShortcode);
            $this->confirmTestFileExists($this->shortcode['path']);
            $testSuite = new TestSuite($this->shortcode['name']);
            $reporter = new WpSimpleTestReporter($this->shortcode['passes']);
            $testResults = $this->runTests($testSuite, $reporter);
        }

        catch (Exception $e) {
            return $e->getMessage();
        }

        return $testResults;
    }

    public function setShortcode(array $userShortcode) {
        $this->shortcode = array_merge($this->shortcodeDefaults, $userShortcode);
        return true;
    }

    public function getShortcode() {
        return $this->shortcode;
    }

    // passing the path instead of using the property to make testing easier
    // - a clue that this should be its own class, but not worth the added complexity
    public function confirmTestFileExists($testFileRelativePath) {
        if (strpos($testFileRelativePath, "/") !== 0) {
            throw new Exception(__("Error: A path to your test file must be provided, relative to the plugins directory, with a leading slash (e.g. '/MyPlugin/TestFile.php')", "wp-simpletest"));
        }

        $pluginsPath = $this->functionsFacade->getPluginsPath();
        $this->fullTestFilePath = $pluginsPath . $testFileRelativePath;

        if (!$this->functionsFacade->checkFileExists($this->fullTestFilePath)) {
            throw new Exception(__("Error: ", "wp-simpletest") . $this->fullTestFilePath . __(" does not exist", "wp-simpletest"));
        }

        return true;
    }

    public function runTests(TestSuite $testSuite, WpSimpleTestReporter $reporter) {
        ob_start();
        $testSuite->addFile($this->fullTestFilePath);
        $testSuite->run($reporter);
        $testResults = ob_get_contents();
        ob_end_clean();
        return $testResults;
    }
}
