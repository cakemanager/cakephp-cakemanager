<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeManager\Test\TestCase;

use Cake\TestSuite\TestSuite;

class AllBehaviorsSuite extends TestSuite
{

    public static function suite()
    {
        $suite = new self('Behavior related tests');
        $suite->addTestDirectory(__DIR__ . DS . 'Model' . DS . 'Behavior');
        return $suite;
    }
}
