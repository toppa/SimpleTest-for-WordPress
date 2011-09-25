<?php
/*
Plugin Name: SimpleTest for WordPress
Plugin URI: http://www.toppa.com/simpletest-for-wordpress
Description: Enables unit and integration testing for WordPress plugins, using SimpleTest
Author: Michael Toppa
Version: 1.0.2
Author URI: http://www.toppa.com
*/

$wpSimpleTestAutoLoaderPath = dirname(__FILE__) . '/../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php';
register_activation_hook(__FILE__, 'wpSimpleTestActivate');
load_plugin_textdomain('wp-simpletest', false, basename(dirname(__FILE__)) . '/languages/');

if (file_exists($wpSimpleTestAutoLoaderPath)) {
    require_once($wpSimpleTestAutoLoaderPath);
    $wpSimpleTestToppaAutoLoader = new ToppaAutoLoaderWp('/toppa-plugin-libraries-for-wordpress');
    $wpSimpleTestAutoLoader = new ToppaAutoLoaderWp('/simpletest-for-wordpress');
    $functionsFacade = new ToppaFunctionsFacadeWp();
    $simpleTest = new WpSimpleTest($functionsFacade);
    $simpleTest->run();
}

function wpSimpleTestActivate() {
    $wpSimpleTestAutoLoaderPath = dirname(__FILE__) . '/../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php';

    if (!file_exists($wpSimpleTestAutoLoaderPath)) {
        $message = __('To activate SimpleTest for WordPress you need to first install', 'wp-simpletest')
            . ' <a href="http://wordpress.org/extend/plugins/toppa-plugin-libraries-for-wordpress/">Toppa Plugins Libraries for WordPress</a>';
        wpSimpleTestCancelActivation($message);
    }

    elseif (!function_exists('spl_autoload_register')) {
        wpSimpleTestCancelActivation(__('You must have at least PHP 5.1.2 to use SimpleTest for WordPress', 'wp-simpletest'));
    }

    elseif (version_compare(get_bloginfo('version'), '3.0', '<')) {
        wpSimpleTestCancelActivation(__('You must have at least WordPress 3.0 to use SimpleTest for WordPress', 'wp-simpletest'));
    }
}

function wpSimpleTestCancelActivation($message) {
    deactivate_plugins(basename(__FILE__));
    wp_die($message);
}