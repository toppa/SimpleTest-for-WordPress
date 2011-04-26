<?php
/*
Plugin Name: SimpleTest for WordPress
Plugin URI: http://www.toppa.com/simpletest-for-wordpress
Description: Enables unit and integration testing for WordPress plugins, using SimpleTest
Author: Michael Toppa
Version: 0.1
Author URI: http://www.toppa.com
*/

require_once(dirname(__FILE__) . '/../toppa-libs/ToppaFunctions.php');
require_once(dirname(__FILE__) . '/../toppa-libs/ToppaWpFunctionsFacade.php');
require_once(dirname(__FILE__) . '/../toppa-libs/ToppaWpHooksFacade.php');
require_once('simpletest/unit_tester.php');
require_once('simpletest/reporter.php');
require_once('simpletest/mock_objects.php');
require_once('WpSimpleTestReporter.php');
require_once('WpSimpleTest.php');

$functionsFacade = new ToppaWpFunctionsFacade();
$hooksFacade = new ToppaWpHooksFacade();
$simpleTest = new WpSimpleTest($functionsFacade, $hooksFacade);
$simpleTest->run();
