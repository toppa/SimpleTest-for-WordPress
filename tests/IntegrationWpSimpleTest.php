<?php

// the autoloader can be used with tests only if you don't need SimpleTest's mocks for your tests
// so it's good for integration tests
require_once(dirname(__FILE__) . '/../../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php');

class IntegrationTestOfWpSimpleTest extends UnitTestCase {
    private $functionsFacade;
    private $toppaAutoLoader;
    private $wpSimpleTestAutoLoader;
    private $shortcodeNoPath = array('name' => 'Test Results', 'path' => '', 'passes' => 'n');
    private $shortcodeBadPath = array('path' => '/nowhere');
    private $shortcodeGoodPath = array('name' => 'Wp Simpletest', 'path' => '/simpletest-for-wordpress/tests', 'passes' => 'y');

    public function __construct() {
        $this->UnitTestCase();
    }

    public function setUp() {
        $this->toppaAutoLoader = new ToppaAutoLoaderWp('/toppa-plugin-libraries-for-wordpress');
        $this->wpSimpleTestAutoLoader = new ToppaAutoLoaderWp('/simpletest-for-wordpress');
        $this->functionsFacade = new ToppaFunctionsFacadeWp();
    }

    public function testSetShortcodeWithNoPath() {
        $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
        $expectedShortcodeNoPath = array('name' => 'Test Results', 'path' => '', 'passes' => 'n');
        $wpSimpleTest->setShortcode($this->shortcodeNoPath);
        $this->assertEqual($expectedShortcodeNoPath, $wpSimpleTest->getShortcode());
    }

    public function testSetShortcodeWithBadPath() {
        $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
        $expectedShortcodeBadPath = array('name' => 'Test Results', 'path' => '/nowhere', 'passes' => '');
        $wpSimpleTest->setShortcode($this->shortcodeBadPath);
        $this->assertEqual($expectedShortcodeBadPath, $wpSimpleTest->getShortcode());
    }

    public function testSetShortcodeWithGoodPath() {
        $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
        $expectedShortcodeGoodPath = array('name' => 'Wp Simpletest', 'path' => '/simpletest-for-wordpress/tests', 'passes' => 'y');
        $wpSimpleTest->setShortcode($this->shortcodeGoodPath);
        $this->assertEqual($expectedShortcodeGoodPath, $wpSimpleTest->getShortcode());
    }

    public function testConfirmTestFileExistsWithNoPath() {
        try {
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
            $wpSimpleTest->confirmTestFileExists($this->shortcodeNoPath['path']);
        }

        catch (Exception $e) {
            $this->pass();
        }
    }

    public function testConfirmTestFileExistsWithBadPath() {
        try {
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
            $wpSimpleTest->confirmTestFileExists($this->shortcodeBadPath['path']);
        }

        catch (Exception $e) {
            $this->pass();
        }
    }

    public function testConfirmTestFileExistsWithGoodPath() {
        try {
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
            $this->assertTrue($wpSimpleTest->confirmTestFileExists($this->shortcodeGoodPath['path']));
        }

        catch (Exception $e) {
            $this->fail("Exception was not expected: " . $e->getMessage());
        }
    }
}