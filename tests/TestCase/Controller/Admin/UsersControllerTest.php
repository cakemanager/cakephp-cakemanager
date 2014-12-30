<?php

namespace CakeManager\Test\TestCase\Controller\Admin;

use CakeManager\Controller\Admin\UsersController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * CakeManager\Controller\Admin\UsersController Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Users' => 'plugin.cake_manager.users',
        'Roles' => 'plugin.cake_manager.roles',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();

        $this->Users = TableRegistry::get('CakeManager.Users');
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex() {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView() {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test Login view method
     */
    public function testLoginView() {

        $this->get('/admin/manager/users');

        $this->assertRedirect(['plugin' => 'CakeManager', 'controller' => 'Users', 'action' => 'login', 'prefix' => false]);

        $this->assertResponseOk();
    }

    public function testLoginAction() {

        // adding a user

        $data = [
            'role_id'  => 1,
            'email'    => 'newuser@email.nl',
            'password' => 'test',
            'created'  => '2014-12-23 00:43:20',
            'modified' => '2014-12-23 00:43:20'
        ];

        $this->post('/manager/users/add', $data);

        // logging in

        $data = [
            'email'    => 'newuser@email.nl',
            'password' => 'test',
        ];

        $this->post('/manager/users/login', $data);

        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd() {

        $count = $this->Users->find('all');

        $this->assertEquals(4, $count->count());

        $data = [
            'role_id'  => 1,
            'email'    => 'newuser@email.nl',
            'password' => 'test',
            'created'  => '2014-12-23 00:43:20',
            'modified' => '2014-12-23 00:43:20'
        ];

        $this->post('/manager/users/add', $data);

        $count = $this->Users->find('all');

        $this->assertEquals(5, $count->count());
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit() {

        $data = $this->Users->get(4);

        $this->assertEquals('thomas@email.nl', $data->email);

        $_data = [
            'id'    => 4,
            'email' => 'thomaschanged@email.nl',
        ];

        $this->session([
            'Auth' => [
                'User' => [
                    'id'    => 1,
                    'email' => 'bob@email.nl',
                ]
            ]
        ]);

        $this->post('/manager/users/edit/4', $_data);


        $data = $this->Users->get(4);

        $this->assertEquals('thomaschanged@email.nl', $data->email);
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete() {
        $this->markTestIncomplete('Not implemented yet.');
    }

}
