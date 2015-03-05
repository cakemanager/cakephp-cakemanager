<?php

use Cake\Core\Configure;
use CakeManager\Controller\Event\MailEventListener;

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


Configure::write('CM.Mail', [
    'From' => ['noreply@cakemanager.org' => 'CakeManager']
]);

/**
 * The UserViews to use
 * Default for the CakeManager itself, you can change it for your own views
 */
Configure::write('CM.UserViews', [
    'login'           => 'CakeManager./Users/login',
    'forgot_password' => 'CakeManager./Users/forgot_password',
    'reset_password'  => 'CakeManager./Users/reset_password',
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
    'index' => 'CakeManager./Admin/Roles/index',
    'view'  => 'CakeManager./Admin/Roles/view',
    'add'   => 'CakeManager./Admin/Roles/add',
    'edit'  => 'CakeManager./Admin/Roles/edit',
]);

/**
 * Attach the MailEventListener to the event manager
 */
Cake\Event\EventManager::instance()->attach(new MailEventListener());