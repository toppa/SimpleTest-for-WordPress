=== SimpleTest for WordPress ===
Contributors: toppa
Donate link: http://www.toppa.com/simpletest-for-wordpress/
Tags: unit test, integration test, plugin testing, testing, test, TDD, SimpleTest
Requires at least: 3.0
Tested up to: 3.4
Stable tag: 1.1
License: GPLv2 or later

Enables unit testing and integration testing for WordPress plugins, using SimpleTest

== Description ==

**I am currently no longer developing or supporting this plugin. I may resume development and support in the future, but I'm not sure when.**

**Overview**

SimpleTest for WordPress is a tool for WordPress plugin developers who want to create and run automated tests for their plugins. It includes [SimpleTest 1.1](http://www.simpletest.org/) and uses a shortcode to let you run unit tests on WordPress plugins, and see the results in a WordPress page. Since it runs within WordPress, you can also do integration testing of plugins (that is, custom WordPress functions used in the plugins will work correctly when the tests are run).

**Installation of [Toppa Plugin Libraries for WordPress](http://wordpress.org/extend/plugins/toppa-plugin-libraries-for-wordpress/) is required for this plugin. Please download and install it first.**

The "tests" subdirectory contains real, example unit and integration tests so you can see how tests are written for SimpleTest (it is very similar to PHPUnit, but I find its use of mock objects more straightforward, and since SimpleTest's native output is HTML, it integrates nicely with WordPress).

Usage is simple. Create a page or post where you want to display test results (you'll probably want to make this a private page). Then add a shortcode like this:

[simpletest name="SimpleTest Unit Tests" path="/simpletest-for-wordpress/tests/UnitWpSimpleTest.php" passes="y"]

* name (optional): an optional name to show as a header in the test results
* path (required): the path to your tests file, relative to the base plugin directory, written for use with SimpleTest.
* passes (optional): "y" or "n" - whether to show passed tests in the output (defaults to n)

A css file is included for styling the test output results. Copy the css file to your active theme folder and customize to your heart's content.

**Applying Agile Coding Practices to WordPress Plugin Development**

The example shortcode above will work. It runs the unit tests I wrote for the plugin itself. I also included integration tests. Test coverage is limited however, given inherent limitations of testing the test harness itself. The differences between the unit tests and integration tests are that the unit tests use mock versions of the plugin's external dependencies (on WordPress functions and the filesystem), and the integration tests run against the actual dependencies. The former tell you if your plugin's internal logic is correct, the latter tell you if there are any problems interfacing with external dependencies. Don't write dirty hybrids that mix the two! Then it's hard to even tell what you're really testing.

== Installation ==

1. Install [Toppa Plugin Libraries for WordPress](http://wordpress.org/extend/plugins/toppa-plugin-libraries-for-wordpress/) in your plugin folder
1. Install SimpleTestForWordPress in your plugin folder and activate. There is no settings menu.

== Frequently Asked Questions ==

* Requires PHP 5.1.2 or higher.
* See the [SimpleTest for WordPress page on my website](http://www.toppa.com/simpletest-for-wordpress/) for more details and usage examples.
* For troubleshooting help, please [post a comment in my latest post on WordPress plugins](http://www.toppa.com/category/technical/wordpress-plugins/).

== Screenshots ==

1. Sample test output

== Changelog ==

= 1.1 =
* Upgraded the included version of SimpleTest to the current version (1.1.0)
* Updated WordPress test runner and HTML report to use SimpleTest 1.1.0
* Check system requirements at admin_init (instead of plugin activation)
* Improved included sample tests
* Follow correct WordPress procedure for including stylesheet

= 1.0.2 =
* More user friendly handling of activation errors
* Added .pot language translation file

= 1.0.1 =
* Added activation function, to check all dependencies are met
* Does not run if dependencies are not met

= 1.0 =
* First version
