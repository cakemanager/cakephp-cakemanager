<?php

namespace CakeManager\Controller\Admin;

use CakeManager\Controller\AppController;
use Cake\Core\Configure;

/**
 * Roles Controller
 *
 * @property \CakeManager\Model\Table\RolesTable $Roles
 */
class RolesController extends AppController
{

    public function beforeFilter(\Cake\Event\Event $event)
    {
        parent::beforeFilter($event);

        $this->Auth->allow([]);
    }

    public function isAuthorized($user)
    {
        $this->Authorizer->action(['*'], function($auth) {
            $this->Authorizer->setRole(1, true);
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
     * @param string|null $id Role id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
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
     * @return void
     */
    public function add()
    {
        $role = $this->Roles->newEntity($this->request->data);
        if ($this->request->is('post')) {
            if ($this->Roles->save($role)) {
                $this->Flash->success('The role has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The role could not be saved. Please, try again.');
            }
        }
        $this->set(compact('role'));

        $this->render(Configure::read('CM.AdminRoleViews.add'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function edit($id = null)
    {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $role = $this->Roles->patchEntity($role, $this->request->data);
            if ($this->Roles->save($role)) {
                $this->Flash->success('The role has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The role could not be saved. Please, try again.');
            }
        }

        $this->set(compact('role'));

        $this->render(Configure::read('CM.AdminRoleViews.edit'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function delete($id = null)
    {
        $role = $this->Roles->get($id);

        $this->request->allowMethod(['post', 'delete']);

        if ($this->Roles->delete($role)) {
            $this->Flash->success('The role has been deleted.');
        } else {
            $this->Flash->error('The role could not be deleted. Please, try again.');
        }

        return $this->redirect(['action' => 'index']);

        $this->render(Configure::read('CM.AdminRoleViews.delete'));
    }

}
