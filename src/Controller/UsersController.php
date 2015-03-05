<?php

namespace CakeManager\Controller;

use CakeManager\Controller\AppController;
use Cake\Core\Configure;
use Cake\Event\Event;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{

    /**
     * BeforeFilter Callback
     *
     * @param \Cake\Event\Event $event
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        // Auth-settings: Allows all user-related methods
        $this->Auth->allow(['reset_password', 'forgot_password', 'logout', 'login', 'activate', 'test']);

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
     * Login action
     *
     * # Changing the view:
     *
     * Configure::write('CM.UserViews.login', 'custom/view');
     *
     * @return void
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
            return $this->redirect($this->referer());
        }

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
     * @return type
     */
    public function forgot_password()
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
            return $this->redirect($this->referer());
        }

        $this->render(Configure::read('CM.UserViews.forgot_password'));
    }

    /**
     * Activate action
     *
     * Users will reach this action when they need to activate their account.
     * Ths action will activate the account and redirect to the login-page.
     *
     * @param type $email
     * @param type $activation_key
     */
    public function activate($email, $activation_key = null)
    {

        // If there's no activation_key
        if (!$activation_key) {
            $this->Flash->error(__('Activationkey invalid.') . ' ' . __('Your account could not be activated.'));
            return $this->redirect($this->referer());
        }

        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        // If the email and key doesn't match
        if (!$this->Users->validateActivationKey($email, $activation_key)) {
            $this->Flash->error(__('your e-mailaddress is not linked to your activationkey.') . ' ' . __('Your account could not be activated.'));
            return $this->redirect('/login');
        }

        // If the user has been activated
        if ($this->Users->activateUser($email, $activation_key)) {
            $this->Flash->success(__('Congratulations! Your account has been activated!'));
            return $this->redirect('/login');
        }

        // If noting happened. Safety :)
        $this->Flash->error(__('Something went wrong.') . ' ' . __('Your account could not be activated.'));
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
     * @param type $email
     * @param type $activation_key
     */
    public function reset_password($email, $activation_key = null)
    {
        // If there's no activation_key
        if (!$activation_key) {
            $this->Flash->error(__('Activationkey invalid.') . ' ' . __('Your account could not be activated.'));
            return $this->redirect($this->referer());
        }

        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        // If the email and key doesn't match
        if (!$this->Users->validateActivationKey($email, $activation_key)) {
            $this->Flash->error(__('your e-mailaddress is not linked to your activationkey.') . ' ' . __('Your account could not be activated.'));
            return $this->redirect('/login');
        }

        // If we passed and the POST isset
        if ($this->request->is('post')) {

            $data = $this->Users->find()->where([
                'email'          => $email,
                'activation_key' => $activation_key,
            ]);

            if ($data->Count() > 0) {

                $data = $data->first();

                $user = $this->Users->patchEntity($data, $this->request->data);

                $data->set('active', 1);
                $data->set('activation_key', null);

                if ($this->Users->save($data)) {

                    $this->Flash->success(__('Your password has been saved.'));
                    return $this->redirect('/login');
                }
            }

            $this->Flash->error(__('Someting went wrong. Your password could nog be saved.'));
        }

        $this->render(Configure::read('CM.UserViews.reset_password'));
    }

    /**
     * Logout method
     *
     * This method logs the user out and redirects to the login-page.
     * The login-page is chosen by the AuthComponent
     *
     */
    public function logout()
    {
        $this->Flash->success(__('You are now logged out.'));
        return $this->redirect($this->Auth->logout());
    }

}
