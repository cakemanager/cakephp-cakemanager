<?php

namespace CakeManager\Test\TestCase;

use Cake\TestSuite\TestSuite;


class AllComponentsSuite extends TestSuite
{

    public static function suite() {
        $suite = new self('Component related tests');
        $suite->addTestFile(__DIR__ . DS . 'Controller' . DS . 'Component' . DS . 'MenuComponentTest.php');
        $suite->addTestFile(__DIR__ . DS . 'Controller' . DS . 'Component' . DS . 'IsAuthorizedComponentTest.php');
        return $suite;
    }

}
