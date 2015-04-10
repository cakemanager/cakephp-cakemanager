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
use Cake\Routing\Router;

/**
 * Adding routes for the admin-prefix and CakeManager-Plugin
 */
Router::prefix('admin', function ($routes) {
    $routes->plugin('CakeManager', ['path' => '/manager'], function ($routes) {

        $routes->connect('/pages/*', [
            'prefix'     => 'admin',
            'plugin'     => 'CakeManager',
            'controller' => 'Pages',
            'action'     => 'display',
        ]);

        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});

/**
 * Adding routes for the api-prefix and CakeManager-Plugin
 */
Router::prefix('api', function($routes) {
    $routes->plugin('CakeManager', ['path' => '/'], function ($routes) {

        $routes->extensions(['json']);
        $routes->resources('Roles');
        $routes->resources('Users');

        $routes->fallbacks('InflectedRoute');
    });
});

/*
 * Adding default routes for the CakeManager
 */
Router::plugin('CakeManager', ['path' => '/'], function ($routes) {
    $routes->fallbacks('InflectedRoute');
});

/**
 * Default routes for usersController from the CakeManager
 *
 * Previous:
 * manager/users/request
 *
 * Now:
 * users/request
 *
 */
Router::connect('/users/:action/*', ['plugin' => 'CakeManager', 'prefix' => false, 'controller' => 'Users']);

/**
 * Default register-url
 */
Router::connect('/register', ['plugin' => 'CakeManager', 'prefix' => false, 'controller' => 'Users', 'action' => 'register']);

/**
 * Default login-url
 */
Router::connect('/login', ['plugin' => 'CakeManager', 'prefix' => false, 'controller' => 'Users', 'action' => 'login']);

/**
 * Default admin-url
 */
Router::connect('/admin', ['plugin' => 'CakeManager', 'prefix' => false, 'controller' => 'Users', 'action' => 'login']);

/**
 * Default logout-url
 */
Router::connect('/logout', ['plugin' => 'CakeManager', 'prefix' => false, 'controller' => 'Users', 'action' => 'logout']);
