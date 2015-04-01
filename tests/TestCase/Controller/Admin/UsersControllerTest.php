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

use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

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
    public function setUp()
    {
        parent::setUp();

        $this->Users = TableRegistry::get('CakeManager.Users');

        $user = $this->Users->newEntity();

        $user->email = 'bob@cakemanager.org';
        $user->active = 1;
        $user->role_id = 1;
        $user->password = 'test';

        $this->Users->save($user);
    }

    /**
     * testAuthorization
     *
     * @return void
     */
    public function testAuthorization()
    {
        // index
        $this->get('/admin/manager/users/index');
        $this->assertRedirect('/users/login');

        // add
        $this->get('/admin/manager/users/add');
        $this->assertRedirect('/users/login');

        // view
        $this->get('/admin/manager/users/view');
        $this->assertRedirect('/users/login');

        // edit
        $this->get('/admin/manager/users/edit');
        $this->assertRedirect('/users/login');

        // delete
        $this->get('/admin/manager/users/delete');
        $this->assertRedirect('/users/login');

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

    /**
     * testIndex
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

        $this->get('/admin/manager/users');

        $this->assertResponseOk();

        $this->assertTemplate('Admin\Users\index.ctp');

        $this->assertNotEmpty($this->viewVariable('users'));
        $this->assertNotEmpty($this->viewVariable('searchFilters'));
    }

    /**
     * testView
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

        $this->get('/admin/manager/users/view/5');

        $this->assertResponseOk();

        $this->assertTemplate('Admin\Users\view.ctp');

        $this->assertNotEmpty($this->viewVariable('user'));
    }

    /**
     * testAdd
     *
     * @return void
     */
    public function testAdd()
    {
        Configure::write('CM.UserFields', ['customField']);

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'bob@cakemanager.org'
                ]
            ]
        ]);

        $this->get('/admin/manager/users/add');

        $this->assertResponseOk();

        $this->assertTemplate('Admin\Users\add.ctp');

        $this->assertNotEmpty($this->viewVariable('user'));
        $this->assertNotEmpty($this->viewVariable('roles'));
        $this->assertNotEmpty($this->viewVariable('customFields'));
    }

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

        $post = [
            'email' => 'testaddpost@cakemanager.org',
            'role_id' => 1,
            'password' => 'test',
            'active' => 1,
        ];

        $this->post('/admin/manager/users/add', $post);

        $this->assertResponseSuccess();

        $this->assertRedirect('/admin/manager/users');

        $user = $this->Users->get(6);

        $this->assertEquals('testaddpost@cakemanager.org', $user->get('email'));
        $this->assertEquals(1, $user->get('role_id'));
        $this->assertNotEmpty($user->get('password'));
        $this->assertEquals(1, $user->get('active'));
    }

    /**
     * testEdit
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

        $this->get('/admin/manager/users/edit/4');

        $this->assertResponseOk();

        $this->assertTemplate('Admin\Users\edit.ctp');

        $this->assertNotEmpty($this->viewVariable('user'));
        $this->assertNotEmpty($this->viewVariable('roles'));
        $this->assertEmpty($this->viewVariable('customFields'));
    }

    /**
     * testEdit
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

        $user = $this->Users->get(4);

        $this->assertEquals('thomas@email.nl', $user->get('email'));

        $post = [
            'email' => 'changedemail@cakemanager.org',
        ];

        $this->post('/admin/manager/users/edit/4', $post);

        $this->assertResponseSuccess();

        $this->assertRedirect('/admin/manager/users');

        $user = $this->Users->get(4);

        $this->assertEquals('changedemail@cakemanager.org', $user->get('email'));
    }

    /**
     * testNewPassword
     *
     * @return void
     */
    public function testNewPassword()
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

        $this->get('/admin/manager/users/newPassword/5');

        $this->assertResponseOk();

        $this->assertTemplate('Admin\Users\new_password.ctp');

        $this->assertNotEmpty($this->viewVariable('user'));

        $c1 = '<input type="text" name="users_email" id="users-email" disabled="disabled" value="bob@cakemanager.org">';
        $c2 = '<input type="password" name="new_password" required="required" id="new-password" value="">';
        $c3 = '<input type="password" name="confirm_password" required="required" id="confirm-password" value="">';

        $this->assertResponseContains($c1);
        $this->assertResponseContains($c2);
        $this->assertResponseContains($c3);
    }

    /**
     * testNewPasswordPostFail
     *
     * @return void
     */
    public function testNewPasswordPostFail()
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

        $user = $this->Users->get(5);
        $originalPassword = $user->get('password');

        $data = [
        'new_password' => 'custom1',
        'confirm_password' => 'custom2'
        ];

        $this->post('/admin/manager/users/newPassword/5', $data);
        
        $this->assertResponseSuccess();
        $this->assertNoRedirect();
        
        $user = $this->Users->get(5);
        
        $this->assertEquals($originalPassword, $user->get('password'));
    }

    /**
     * testNewPasswordPost
     *
     * @return void
     */
    public function testNewPasswordPost()
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

        $user = $this->Users->get(5);
        $originalPassword = $user->get('password');

        $data = [
            'new_password' => 'newpassword',
            'confirm_password' => 'newpassword'
        ];

        $this->post('/admin/manager/users/newPassword/5', $data);
        
        $this->assertResponseSuccess();
        $this->assertRedirect();
        
        $user = $this->Users->get(5);
        $this->assertNotEquals($originalPassword, $user->get('password'));
    }

    /**
     * testDelete
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
        
        $this->assertEquals(5, $this->Users->find('all')->count());
        
        $this->delete('/admin/manager/users/delete/5');
        
        $this->assertResponseSuccess();
        $this->assertRedirect('/admin/manager/users');
        
        $this->assertEquals(4, $this->Users->find('all')->count());
    }
}
