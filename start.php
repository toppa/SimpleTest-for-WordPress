<?php
/*
Plugin Name: SimpleTest for WordPress
Plugin URI: http://www.toppa.com/simpletest-for-wordpress
Description: Enables unit and integration testing for WordPress plugins, using SimpleTest
Author: Michael Toppa
Version: 0.1
Author URI: http://www.toppa.com
*/

require_once(dirname(__FILE__) . '/../toppa-libs/ToppaAutoLoaderWp.php');

$toppaAutoLoader = new ToppaAutoLoaderWp('/toppa-libs');
$wpSimpleTestAutoLoader = new ToppaAutoLoaderWp('/wp-simpletest');
$functionsFacade = new ToppaFunctionsFacadeWp();
$simpleTest = new WpSimpleTest($functionsFacade);
$simpleTest->run();
