<?php

namespace CakeManager\Controller\Admin;

use CakeManager\Controller\AppController;

/**
 * Roles Controller
 *
 * @property \CakeManager\Model\Table\RolesTable $Roles
 */
class RolesController extends AppController
{

    public function beforeFilter(\Cake\Event\Event $event) {
        parent::beforeFilter($event);

        $this->Auth->allow([]);
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index() {
        $this->set('roles', $this->paginate($this->Roles));
    }

    /**
     * View method
     *
     * @param string|null $id Role id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function view($id = null) {
        $role = $this->Roles->get($id, [
            'contain' => []
        ]);
        $this->set('role', $role);
    }

    /**
     * Add method
     *
     * @return void
     */
    public function add() {
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
    }

    /**
     * Edit method
     *
     * @param string|null $id Role id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function edit($id = null) {
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
    }

    /**
     * Delete method
     *
     * @param string|null $id Role id
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException
     */
    public function delete($id = null) {
        $role = $this->Roles->get($id);
        $this->request->allowMethod(['post', 'delete']);
        if ($this->Roles->delete($role)) {
            $this->Flash->success('The role has been deleted.');
        } else {
            $this->Flash->error('The role could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }

}
