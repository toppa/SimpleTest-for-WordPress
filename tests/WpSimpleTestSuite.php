<?php

// this is needed for simpletest's addFile method
set_include_path(get_include_path() . PATH_SEPARATOR . dirname(__FILE__));

class WpSimpleTestSuite extends TestSuite {
   function __construct() {
       parent::__construct();
       $this->addFile('UnitWpSimpleTest.php');
       $this->addFile('IntegrationWpSimpleTest.php');
   }
}

