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
namespace CakeManager\Test\TestCase\Controller;

use Cake\ORM\TableRegistry;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeManager\Controller\[Users]Controller Test Case
 */
class UsersControllerTest extends IntegrationTestCase
{
    /**
     * Fixtures that have to be loaded
     * @var type
     */
    public $fixtures = ['plugin.cake_manager.roles', 'plugin.cake_manager.users'];

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

    /**
     * Test the register-page when register if disabled
     *
     */
    public function testRegisterInvalid()
    {
        \Cake\Core\Configure::write('CM.Register', false);

        $this->get('/register');

        $this->assertResponseSuccess();

        $this->assertRedirect('/');

        \Cake\Core\Configure::write('CM.Register', true);

        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'newuser@email.nl'
                ]
            ]
        ]);

        $this->get('/register');

        $this->assertResponseSuccess();

        $this->assertRedirect('/admin/manager/users');
    }

    /**
     * Test if a register-form is created.
     *
     */
    public function testRegisterForm()
    {
        \Cake\Core\Configure::write('CM.Register', true);

        $this->get('/register');

        $this->assertResponseSuccess();

        $this->assertNoRedirect();

        $this->assertResponseContains('<input type="email" name="email" required="required" maxlength="255" id="email">');
        $this->assertResponseContains('<input type="password" name="new_password" required="required" id="new-password" value="">');
        $this->assertResponseContains('<input type="password" name="confirm_password" required="required" id="confirm-password" value="">');
    }

    /**
     * Test if a user is created with activation.
     *
     */
    public function testRegisterActionPassWithActivation()
    {
        \Cake\Core\Configure::write('CM.Register', true);
        \Cake\Core\Configure::write('CM.ActivationOnRegister', true);

        $data = [
            'email' => 'bob@cakemanager.org',
            'new_password' => 'test',
            'confirm_password' => 'test',
        ];

        $this->post('/register', $data);

        $this->assertResponseSuccess();

        $this->assertRedirect('/users/login');

        $user = $this->Users->get(5);

        $this->assertNotNull($user->get('activation_key'));
        $this->assertEquals(false, $user->get('active'));
    }

    /**
     * Test if a user is created without activation.
     *
     */
    public function testRegisterActionPassWithoutActivation()
    {
        \Cake\Core\Configure::write('CM.Register', true);
        \Cake\Core\Configure::write('CM.ActivationOnRegister', false);

        $data = [
            'email' => 'bob@cakemanager.org',
            'new_password' => 'test',
            'confirm_password' => 'test',
        ];

        $this->post('/register', $data);

        $this->assertResponseSuccess();

        $this->assertRedirect('/users/login');

        $user = $this->Users->get(5);

        $this->assertNull($user->get('activation_key'));
        $this->assertEquals(true, $user->get('active'));
    }

    /**
     * Test user redirected when logged in.
     *
     */
    public function testLoginRedirect()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'role_id' => 1,
                    'email' => 'newuser@email.nl'
                ]
            ]
        ]);

        $this->get('/login');

        $this->assertResponseSuccess();

        $this->assertRedirect('/admin/manager/users');
    }

    /**
     * Test if a login-form is created.
     *
     */
    public function testLoginForm()
    {
        $this->get('/login');

        $this->assertResponseSuccess();
        $this->assertNoRedirect();

        $this->assertResponseContains('<input type="email" name="email" id="email">');
        $this->assertResponseContains('<input type="password" name="password" id="password" value="">');

        $this->assertSession(null, 'Auth.User.id');
    }

    /**

      /**
     * Test if a user is created and able to login
     *
     */
    public function testLoginActionPass()
    {
        // creating a new user
        $user = $this->Users->newEntity([
            'email' => 'newuser@email.nl',
            'password' => 'test',
        ]);

        $user->set('role_id', 1);
        $user->set('active', 1);

        $this->Users->save($user);

        $login = [
            'email' => 'newuser@email.nl',
            'password' => 'test',
        ];

        $this->post('/users/login', $login);

        $this->assertResponseSuccess();

        $this->assertRedirect('/admin/manager/users');

        $this->assertSession(5, 'Auth.User.id');
        $this->assertSession('newuser@email.nl', 'Auth.User.email');
    }

    /**
     * Test if a user is able to log out
     *
     */
    public function testLogoutActionFail()
    {
        $this->get('/users/logout');

        $this->assertResponseSuccess();

        $this->assertRedirect('/users/login');
    }

    /**
     * Test if a user is able to log out
     *
     */
    public function testLogoutActionPass()
    {
        $this->session([
            'Auth' => [
                'User' => [
                    'id' => 5,
                    'email' => 'newuser@email.nl'
                ]
            ]
        ]);

        $this->get('/users/logout');

        $this->assertRedirect('/users/login');

        $this->assertSession(null, 'Auth.User.id');
        $this->assertSession(null, 'Auth.User.email');
    }

    /**
     * Test if an user activates it's account
     *
     */
    public function testActivateFailUserActive()
    {
        $user = $this->Users->get(1);

        $user->set('activation_key', $this->Users->generateActivationKey());

        $this->Users->save($user);

        $this->assertEquals(1, $user->active);

        $this->get('/users/activate/' . $user->email . '/' . $user->activation_key . '');

        $this->assertResponseSuccess();

        $this->assertRedirect('/login');

        $this->assertNotEmpty($_SESSION['Flash']['flash']['message']);
        $this->assertContains('error', $_SESSION['Flash']['flash']['element']);
    }

    /**
     * Test request
     *
     * Fails because logged in
     *
     */
    public function testActivateFailLoggedin()
    {
        $user = $this->Users->get(1);

        $user->set('activation_key', $this->Users->generateActivationKey());

        $user = $this->Users->save($user);

        $this->session(['Auth.User' => [
                'id' => 1,
                'role_id' => 1,
        ]]);

        $this->get('/users/activate/' . $user->email . '/' . $user->activation_key . '');

        $this->assertResponseSuccess();

        $this->assertRedirect('/login');
    }

    /**
     * Test activate
     *
     * Fails because of invalid key
     */
    public function testActivateFailWrongKey()
    {
        $user = $this->Users->get(1);

        $user->set('activation_key', $this->Users->generateActivationKey());

        $user->set('active', 0);

        $this->Users->save($user);

        $this->assertEquals(0, $user->active);

        $this->get('/users/activate/' . $user->email . '/customkeywhosinvalid');

        $this->assertResponseSuccess();

        $this->assertRedirect('/login');

        $this->assertNotEmpty($_SESSION['Flash']['flash']['message']);
        $this->assertContains('error', $_SESSION['Flash']['flash']['element']);
    }

    /**
     * Test activate
     *
     * Fails because of no key
     *
     */
    public function testActivateFailNoKey()
    {
        $user = $this->Users->get(1);

        $user->set('activation_key', $this->Users->generateActivationKey());

        $user->set('active', 0);

        $this->Users->save($user);

        $this->assertEquals(0, $user->active);

        $this->get('/users/activate/' . $user->email . '/');

        $this->assertResponseSuccess();

        $this->assertRedirect('/');

        $this->assertNotEmpty($_SESSION['Flash']['flash']['message']);
        $this->assertContains('error', $_SESSION['Flash']['flash']['element']);
    }

    /**
     * Test activate
     *
     */
    public function testActivatePass()
    {
        $user = $this->Users->get(1);

        $user->set('activation_key', $this->Users->generateActivationKey());

        $user->set('active', 0);

        $this->Users->save($user);

        $this->assertEquals(0, $user->active);

        $this->get('/users/activate/' . $user->email . '/' . $user->activation_key);

        $this->assertResponseSuccess();

        $this->assertRedirect('/login');

        $this->assertContains('success', $_SESSION['Flash']['flash']['element']);
    }

    /**
     * Test if an user requests a new password
     *
     */
    public function testForgotPasswordFailNonActive()
    {
        $user = $this->Users->get(1);

        $user->set('active', 0);

        $this->Users->save($user);

        $data = [
            'email' => $user->get('email'),
        ];

        $this->assertEmpty($user->get('activation_key'));

        $this->post('/users/forgotPassword', $data);

        $this->assertResponseSuccess();

        $this->assertRedirect('/login');

        $user = $this->Users->get(1);

        $this->assertEmpty($user->get('activation_key'));
    }

    /**
     * Test request
     *
     * Fails because logged in
     *
     */
    public function testForgotPasswordFailLoggedin()
    {
        $this->session(['Auth.User' => [
                'id' => 1,
                'role_id' => 1,
        ]]);

        $this->get('/users/forgotPassword');

        $this->assertResponseSuccess();

        $this->assertRedirect('/login');
    }

    public function testForgotPasswordForm()
    {
        $this->get('/users/forgotPassword');

        $this->assertResponseSuccess();
        
        $this->assertResponseContains('<input type="email" name="email" id="email">');
    }

    /**
     * Test request true
     *
     */
    public function testForgotPasswordPass()
    {
        $user = $this->Users->get(1);

        $data = [
            'email' => $user->get('email'),
        ];

        $this->assertEmpty($user->get('activation_key'));

        $this->post('/users/forgotPassword', $data);

        $this->assertResponseSuccess();

        $this->assertRedirect('/login');

        $user = $this->Users->get(1);

        $this->assertNotEmpty($user->get('activation_key'));
    }

    /**
     * Test reset password while logged in
     *
     */
    public function testResetPasswordLoggedIn()
    {
        $this->session(['Auth.User' => [
                'id' => 1,
                'role_id' => 1,
        ]]);

        $this->get('/users/resetPassword/bob@cakemanager.org/');

        $this->assertResponseSuccess();

        $this->assertRedirect();
    }

    /**
     * Test reset password with wrong / no key
     *
     */
    public function testResetPasswordWrongKey()
    {
        $user = $this->Users->get(1);

        $user->set('activation_key', $this->Users->generateActivationKey());

        $user->set('active', 0);

        $this->Users->save($user);

        $this->assertEquals(0, $user->active);

        $this->get('/users/resetPassword/' . $user->email . '/');

        $this->assertResponseSuccess();

        $this->assertRedirect();

        $this->get('/users/resetPassword/' . $user->email . '/THISISTHEWRONGKEY');

        $this->assertResponseSuccess();

        $this->assertRedirect();
    }

    /**
     * Test reset password pass
     *
     */
    public function testResetPasswordPass()
    {
        $user = $this->Users->get(1);

        $user->set('activation_key', $this->Users->generateActivationKey());

        $user->set('active', 0);

        $this->Users->save($user);

        $this->assertEquals(0, $user->active);

        $data = [
            'new_password' => 'test',
            'confirm_password' => 'test',
        ];

        $this->post('/users/resetPassword/' . $user->email . '/' . $user->activation_key . '/', $data);

        $this->assertResponseSuccess();

        $this->assertRedirect('/login');
    }
}
