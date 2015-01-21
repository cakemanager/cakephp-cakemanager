<?php

use Cake\Routing\Router;

Router::prefix('admin', function ($routes) {
    $routes->plugin('CakeManager', ['path' => '/manager'], function ($routes) {
        $routes->fallbacks('InflectedRoute');
    });
    $routes->fallbacks('InflectedRoute');
});

Router::prefix('api', function($routes) {
    $routes->plugin('CakeManager', ['path' => '/'], function ($routes) {

        $routes->extensions(['json']);
        $routes->resources('Roles');
        $routes->resources('Users');

    });
});


Router::plugin('CakeManager', ['path' => '/manager'], function ($routes) {
    $routes->fallbacks('InflectedRoute');
});


Router::connect('/login', ['plugin' => 'CakeManager', 'prefix' => false, 'controller' => 'Users', 'action' => 'login']);

Router::connect('/admin', ['plugin' => 'CakeManager', 'prefix' => false, 'controller' => 'Users', 'action' => 'login']);

Router::connect('/logout', ['plugin' => 'CakeManager', 'prefix' => false, 'controller' => 'Users', 'action' => 'logout']);
