<?php

namespace CakeManager\Controller\Api;

use CakeManager\Controller\AppController;

class UsersController extends AppController
{

    use \Crud\Controller\ControllerTrait;

    public function initialize() {
        parent::initialize();
        $this->loadComponent('RequestHandler');

        $this->loadComponent('CakeManager.IsAuthorized');

        $this->loadComponent('Crud.Crud', [
            'actions'   => [
                'Crud.view',
                'Crud.edit',
                'Crud.index',
                'Crud.add',
                'Crud.delete'
            ],
            'listeners' => [
                'Crud.Api',
            ]
        ]);

        $this->Auth->allow([]);
    }

    public function isAuthorized($user) {
//
//        $this->Authorizer->action('*', function($auth) {
//            $auth->allowRole(1);
//        });

        $this->Authorizer->action(['view', 'edit'], function($auth) {
            $auth->setRole([1,2,3,4], $this->IsAuthorized->authorize());
        });

        return $this->Authorizer->authorize();
    }

}
