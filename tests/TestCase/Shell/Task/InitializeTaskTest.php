<?php
/**
 * CakePHP :  Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeManager\Test\TestCase\Shell\Task;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * LoadTaskTest class.
 *
 */
class InitializeTaskTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Roles' => 'plugin.cake_manager.roles',
        'Users' => 'plugin.cake_manager.users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->io = $this->getMock('Cake\Console\ConsoleIo', [], [], '', false);

        $this->Task = $this->getMock('CakeManager\Shell\Task\InitializeTask', ['in', 'out', 'err', '_stop'], [$this->io]);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($this->shell);
    }

    /**
     * testLoad
     *
     * @return void
     */
    public function testInitializeTaskPass()
    {
        $this->Roles = TableRegistry::get('CakeManager.Roles');
        
        $action = $this->Task->main();

        $this->assertTrue($action);
    }
}
