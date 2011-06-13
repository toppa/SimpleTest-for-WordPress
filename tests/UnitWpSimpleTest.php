<?php

require_once(dirname(__FILE__) . '/../../toppa-plugin-libraries-for-wordpress/ToppaFunctions.php');
require_once(dirname(__FILE__) . '/../../toppa-plugin-libraries-for-wordpress/ToppaFunctionsFacadeWp.php');
require_once(dirname(__FILE__) . '/../WpSimpleTest.php');
Mock::generate('ToppaFunctionsFacadeWp');

class UnitWpSimpleTest extends UnitTestCase {
    private $functionsFacade;
    private $shortcodeNoPath = array('name' => 'Test Results', 'path' => '', 'passes' => 'n');
    private $shortcodeBadPath = array('path' => '/nowhere');
    private $shortcodeGoodPath = array('name' => 'Wp Simpletest', 'path' => '/wp-simpletest/tests', 'passes' => 'y');

    public function __construct() {
        $this->UnitTestCase();
    }

    public function setUp() {
        $this->functionsFacade = new MockToppaFunctionsFacadeWp();
        $this->functionsFacade->setReturnValue('getPluginsPath', '/opt/lampp/htdocs/wordpress/wp-content/plugins');
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
        $expectedShortcodeGoodPath = array('name' => 'Wp Simpletest', 'path' => '/wp-simpletest/tests', 'passes' => 'y');
        $wpSimpleTest->setShortcode($this->shortcodeGoodPath);
        $this->assertEqual($expectedShortcodeGoodPath, $wpSimpleTest->getShortcode());
    }

    public function testConfirmTestFileExistsWithNoPath() {
        try {
            $this->functionsFacade->setReturnValue('checkFileExists', false);
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade);
            $wpSimpleTest->confirmTestFileExists($this->shortcodeNoPath['path']);
        }

        catch (Exception $e) {
            $this->pass();
        }
    }

    public function testConfirmTestFileExistsWithBadPath() {
        try {
            $this->functionsFacade->setReturnValue('checkFileExists', false);
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade, $this->hooksFacade);
            $wpSimpleTest->confirmTestFileExists($this->shortcodeBadPath['path']);
        }

        catch (Exception $e) {
            $this->pass();
        }
    }

    public function testConfirmTestFileExistsWithGoodPath() {
        try {
            $this->functionsFacade->setReturnValue('checkFileExists', true);
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade, $this->hooksFacade);
            $this->assertTrue($wpSimpleTest->confirmTestFileExists($this->shortcodeGoodPath['path']));

        }

        catch (Exception $e) {
            $this->fail("Exception was not expected: " . $e->getMessage());
        }
    }
}