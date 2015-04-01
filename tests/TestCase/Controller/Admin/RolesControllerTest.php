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
namespace CakeManager\Test\TestCase\Controller\Admin;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeManager\Controller\Admin\RolesController Test Case
 */
class RolesControllerTest extends IntegrationTestCase
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

        $this->Roles = TableRegistry::get('CakeManager.Roles');
    }

    /**
     * testAuthorization
     *
     * @return void
     */
    public function testAuthorization()
    {
        // index
        $this->get('/admin/manager/roles/index');
        $this->assertRedirect('/users/login');

        // add
        $this->get('/admin/manager/roles/add');
        $this->assertRedirect('/users/login');

        // view
        $this->get('/admin/manager/roles/view');
        $this->assertRedirect('/users/login');

        // edit
        $this->get('/admin/manager/roles/edit');
        $this->assertRedirect('/users/login');

        // delete
        $this->get('/admin/manager/roles/delete');
        $this->assertRedirect('/users/login');

        // setting a wrong role_id
        $this->session(['Auth' => ['User' => ['role_id' => 2]]]);

        // index
        $this->get('/admin/manager/roles/index');
        $this->assertResponseError();

        // add
        $this->get('/admin/manager/roles/add');
        $this->assertResponseError();

        // view
        $this->get('/admin/manager/roles/view');
        $this->assertResponseError();

        // edit
        $this->get('/admin/manager/roles/edit');
        $this->assertResponseError();

        // delete
        $this->get('/admin/manager/roles/delete');
        $this->assertResponseError();
    }

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'bob@cakemanager.org'
                ]
            ]
        ]);

        $this->get('/admin/manager/roles');

        $this->assertResponseOk();

        $this->assertTemplate('Admin' . DS . 'Roles' . DS . 'index.ctp');

        $this->assertNotEmpty($this->viewVariable('roles'));
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'bob@cakemanager.org'
                ]
            ]
        ]);

        $this->get('/admin/manager/roles/view/1');

        $this->assertResponseOk();

        $this->assertTemplate('Admin' . DS . 'Roles' . DS . 'view.ctp');

        $this->assertNotEmpty($this->viewVariable('role'));
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'bob@cakemanager.org'
                ]
            ]
        ]);

        $this->get('/admin/manager/roles/add');

        $this->assertResponseOk();

        $this->assertTemplate('Admin' . DS . 'Roles' . DS . 'add.ctp');

        $this->assertNotEmpty($this->viewVariable('role'));
    }

    /**
     * Test add post method
     *
     * @return void
     */
    public function testAddPost()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'bob@cakemanager.org'
                ]
            ]
        ]);

        $data = [
            'name' => 'Programmers',
            'login_redirect' => '/programmers/index',
        ];

        $this->post('/admin/manager/roles/add', $data);

        $this->assertResponseSuccess();

        $role = $this->Roles->get(4);

        $this->assertEquals('Programmers', $role->get('name'));
        $this->assertEquals('/programmers/index', $role->get('login_redirect'));
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'bob@cakemanager.org'
                ]
            ]
        ]);

        $this->get('/admin/manager/roles/edit/3');

        $this->assertResponseOk();

        $this->assertTemplate('Admin' . DS . 'Roles' . DS . 'edit.ctp');

        $this->assertNotEmpty($this->viewVariable('role'));
    }

    /**
     * Test edit post method
     *
     * @return void
     */
    public function testEditPost()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'bob@cakemanager.org'
                ]
            ]
        ]);

        $data = [
            'login_redirect' => '/programmers/changed',
        ];

        $this->post('/admin/manager/roles/edit/3', $data);

        $this->assertResponseSuccess();

        $this->assertRedirect('/admin/manager/roles');

        $role = $this->Roles->get(3);

        $this->assertEquals('/programmers/changed', $role->get('login_redirect'));
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'bob@cakemanager.org'
                ]
            ]
        ]);

        $this->assertEquals(3, $this->Roles->find('all')->count());

        $this->delete('/admin/manager/roles/delete/3');

        $this->assertResponseSuccess();
        $this->assertRedirect('/admin/manager/roles');

        $this->assertEquals(2, $this->Roles->find('all')->count());
    }
}
