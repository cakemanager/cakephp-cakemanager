<?php

namespace CakeManager\Test\TestCase;

use Cake\TestSuite\TestSuite;


class AllModelsSuite extends TestSuite
{

    public static function suite() {
        $suite = new self('Model related tests');
        $suite->addTestDirectory(__DIR__ . DS . 'Model' . DS . 'Table');
        return $suite;
    }

}
