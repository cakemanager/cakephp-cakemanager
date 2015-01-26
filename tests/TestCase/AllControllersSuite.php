<?php

namespace CakeManager\Test\TestCase;

use Cake\TestSuite\TestSuite;

class AllControllersSuite extends TestSuite
{

    public static function suite() {
        $suite = new self('Controller related tests');
        $suite->addTestDirectory(__DIR__ . DS . 'Controller');
        return $suite;
    }

}
