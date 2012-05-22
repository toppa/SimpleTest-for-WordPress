<?php
class WpSimpleTestReporter extends HtmlReporter {
    private $showPasses;

    function __construct($showPasses) {
        $this->showPasses = $showPasses;
        parent::__construct('UTF-8');
    }

    function paintHeader($test_name) {
        print "<h3 class=\"SimpleTestHeader\">$test_name</h3>\n";
        print "<div class=\"SimpleTest\">\n";
        flush();
    }

    function paintFooter($test_name) {
        if ($this->getFailCount() + $this->getExceptionCount() > 0) {
            $resultBarColor = "SimpleTestFailBarColor";
        }

        else {
            $resultBarColor = "SimpleTestPassBarColor";

        }
        print "<div class=\"SimpleTestSummary $resultBarColor\">";
        print $this->getTestCaseProgress() . "/" . $this->getTestCaseCount();
        print " test cases complete:\n";
        print "<strong>" . $this->getPassCount() . "</strong> passes, ";
        print "<strong>" . $this->getFailCount() . "</strong> fails and ";
        print "<strong>" . $this->getExceptionCount() . "</strong> exceptions.";
        print "</div>\n";
        print "</div>\n";
    }

    function paintPass($message) {
        parent::paintPass($message);

        if (stripos($this->showPasses, 'y') === 0) {
            print "<span class=\"pass\">Pass</span>: ";
            $breadcrumb = $this->getTestList();
            array_shift($breadcrumb);
            print implode("-&gt;", $breadcrumb);
            print "->$message<br />\n";
        }
    }
}
