<?php

namespace CakeManager\Controller;

use CakeManager\Controller\AppController;

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
        }
        if ($this->authUser) {
            $redirect = $this->Roles->redirectFrom($this->authUser['role_id']);

            return $this->redirect($redirect);
        }
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

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('users', $this->paginate($this->Users));
    }

    /**
     * View method
     *
     * @param string|null $id User id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function view($id = null) {
        $user = $this->Users->get($id, [
            'contain' => ['Bookmarks']
        ]);
        $this->set('user', $user);
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
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $this->set(compact('user', 'roles'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function edit($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The user could not be saved. Please, try again.');
            }
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function delete($id = null) {
        $user = $this->Users->get($id);
        $this->request->allowMethod(['post', 'delete']);
        if ($this->Users->delete($user)) {
            $this->Flash->success('The user has been deleted.');
        } else {
            $this->Flash->error('The user could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

}
