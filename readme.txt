=== SimpleTest for WordPress ===
Contributors: Mike Toppa
Tags: unit test, integration test, plugin testing, testing, test, TDD, SimpleTest
Requires at least: 3.0
Tested up to: 3.0
Stable tag: 1.0

Enables unit testing and integration testing for WordPress plugins, using SimpleTest

== Description ==

**Overview**

SimpleTest for WordPress is a tool for WordPress plugin developers who want to create and run automated tests for their plugins. It includes [SimpleTest 1.0.1](http://www.simpletest.org/) and uses a shortcode to let you run unit tests on WordPress plugins, and see the results in a WordPress page. Since it runs within WordPress, you can also do integration testing of plugins (that is, custom WordPress functions used in the plugins will work correctly when the tests are run).

Usage is simple. Create a page or post where you want to display test results (you'll probably want to make this a private page). Then add a shortcode like this:

[simpletest name="SimpleTest Unit Tests" path="/wp-simpletest/tests/UnitTestOfWpSimpleTest.php" passes="y"]

* name (optional): an optional name to show as a header in the test results
* path (required): the path to your tests file, written for use with SimpleTest.
* passes (optional): "y" or "n" - whether to show passed tests in the output (defaults to n)

A css file is included for styling the test output results, if for some reason you want your pass and fail bars to be colors other than green and red. Copy the css file to your active theme folder and customize to your heart's content.

**Applying Agile Coding Practices to WordPress Plugin Development**

The example shortcode above will work. It runs the unit tests I wrote for the plugin itself. I also included integration tests. Test coverage is limited however, given inherent limitations of testing the test harness itself. The differences between the unit tests and integration tests are that the unit tests use mock versions of the plugin's external dependencies (on WordPress and the filesystem), and the integration tests run against the actual dependencies. The former tell you if your plugin's internal logic is correct, the latter tell you if there are any problems interfacing with external dependencies. Don't write dirty hybrids that mix the two! Then it's hard to even tell what you're really testing.

I made a mockery of WordPress (pun courtesy of Steve Freeman) by creating a WpFacade class, which you can also use with your plugin development. WordPress functions and hooks are wrapped into methods in WpFacade (and I gave them more meaningful names). It also provides enhanced functionality for tasks such as creating database tables. Currently coverage of WordPress functionality is very limited, but will grow as WpFacade is used in more places. Using WpFacade makes it easier to unit test your plugins, and will drive de-coupling of your code as you develop it, if you do test driven development. Avoiding direct dependencies on WordPress' custom functions can also make it easier to port your plugins to other CMS.

== Installation ==

Upload to your plugin folder just like any other plugin, and activate. There is no settings menu.

== Changelog ==

= 1.0 =

* First version
