<?php
/*
Plugin Name: SimpleTest for WordPress
Plugin URI: http://www.toppa.com/simpletest-for-wordpress
Description: Enables unit and integration testing for WordPress plugins, using SimpleTest
Author: Michael Toppa
Version: 1.0
Author URI: http://www.toppa.com
*/

require_once(dirname(__FILE__) . '/../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php');

$toppaAutoLoader = new ToppaAutoLoaderWp('/toppa-plugin-libraries-for-wordpress');
$wpSimpleTestAutoLoader = new ToppaAutoLoaderWp('/simpletest-for-wordpress');
$functionsFacade = new ToppaFunctionsFacadeWp();
$simpleTest = new WpSimpleTest($functionsFacade);
$simpleTest->run();
