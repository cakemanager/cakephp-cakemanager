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
 * Roles Controller
 *
 * Manages Admin pages for roles.
 *
 */
class RolesController extends AppController
{

    /**
     * beforeFilter Callback
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow([]);
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
        $this->Authorizer->action(['*'], function ($auth) {
            $auth->allowRole(1);
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
        $this->set('roles', $this->paginate($this->Roles));

        $this->render(Configure::read('CM.AdminRoleViews.index'));
    }

    /**
     * View method
     *
     * @param string|null $id Role id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException Exception if the role couldn't be found.
     */
    public function view($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        $this->set('role', $role);

        $this->render(Configure::read('CM.AdminRoleViews.view'));
    }

    /**
     * Add method
     *
     * @return void|\Cake\Network\Response
     */
    public function add()
    {
        $role = $this->Roles->newEntity();
        if ($this->request->is('post')) {
            $role = $this->Roles->patchEntity($role, $this->request->data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('role'));

        $this->render(Configure::read('CM.AdminRoleViews.add'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id.
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException Exception if the role couldn't be found.
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->data);
            if ($this->Roles->save($role)) {
                $this->Flash->success(__('The role has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The role could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('role'));

        $this->render(Configure::read('CM.AdminRoleViews.edit'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id.
     * @return void|\Cake\Network\Response
     * @throws \Cake\Network\Exception\NotFoundException Exception if the role couldn't be found.
     */
    public function delete($id = null)
    {
        $role = $this->Roles->get($id);

        $this->request->allowMethod(['post', 'delete']);

        if ($this->Roles->delete($role)) {
            $this->Flash->success(__('The role has been deleted.'));
        } else {
            $this->Flash->error(__('The role could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
