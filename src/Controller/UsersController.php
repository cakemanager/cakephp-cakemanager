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

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);

        $this->Auth->allow(['add', 'logout', 'login']);
    }

    /**
     * Login method
     *
     * @return void
     */
    public function login() {
        $this->loadModel('CakeManager.Roles');

        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                $redirect = $this->Roles->redirectFrom($user['role_id']);

                return $this->redirect($redirect);
            }
            $this->Flash->error('Your username or password is incorrect.');
            return $this->redirect($this->referer());
        }
        if ($this->authUser) {
            $redirect = $this->Roles->redirectFrom($this->authUser['role_id']);

            return $this->redirect($redirect);
        }

        $this->render(Configure::read('CM.UserViews.login'));
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add() {
        $user = $this->Users->newEntity($this->request->data);
        $roles = $this->Users->Roles->find('list');

        if ($this->request->is('post')) {
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'login']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $this->set(compact('user', 'roles'));

    }

    /**
     * Logout method
     *
     * @return type
     */
    public function logout() {
        $this->Flash->success('You are now logged out.');
        return $this->redirect($this->Auth->logout());
    }

}
