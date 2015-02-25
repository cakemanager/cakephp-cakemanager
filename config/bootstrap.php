<?php

use Cake\Core\Configure;

/**
 * Default Session-settings
 */
Configure::write('Session', [
    'defaults' => 'php',
    'timeout'  => 2880
]);

/**
 * The Role-definition for CM
 */
Configure::write('CM.Roles', [
    'Administrators' => [1],
    'Moderators'     => [2],
    'Users'          => [3],
    'Unregistered'   => [4],
]);

/**
 * The UserModel to use. Default 'CakeManager.Users'
 */
Configure::write('CM.UserModel', 'CakeManager.Users');

/**
 * The UserViews to use
 * Default for the CakeManager itself, you can change it for your own views
 */
Configure::write('CM.UserViews', [
    'login' => 'CakeManager./Users/login',
]);

/**
 * The UserViews to use for admin-section
 * Default for the CakeManager itself, you can change it for your own views
 */
Configure::write('CM.AdminUserViews', [
    'index'        => 'CakeManager./Admin/Users/index',
    'view'         => 'CakeManager./Admin/Users/view',
    'add'          => 'CakeManager./Admin/Users/add',
    'edit'         => 'CakeManager./Admin/Users/edit',
    'new_password' => 'CakeManager./Admin/Users/new_password',
]);

/**
 * The RoleViews to use for admin-section
 * Default for the CakeManager itself, you can change it for your own views
 */
Configure::write('CM.AdminRoleViews', [
    'index'        => 'CakeManager./Admin/Roles/index',
    'view'         => 'CakeManager./Admin/Roles/view',
    'add'          => 'CakeManager./Admin/Roles/add',
    'edit'         => 'CakeManager./Admin/Roles/edit',
]);