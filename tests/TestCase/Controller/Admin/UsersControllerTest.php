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

    public function testAuthorization() {

        // index
        $this->get('/admin/manager/users/index');
        $this->assertRedirect('/manager/users/login');

        // add
        $this->get('/admin/manager/users/add');
        $this->assertRedirect('/manager/users/login');

        // view
        $this->get('/admin/manager/users/view');
        $this->assertRedirect('/manager/users/login');

        // edit
        $this->get('/admin/manager/users/edit');
        $this->assertRedirect('/manager/users/login');

        // delete
        $this->get('/admin/manager/users/delete');
        $this->assertRedirect('/manager/users/login');

        // setting a wrong role_id
        $this->session(['Auth' => ['User' => ['role_id' => 2]]]);

        // index
        $this->get('/admin/manager/users/index');
        $this->assertResponseError();

         // add
        $this->get('/admin/manager/users/add');
        $this->assertResponseError();

        // view
        $this->get('/admin/manager/users/view');
        $this->assertResponseError();

        // edit
        $this->get('/admin/manager/users/edit');
        $this->assertResponseError();

        // delete
        $this->get('/admin/manager/users/delete');
        $this->assertResponseError();
    }


}
