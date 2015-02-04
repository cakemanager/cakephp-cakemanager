<?php

namespace CakeManager\Test\TestCase\Controller;

use CakeManager\Controller\UsersController;
use Cake\TestSuite\IntegrationTestCase;
use Cake\ORM\TableRegistry;

/**
 * CakeManager\Controller\[Users]Controller Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{

    /**
     * Fixtures that have to be loaded
     * @var type
     */
    public $fixtures = ['plugin.cake_manager.users', 'plugin.cake_manager.roles'];

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
     * Test if a login-form is created.
     *
     */
    public function testLoginForm() {

        $this->get('/login');

        $this->assertResponseOk();
        $this->assertNoRedirect();

        $this->assertResponseContains('<input type="email" name="email" id="email">');
        $this->assertResponseContains('<input type="password" name="password" id="password">');

        $this->assertSession(null, 'Auth.User.id');
    }

    /**

      /**
     * Test if a user is created and able to login
     *
     */
    public function testLoginActionPass() {

        // creating a new user
        $data = [
            'role_id'  => 1,
            'email'    => 'newuser@email.nl',
            'password' => 'test',
        ];

        $this->Users->save($this->Users->newEntity($data));

        $login = [
            'email'    => 'newuser@email.nl',
            'password' => 'test',
        ];

        $this->post('/manager/users/login', $login);

        $this->assertSession(0, 'Auth.User.id');
        $this->assertSession(null, 'Auth.User.email');
    }

    /**
     * Test if a user is able to log out
     *
     */
    public function testLogoutActionFail() {

        $this->get('/manager/users/logout');

        $this->assertRedirect('/manager/users/login');
    }

    /**
     * Test if a user is able to log out
     *
     */
    public function testLogoutActionPass() {

        $this->session([
            'Auth' => [
                'User' => [
                    'id'    => 5,
                    'email' => 'newuser@email.nl'
                ]
            ]
        ]);

        $this->get('/manager/users/logout');

        $this->assertRedirect('/manager/users/login');

        $this->assertSession(null, 'Auth.User.id');
        $this->assertSession(null, 'Auth.User.email');
    }

    

}
