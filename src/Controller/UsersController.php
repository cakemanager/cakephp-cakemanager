<?php

namespace CakeManager\Controller;

use CakeManager\Controller\AppController;
use Cake\Core\Configure;

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
        $this->Auth->allow(['new_password', 'request', 'logout', 'login', 'activate']);

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
     * Login method
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

                return $this->redirect($redirect);
            }
            $this->Flash->error(__('Your username or password is incorrect.'));
            return $this->redirect($this->referer());
        }

        // Render the view. The view-file can be changed via Configure::write('CM.UserViews.login
        $this->render(Configure::read('CM.UserViews.login'));
    }

    /**
     * Requests a new activation for the user.
     * Needs an e-mailaddress to request its account.
     *
     * @return type
     */
    public function request()
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
                }
            }

            $this->Flash->success(__('We have requested your account. Check your e-mailaddress to activate your account.'));
            return $this->redirect($this->referer());
        }
    }

    /**
     * Activates a new account
     *
     * User will receive an email with this url.
     *
     * URL-example
     *
     * mywebsite.com/users/activate/user{at}email.com/{its_activation_key}
     *
     * User will be redirected to the login-page
     *
     * @param type $email
     * @param type $activation_key
     * @return type
     */
    public function activate($email, $activation_key = null)
    {

        if (!$activation_key) {
            $this->Flash->error(__('Activationkey invalid.') . ' ' . __('Your account could not be activated.'));
            return $this->redirect($this->referer());
        }

        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        if (!$this->Users->validateActivationKey($email, $activation_key)) {
            $this->Flash->error(__('No your e-mailaddress is not linked to your activationkey.') . ' ' . __('Your account could not be activated.'));
            return $this->redirect('/login');
        }

        if ($this->Users->activateUser($email, $activation_key)) {
            $this->Flash->success(__('Congratulations! Your account has been activated!'));
            return $this->redirect('/login');
        }

        $this->Flash->error(__('Something went wrong.') . ' ' . __('Your account could not be activated.'));
        return $this->redirect('/login');
    }

    /**
     * Sets a new password
     *
     * User will receive an email with this url.
     *
     * URL-example
     *
     * mywebsite.com/users/new_password/user{at}email.com/{its_activation_key}
     *
     * @param type $email
     * @param type $activation_key
     * @return type
     */
    public function new_password($email, $activation_key = null)
    {
        if (!$activation_key) {
            $this->Flash->error(__('Someting went wrong. Your password could nog be saved.'));
            return $this->redirect($this->referer());
        }

        // Redirect if user is already logged in
        if ($this->authUser) {
            return $this->redirect('/login');
        }

        if (!$this->Users->validateActivationKey($email, $activation_key)) {
            $this->Flash->error(__('You are not allowed to set a new password'));
            return $this->redirect($this->referer());
        }

        if ($this->request->is('post')) {

            $data = $this->Users->find()->where([
                'email'          => $email,
                'activation_key' => $activation_key,
            ]);

            if ($data->Count() > 0) {

                $data = $data->first();

                $this->request->data['activation_key'] = null;
                $this->request->data['active'] = 1;

                $user = $this->Users->patchEntity($data, $this->request->data);

                if ($this->Users->save($user)) {

                    $this->Flash->success(__('Your password has been saved.'));
                    return $this->redirect('/login');
                }
            }

            $this->Flash->error(__('Someting went wrong. Your password could nog be saved.'));
            return $this->redirect($this->referer());
        }
    }

    /**
     * Logout method
     *
     * @return type
     */
    public function logout()
    {
        $this->Flash->success(__('You are now logged out.'));
        return $this->redirect($this->Auth->logout());
    }

}
