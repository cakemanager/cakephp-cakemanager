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
namespace CakeManager\Controller;

use CakeManager\Controller\AppController;
use Cake\Core\Configure;
use Cake\Core\Exception\Exception;
use Cake\Event\Event;

/**
 * Users Controller
 *
 */
class UsersController extends AppController
{

    /**
     * BeforeFilter Callback
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        // Auth-settings: Allows all user-related methods
        $this->Auth->allow(['resetPassword', 'forgotPassword', 'logout', 'login', 'activate', 'register']);

        // Setting up the base-theme
        if (!$this->theme) {
            $this->theme = "CakeManager";
        }

        // Setting up the base-layout
        if (!$this->layout) {
            $this->layout = "base";
        }
    }

    /**
     * Register action
     *
     * # Enabling / Disabling register action
     *
     * Configure::write('CM.Register', true);
     *
     * @return type
     */
    public function register()
    {
        if (!Configure::read('CM.Register')) {
            return $this->redirect('/');
        }

        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        $user = $this->Users->newEntity();

        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);

            $user->set('role_id', 3);
            $user->set('active', true);

            if (Configure::read('CM.ActivationOnRegister')) {
                $user->set('activation_key', $this->Users->generateActivationKey());
                $user->set('active', false);
            }

            if ($this->Users->save($user)) {
                // firing an event: afterRegister
                $_event = new Event('Controller.Users.afterRegister', $this, [
                    'user' => $user
                ]);
                $this->eventManager()->dispatch($_event);

                // firing an event: afterInvalidRegister
                $_event = new Event('Controller.Users.afterInvalidRegister', $this, [
                    'user' => $user
                ]);
                $this->eventManager()->dispatch($_event);

                $this->Flash->success(__('Registered succesfully!'));
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error(__('Could not register. Please, try again.'));
            }
        }

        $this->set(compact('user'));

        $this->render(Configure::read('CM.UserViews.register'));
    }

    /**
     * Login action
     *
     * # Changing the view:
     *
     * Configure::write('CM.UserViews.login', 'custom/view');
     *
     * @return void|\Cake\Network\Response
     */
    public function login()
    {
        $this->loadModel('CakeManager.Roles');

        // Redirect if user is already logged in
        if ($this->authUser) {
            $redirect = $this->Roles->redirectFrom($this->authUser['role_id']);
            return $this->redirect($redirect);
        }

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                $redirect = $this->Roles->redirectFrom($user['role_id']);

                // firing an event: afterLogin
                $_event = new Event('Controller.Users.afterLogin', $this, [
                    'user' => $user
                ]);
                $this->eventManager()->dispatch($_event);

                return $this->redirect($redirect);
            }

            // firing an event: afterInvalidLogin
            $_event = new Event('Controller.Users.afterInvalidLogin', $this, [
                'user' => $user
            ]);
            $this->eventManager()->dispatch($_event);

            $this->Flash->error(__('Your username or password is incorrect.'));
        }

        $this->set('registerEnabled', Configure::read('CM.Register'));

        $this->render(Configure::read('CM.UserViews.login'));
    }

    /**
     * Forgot password action
     *
     * Via this action you are able to request a new password.
     * After the post it will send a mail with a link.
     * This link will redirect to the action 'reset_password'.
     *
     * This action always gives a success-message.
     * That's because else hackers (or other bad-guys) will be able
     * to see if an e-mail is registered or not.
     *
     * # Changing the view:
     *
     * Configure::write('CM.UserViews.forgot_password', 'custom/view');
     *
     * @return void|\Cake\Network\Response
     */
    public function forgotPassword()
    {
        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        if ($this->request->is('post')) {
            $user = $this->Users->findByEmail($this->request->data['email']);


            if ($user->Count()) {
                $user = $user->first();

                if ($user->get('active') === 1) {
                    $user->set('activation_key', $this->Users->generateActivationKey());

                    $this->Users->save($user);

                    // firing an event: afterForgotPassword
                    $_event = new Event('Controller.Users.afterForgotPassword', $this, [
                        'user' => $user
                    ]);
                    $this->eventManager()->dispatch($_event);
                }
            }

            // Always return a success-message. Else hackers will be able to see if an e-mail is registered or not
            $this->Flash->success(__('We have sent you a mail. Check your e-mailaddress to activate your account.'));
            return $this->redirect('/login');
        }

        $this->render(Configure::read('CM.UserViews.forgotPassword'));
    }

    /**
     * Activate action
     *
     * Users will reach this action when they need to activate their account.
     * Ths action will activate the account and redirect to the login-page.
     *
     * @param string $email The e-mailaddress from the user.
     * @param string $activationKey The refering activation key.
     * @return void|\Cake\Network\Response
     */
    public function activate($email, $activationKey = null)
    {
        // If there's no activation_key
        if (!$activationKey) {
            $this->Flash->error(__('Your account could not be activated.'));
            return $this->redirect($this->referer());
        }

        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        // If the email and key doesn't match
        if (!$this->Users->validateActivationKey($email, $activationKey)) {
            $this->Flash->error(__('Your account could not be activated.'));
            return $this->redirect('/login');
        }

        // If the user has been activated
        if ($this->Users->activateUser($email, $activationKey)) {
            $this->Flash->success(__('Congratulations! Your account has been activated!'));

            // firing an event: afterActivate
            $_event = new Event('Controller.Users.afterActivate', $this, [
                'email' => $email
            ]);
            $this->eventManager()->dispatch($_event);

            return $this->redirect('/login');
        }

        // If noting happened. Just for safety :)
        $this->Flash->error(__('Your account could not be activated.'));
        return $this->redirect('/login');
    }

    /**
     * Reset password action
     *
     * Users will reach this action when they need to set a new password for their account.
     * This action will set a new password and redirect to the login page
     *
     * # Changing the view:
     *
     * Configure::write('CM.UserViews.reset_password', 'custom/view');
     *
     * @param string $email The e-mailaddress from the user.
     * @param string $activationKey The refering activation key.
     * @return void|\Cake\Network\Response
     */
    public function resetPassword($email, $activationKey = null)
    {
        // If there's no activation_key
        if (!$activationKey) {
            $this->Flash->error(__('Your account could not be activated.'));
            return $this->redirect($this->referer());
        }

        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        // If the email and key doesn't match
        if (!$this->Users->validateActivationKey($email, $activationKey)) {
            $this->Flash->error(__('Your account could not be activated.'));
            return $this->redirect('/login');
        }

        // If we passed and the POST isset
        if ($this->request->is('post')) {
            $data = $this->Users->find()->where([
                'email' => $email,
                'activation_key' => $activationKey,
            ]);

            if ($data->Count() > 0) {
                $data = $data->first();

                $user = $this->Users->patchEntity($data, $this->request->data);

                $user->set('active', 1);
                $user->set('activation_key', null);

                if ($this->Users->save($user)) {
                    // firing an event: afterResetPassword
                    $_event = new Event('Controller.Users.afterResetPassword', $this, [
                        'user' => $user
                    ]);
                    $this->eventManager()->dispatch($_event);

                    $this->Flash->success(__('Your password has been changed.'));
                    return $this->redirect('/login');
                }
            }

            $this->Flash->error(__('Your account could not be activated.'));
        }

        $this->render(Configure::read('CM.UserViews.resetPassword'));
    }

    /**
     * Logout method
     *
     * This method logs the user out and redirects to the login-page.
     * The login-page is chosen by the AuthComponent
     *
     * @return void|\Cake\Network\Response
     */
    public function logout()
    {
        $this->Flash->success(__('You are now logged out.'));
        return $this->redirect($this->Auth->logout());
    }
}
