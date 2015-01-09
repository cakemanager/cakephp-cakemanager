<?php

namespace CakeManager\Controller\Admin;

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
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('users', $this->paginate($this->Users->find('all', ['contain' => ['Roles']])));
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

        $roles = $this->Users->Roles->find('list');

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
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
     * Admin action to change someones password
     * 
     * @param type $id
     * @return type
     */
    public function new_password($id = null) {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);


        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been saved.');
                return $this->redirect($this->referer());
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
