<?php

namespace CakeManager\Controller\Api;

use CakeManager\Controller\AppController;

class RolesController extends AppController
{

    use \Crud\Controller\ControllerTrait;

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        $this->loadComponent('Crud.Crud', [
            'actions'   => ['Crud.view'],
            'listeners' => [
                'Crud.Api',
            ]
        ]);

        $this->Auth->allow();
        $this->Auth->deny(['index', 'view']);
    }

    public function isAuthorized($user) {

        $this->Authorizer->action('*', function($auth) {
            $auth->allowRole(1);
        });

        return $this->Authorizer->authorize();
    }

}
