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
    }

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
}
