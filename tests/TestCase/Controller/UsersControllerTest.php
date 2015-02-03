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
     * Test if a user is created
     *
     */
    public function testAddAction() {

        $model = TableRegistry::get('CakeManager.Users');

        $this->assertEquals(4, $model->find()->count());

        $data = [
            'role_id'  => 1,
            'email'    => 'newuser@email.nl',
            'password' => 'test',
        ];

        $this->post('/manager/users/add', $data);

        $this->assertResponseOk();

        $this->assertEquals(5, $model->find()->count());
    }

    /**
     * Test if a user is created and able to login
     *
     */
    public function testLoginActionPass() {

        $data = [
            'role_id'  => 1,
            'email'    => 'newuser@email.nl',
            'password' => 'test',
        ];

        $this->post('/manager/users/add', $data);

        $this->assertResponseOk();
        $this->assertRedirect('/manager/users/login');

        $login = [
            'email'    => 'newuser@email.nl',
            'password' => 'test',
        ];

        $this->post('/manager/users/login', $login);

        $this->assertSession(0, 'Auth.User.id');
        $this->assertSession(null, 'Auth.User.email');
    }

    /**
     * Test if a user is created and able to login
     *
     */
    public function testLoginActionFail() {

        $data = [
            'role_id'  => 1,
            'email'    => 'newuser@email.nl',
            'password' => 'test',
            'active'   => 1,
        ];

        $this->post('/manager/users/add', $data);

        $this->assertResponseOk();
        $this->assertRedirect('/manager/users/login');

        $login = [
            'email'    => 'newuser@email.nl',
            'password' => 'test',
        ];

        $this->post('/manager/users/login', $login);

        $this->assertSession(5, 'Auth.User.id');
        $this->assertSession('newuser@email.nl', 'Auth.User.email');
    }

    /**
     * Test if a user is created, logged in and logged out
     *
     */
    public function testLogoutAction() {

        $data = [
            'role_id'  => 1,
            'email'    => 'newuser@email.nl',
            'password' => 'test',
            'active'   => 1,
        ];

        $this->post('/manager/users/add', $data);

        $this->assertResponseOk();
        $this->assertRedirect('/manager/users/login');

        $login = [
            'email'    => 'newuser@email.nl',
            'password' => 'test',
        ];

        $this->post('/manager/users/login', $login);

        $this->assertSession(5, 'Auth.User.id');
        $this->assertSession('newuser@email.nl', 'Auth.User.email');

        $this->get('/manager/users/logout');

        $this->assertSession(null, 'Auth.User.id');
        $this->assertSession(null, 'Auth.User.email');

        $this->assertRedirect('/manager/users/login');
    }

}
