<?php
/*
Plugin Name: SimpleTest for WordPress
Plugin URI: http://www.toppa.com/simpletest-for-wordpress
Description: Enables unit and integration testing for WordPress plugins, using SimpleTest
Author: Michael Toppa
Version: 1.1
Author URI: http://www.toppa.com
License: GPLv2 or later
*/

$wpSimpleTestAutoLoaderPath = dirname(__FILE__) . '/../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php';
add_action('admin_init', 'wpSimpleTestRuntimeChecks');
load_plugin_textdomain('wp-simpletest', false, basename(dirname(__FILE__)) . '/languages/');

if (file_exists($wpSimpleTestAutoLoaderPath)) {
    require_once($wpSimpleTestAutoLoaderPath);
    $wpSimpleTestToppaAutoLoader = new ToppaAutoLoaderWp('/toppa-plugin-libraries-for-wordpress');
    $wpSimpleTestAutoLoader = new ToppaAutoLoaderWp('/simpletest-for-wordpress');
    $functionsFacade = new ToppaFunctionsFacadeWp();
    $simpleTest = new WpSimpleTest($functionsFacade);
    $simpleTest->run();
}

function wpSimpleTestRuntimeChecks() {
    $status = wpSimpleTestActivationChecks();

    if (is_string($status)) {
        wpSimpleTestCancelActivation($status);
        return null;
    }

    return null;
}

function wpSimpleTestActivationChecks() {
    $autoLoaderPath = dirname(__FILE__) . '/../toppa-plugin-libraries-for-wordpress/ToppaAutoLoaderWp.php';
    $toppaLibsVersion = get_option('toppaLibsVersion');

    if (!file_exists($autoLoaderPath) || !$toppaLibsVersion || version_compare($toppaLibsVersion, '1.3.3', '<')) {
        return __('To activate SimpleTest for WordPress you need to have the current version of', 'wp-simpletest')
            . ' <a href="plugin-install.php?tab=plugin-information&plugin=toppa-plugin-libraries-for-wordpress">Toppa Plugins Libraries for WordPress</a>. '
            . __('Click this link to view details, and then click the "Install Now" button to get the current version. Then you can activate Shashin.', 'wp-simpletest');
    }

    if (!function_exists('spl_autoload_register')) {
        return __('SimpleTest for WordPress not activated. You must have at least PHP 5.1.2 to use SimpleTest for WordPress', 'wp-simpletest');
    }

    if (version_compare(get_bloginfo('version'), '3.0', '<')) {
        return __('SimpleTest for WordPress not activated. You must have at least WordPress 3.0 to use SimpleTest for WordPress', 'wp-simpletest');
    }

    return true;
}

function wpSimpleTestCancelActivation($message) {
    deactivate_plugins('simpletest-for-wordpress/start.php', true);
    wp_die($message);
}
