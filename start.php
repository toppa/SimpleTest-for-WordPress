<?php
/*
Plugin Name: SimpleTest for WordPress
Plugin URI: http://www.toppa.com/simpletest-for-wordpress
Description: Enables unit and integration testing for WordPress plugins, using SimpleTest
Author: Michael Toppa
Version: 1.0
Author URI: http://www.toppa.com
*/

$autoLoaderPath = dirname(__FILE__) . '/../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php';

if (file_exists($autoLoaderPath) && function_exists('spl_autoload_register')) {
    require_once($autoLoaderPath);
    $toppaAutoLoader = new ToppaAutoLoaderWp('/toppa-plugin-libraries-for-wordpress');
    $wpSimpleTestAutoLoader = new ToppaAutoLoaderWp('/simpletest-for-wordpress');
    $functionsFacade = new ToppaFunctionsFacadeWp();
    $simpleTest = new WpSimpleTest($functionsFacade);
    $simpleTest->run();
}

else {
    // do nothing if dependencies are not met
}

register_activation_hook(__FILE__, 'wpSimpleTestActivate');

function wpSimpleTestActivate() {
    $autoLoaderPath = dirname(__FILE__) . '/../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php';

    if (!file_exists($autoLoaderPath)) {
        trigger_error('You must also install the "Toppa Plugin Libraries for WordPress" plugin to use SimpleTest for WordPress (this is not actually a PHP error)', E_USER_ERROR);
    }

    if (!function_exists('spl_autoload_register')) {
        trigger_error('You must have at least PHP 5.1.2 to use SimpleTest for WordPress (this is not actually a PHP error)', E_USER_ERROR);
    }

    if (version_compare(get_bloginfo('version'), '3.0', '<')) {
        trigger_error('You must have at least WordPress 3.0 to use SimpleTest for WordPress (this is not actually a PHP error)', E_USER_ERROR);
    }
}

