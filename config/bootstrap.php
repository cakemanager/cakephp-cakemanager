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
use Cake\Core\App;
use Cake\Core\Configure;
use CakeManager\Controller\Event\MailEventListener;

/**
 * Default Session-settings
 */
Configure::write('Session', [
    'defaults' => 'php',
    'timeout' => 2880
]);

/**
 * The Role-definition for CM
 */
Configure::write('CM.Roles', [
    'Administrators' => [1],
    'Moderators' => [2],
    'Users' => [3],
    'Unregistered' => [4],
]);

/**
 * The UserModel to use. Default 'CakeManager.Users'
 */
Configure::write('CM.UserModel', 'CakeManager.Users');

/**
 * CakeManager Version
 */
Configure::write('CM.Version', "1.0.0-RC2");

/**
 * Mail Settings
 */
Configure::write('CM.Mail', [
    'From' => ['noreply@cakemanager.org' => 'CakeManager'],
    'afterLogin' => true,
]);

/**
 * Registration Setting
 */
Configure::write('CM.Register', false);

/**
 * Registration Setting
 */
Configure::write('CM.ActivationOnRegister', true);

/**
 * The UserViews to use
 * Default for the CakeManager itself, you can change it for your own views
 */
Configure::write('CM.UserViews', [
    'register' => 'CakeManager./Users/register',
    'login' => 'CakeManager./Users/login',
    'forgot_password' => 'CakeManager./Users/forgotPassword',
    'reset_password' => 'CakeManager./Users/resetPassword',
]);

/**
 * The UserViews to use for admin-section
 * Default for the CakeManager itself, you can change it for your own views
 */
Configure::write('CM.AdminUserViews', [
    'index' => 'CakeManager./Admin/Users/index',
    'view' => 'CakeManager./Admin/Users/view',
    'add' => 'CakeManager./Admin/Users/add',
    'edit' => 'CakeManager./Admin/Users/edit',
    'new_password' => 'CakeManager./Admin/Users/newPassword',
]);

/**
 * The RoleViews to use for admin-section
 * Default for the CakeManager itself, you can change it for your own views
 */
Configure::write('CM.AdminRoleViews', [
    'index' => 'CakeManager./Admin/Roles/index',
    'view' => 'CakeManager./Admin/Roles/view',
    'add' => 'CakeManager./Admin/Roles/add',
    'edit' => 'CakeManager./Admin/Roles/edit',
]);

Configure::write('CM.UserFields', [
]);

/**
 * Attach the MailEventListener to the event manager
 */
Cake\Event\EventManager::instance()->attach(new MailEventListener());
