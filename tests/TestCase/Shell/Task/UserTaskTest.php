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
class UserTaskTest extends TestCase
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

        $this->Task = $this->getMock('CakeManager\Shell\Task\UserTask', ['in', 'out', 'err', '_stop'], [$this->io]);
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
    public function testUserTaskPass()
    {
        $this->Users = TableRegistry::get('CakeManager.Users');
        
        $this->assertEquals(4, $this->Users->find('all')->Count());

        $this->Task->expects($this->at(0))->method('in')
            ->will($this->returnValue("testmail@mail.com"));

        $this->Task->expects($this->at(1))->method('in')
            ->will($this->returnValue("password"));

        $action = $this->Task->main();

        $this->assertTrue($action);

        $this->assertEquals(5, $this->Users->find('all')->Count());
        
        $user = $this->Users->get(5);
        
        $this->assertEquals("testmail@mail.com", $user->get('email'));
        $this->assertEquals(1, $user->get('role_id'));
    }
    
    public function testUserTaskFailNoPassword()
    {
        $this->Users = TableRegistry::get('CakeManager.Users');
        
        $this->assertEquals(4, $this->Users->find('all')->Count());

        $this->Task->expects($this->at(0))->method('in')
            ->will($this->returnValue("testmail@mail.com"));

        $this->Task->expects($this->at(1))->method('in')
            ->will($this->returnValue(null));

        $action = $this->Task->main();

        $this->assertFalse($action);

        $this->assertEquals(4, $this->Users->find('all')->Count());
    }
    
    public function testUserTaskFailNoEmail()
    {
        $this->Users = TableRegistry::get('CakeManager.Users');
        
        $this->assertEquals(4, $this->Users->find('all')->Count());

        $this->Task->expects($this->at(0))->method('in')
            ->will($this->returnValue(null));

        $this->Task->expects($this->at(1))->method('in')
            ->will($this->returnValue("password"));

        $action = $this->Task->main();

        $this->assertFalse($action);

        $this->assertEquals(4, $this->Users->find('all')->Count());
    }
    
}
