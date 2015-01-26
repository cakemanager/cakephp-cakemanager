<?php

namespace CakeManager\Controller\Admin;

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

        $this->loadModel(Configure::read('CM.UserModel'));

    }

    public function isAuthorized($user) {

        $this->Authorizer->action(['*'], function($auth, $user) {
            $auth->allowRole([1]);
        });

        $this->Authorizer->action(['view'], function($auth, $user) {
            $auth->allowRole([1]);
        });

        $this->Authorizer->action(['edit'], function($auth, $user) {

        });

        return $this->Authorizer->authorize();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('users', $this->paginate($this->Users->find('all', ['contain' => ['Roles']])));

        $this->render(Configure::read('CM.AdminUserViews.index'));
    }

    /**
     * View method
     *
     * @param string|null $id User id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function view($id = null) {
        $user = $this->Users->get($id);
        $this->set('user', $user);

        $this->render(Configure::read('CM.AdminUserViews.view'));
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

        $this->render(Configure::read('CM.AdminUserViews.add'));
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

        $this->render(Configure::read('CM.AdminUserViews.edit'));
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

        $this->render(Configure::read('CM.AdminUserViews.new_password'));
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
