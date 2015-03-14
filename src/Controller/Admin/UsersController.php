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
namespace CakeManager\Controller\Admin;

use CakeManager\Controller\AppController;
use Cake\Core\Configure;

/**
 * Users Controller
 *
 * Manages Admin pages for users.
 *
 */
class UsersController extends AppController
{
    /**
     * Paginating options
     *
     * @var array
     */
    public $paginate = [
        'limit' => 25,
        'order' => [
            'Users.created' => 'asc'
        ]
    ];

    /**
     * beforeFilter Callback
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->loadModel(Configure::read('CM.UserModel'));
    }

    /**
     * isAuthorized method
     *
     * Used for authorization per controller.
     *
     * @param array $user Logged In user.
     * @return bool If user is allowed to the requested action.
     */
    public function isAuthorized($user)
    {
        $this->Authorizer->action(['*'], function ($auth, $user) {
            $auth->allowRole([1]);
        });

        return $this->Authorizer->authorize();
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('users', $this->paginate($this->Users->find('all', ['contain' => ['Roles']])));

        $this->render(Configure::read('CM.AdminUserViews.index'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException Exception if the user couldn't be found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id);
        $this->set('user', $user);

        $this->render(Configure::read('CM.AdminUserViews.view'));
    }

    /**
     * Add method
     *
     * @return void|\Cake\Network\Respose
     */
    public function add()
    {
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
     * @param string|null $id User id.
     * @return void|\Cake\Network\Respose
     * @throws \Cake\Network\Exception\NotFoundException Exception if the user couldn't be found.
     */
    public function edit($id = null)
    {
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
     * New Password method
     *
     * Admin action to change someones password.
     *
     * @param string|null $id User id.
     * @return void|\Cake\Network\Respose
     */
    public function newPassword($id = null)
    {
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

        $this->render(Configure::read('CM.AdminUserViews.newPassword'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return void|\Cake\Network\Respose
     * @throws \Cake\Network\Exception\NotFoundException Exception if the user couldn't be found.
     */
    public function delete($id = null)
    {
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
