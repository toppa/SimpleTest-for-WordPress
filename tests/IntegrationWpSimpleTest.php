<?php

require_once(dirname(__FILE__) . '/../../toppa-libs/ToppaFunctions.php');
require_once(dirname(__FILE__) . '/../../toppa-libs/ToppaWpFunctionsFacade.php');
require_once(dirname(__FILE__) . '/../../toppa-libs/ToppaWpHooksFacade.php');
require_once(dirname(__FILE__) . '/../WpSimpleTest.php');

class IntegrationTestOfWpSimpleTest extends UnitTestCase {
    private $functionsFacade;
    private $hooksFacade;
    private $shortcodeNoPath = array('name' => 'Test Results', 'path' => '', 'passes' => 'n');
    private $shortcodeBadPath = array('path' => '/nowhere');
    private $shortcodeGoodPath = array('name' => 'Wp Simpletest', 'path' => '/wp-simpletest/tests', 'passes' => 'y');

    public function __construct() {
        $this->UnitTestCase();
    }

    public function setUp() {
        $this->functionsFacade = new ToppaWpFunctionsFacade();
        $this->hooksFacade = new ToppaWpHooksFacade();
    }

    public function testSetShortcodeWithNoPath() {
        $wpSimpleTest = new WpSimpleTest($this->functionsFacade, $this->hooksFacade);
        $expectedShortcodeNoPath = array('name' => 'Test Results', 'path' => '', 'passes' => 'n');
        $wpSimpleTest->setShortcode($this->shortcodeNoPath);
        $this->assertEqual($expectedShortcodeNoPath, $wpSimpleTest->getShortcode());
    }

    public function testSetShortcodeWithBadPath() {
        $wpSimpleTest = new WpSimpleTest($this->functionsFacade, $this->hooksFacade);
        $expectedShortcodeBadPath = array('name' => 'Test Results', 'path' => '/nowhere', 'passes' => '');
        $wpSimpleTest->setShortcode($this->shortcodeBadPath);
        $this->assertEqual($expectedShortcodeBadPath, $wpSimpleTest->getShortcode());
    }

    public function testSetShortcodeWithGoodPath() {
        $wpSimpleTest = new WpSimpleTest($this->functionsFacade, $this->hooksFacade);
        $expectedShortcodeGoodPath = array('name' => 'Wp Simpletest', 'path' => '/wp-simpletest/tests', 'passes' => 'y');
        $wpSimpleTest->setShortcode($this->shortcodeGoodPath);
        $this->assertEqual($expectedShortcodeGoodPath, $wpSimpleTest->getShortcode());
    }

    public function testConfirmTestFileExistsWithNoPath() {
        try {
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade, $this->hooksFacade);
            $wpSimpleTest->confirmTestFileExists($this->shortcodeNoPath['path']);
        }

        catch (Exception $e) {
            $this->pass();
        }
    }

    public function testConfirmTestFileExistsWithBadPath() {
        try {
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade, $this->hooksFacade);
            $wpSimpleTest->confirmTestFileExists($this->shortcodeBadPath['path']);
        }

        catch (Exception $e) {
            $this->pass();
        }
    }

    public function testConfirmTestFileExistsWithGoodPath() {
        try {
            $wpSimpleTest = new WpSimpleTest($this->functionsFacade, $this->hooksFacade);
            $this->assertTrue($wpSimpleTest->confirmTestFileExists($this->shortcodeGoodPath['path']));
        }

        catch (Exception $e) {
            $this->fail("Exception was not expected: " . $e->getMessage());
        }
    }
}