<?php

require_once(dirname(__FILE__) . '/../../toppa-plugin-libraries-for-wordpress/ToppaFunctionsFacadeWp.php');
Mock::generate('ToppaFunctionsFacadeWp');

class UnitWpSimpleTest extends UnitTestCase {
    private $functionsFacade;

    public function __construct() {
    }

    public function setUp() {
        $this->functionsFacade = new MockToppaFunctionsFacadeWp();
        $this->functionsFacade->setReturnValue('getPluginsPath', '/opt/lampp/htdocs/wordpress/wp-content/plugins');
    }

    public function testSetShortcodeWithNoPath() {
        $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
        $expectedShortcodeNoPath = array('name' => 'Test Results', 'path' => '', 'passes' => 'n');
		$shortcodeNoPath = array('name' => 'Test Results', 'path' => '', 'passes' => 'n');
        $wpSimpleTest->setShortcode($shortcodeNoPath);
        $this->assertEqual($expectedShortcodeNoPath, $wpSimpleTest->getShortcode());
    }

    public function testSetShortcodeWithBadPath() {
        $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
        $expectedShortcodeBadPath = array('name' => 'Test Results', 'path' => '/nowhere', 'passes' => '');
		$shortcodeBadPath = array('path' => '/nowhere');
        $wpSimpleTest->setShortcode($shortcodeBadPath);
        $this->assertEqual($expectedShortcodeBadPath, $wpSimpleTest->getShortcode());
    }

    public function testSetShortcodeWithGoodPath() {
        $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
        $expectedShortcodeGoodPath = array('name' => 'Wp Simpletest', 'path' => '/wp-simpletest/tests', 'passes' => 'y');
		$shortcodeGoodPath = array('name' => 'Wp Simpletest', 'path' => '/wp-simpletest/tests', 'passes' => 'y');
        $wpSimpleTest->setShortcode($shortcodeGoodPath);
        $this->assertEqual($expectedShortcodeGoodPath, $wpSimpleTest->getShortcode());
    }

    public function testConfirmTestFileExistsWithNoPath() {
        try {
            $this->functionsFacade->setReturnValue('checkFileExists', false);
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
            $wpSimpleTest->confirmTestFileExists('');
        }

        catch (Exception $e) {
            $this->pass();
        }
    }

    public function testConfirmTestFileExistsWithBadPath() {
        try {
            $this->functionsFacade->setReturnValue('checkFileExists', false);
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
            $wpSimpleTest->confirmTestFileExists('/nowhere');
        }

        catch (Exception $e) {
            $this->pass();
        }
    }

    public function testConfirmTestFileExistsWithGoodPath() {
        try {
            $this->functionsFacade->setReturnValue('checkFileExists', true);
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
            $this->assertTrue($wpSimpleTest->confirmTestFileExists('/wp-simpletest/tests'));

        }

        catch (Exception $e) {
            $this->fail("Exception was not expected: " . $e->getMessage());
        }
    }
}
