<?php
namespace CakeManager\Test\TestSuite;

use Cake\Core\Plugin;
use Cake\TestSuite\TestSuite;

class AllTest extends \PHPUnit_Framework_TestSuite
{
    public static function suite()
    {
        $suite = new TestSuite('All CakeManager plugin tests');
        $path = Plugin::path('CakeManager');
        $testPath = $path . DS . 'tests' . DS . 'TestCase';

        if (!is_dir($testPath)) {
            return $suite;
        }

        $suite->addTestDirectoryRecursive($testPath);

        return $suite;
    }
}