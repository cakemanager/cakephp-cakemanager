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
namespace CakeManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Event\Event;

/**
 * Manager component
 */
class ManagerComponent extends Component
{
    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'Auth' => [
            'authorize' => 'Controller',
            'userModel' => 'CakeManager.Users',
            'authenticate' => [
                'Form' => [
                    'fields' => [
                        'username' => 'email',
                        'password' => 'password'
                    ],
                    'scope' => ['Users.active' => true],
                ]
            ],
            'logoutRedirect' => [
                'prefix' => false,
                'plugin' => 'CakeManager',
                'controller' => 'Users',
                'action' => 'login'
            ],
            'loginAction' => [
                'prefix' => false,
                'plugin' => 'CakeManager',
                'controller' => 'Users',
                'action' => 'login'
            ],
            'unauthorizedRedirect' => false,
        ],
        'adminTheme' => 'CakeManager',
        'adminLayout' => 'CakeManager.admin',
    ];

    /**
     * The original controller
     * @var type
     */
    public $Controller;

    /**
     * Preset Helpers to load
     * @var type
     */
    public $helpers = [];

    /**
     * Initialize Callback
     *
     * @param array $config Options.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->Controller = $this->_registry->getController();

        if ($this->config('Auth')) {
            $this->Controller->loadComponent('Auth', $this->config('Auth'));
        }

        $this->Controller->loadComponent('Utils.Menu');
    }

    /**
     * setController
     *
     * Setter for the Controller.
     *
     * @param Controller $controller Controller.
     * @return void
     */
    public function setController($controller)
    {
        $this->Controller = $controller;
    }

    /**
     * __loadHelpers
     *
     * Internal method to load all listed helpers.
     *
     * @return void
     */
    private function __loadHelpers()
    {
        // adding the MenuHelper from the Utils Plugin
        $this->Controller->helpers['Utils.Menu'] = [];
    }

    /**
     * Startup Callback
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function startup($event)
    {
        // startup-event
        $_event = new Event('Component.Manager.startup', $this, [
        ]);
        $this->Controller->eventManager()->dispatch($_event);

        if ($this->isPrefix()) {
            $this->_runCallback("startup", $event);

            // startup-event with Prefix
            $this->_runEvent("startup");
        }
    }

    /**
     * BeforeFilter Callback
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeFilter($event)
    {
        $this->Controller->authUser = $this->Controller->Auth->user();

        // beforeFilter-event
        $_event = new Event('Component.Manager.beforeFilter', $this, [
        ]);
        $this->Controller->eventManager()->dispatch($_event);

        // beforeFilter-event for prefixes
        if ($this->isPrefix()) {
            $this->_runCallback("beforeFilter", $event);

            // beforeFilter-event with Prefix
            $this->_runEvent("beforeFilter");
        }

        $this->__loadHelpers();
    }

    /**
     * BeforeRender Callback
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function beforeRender($event)
    {
        $this->Controller->set('authUser', $this->Controller->authUser);

        // beforeRender-event
        $_event = new Event('Component.Manager.beforeRender', $this, [
        ]);
        $this->Controller->eventManager()->dispatch($_event);

        if ($this->isPrefix()) {
            $this->_runCallback("beforeRender", $event);

            // beforeRender-event with Prefix
            $this->_runEvent("beforeRender");
        }
    }

    /**
     * Shutdown Callback
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function shutdown($event)
    {
        // shutdown-event
        $_event = new Event('Component.Manager.shutdown', $this, [
        ]);
        $this->Controller->eventManager()->dispatch($_event);

        if ($this->isPrefix()) {
            $this->_runCallback("shutdown", $event);

            // shutdown-event with Prefix
            $this->_runEvent("shutdown");
        }
    }

    /**
     * Admin BeforeFilter
     *
     * Loads the first menu-items for the admin-area
     * and sets the theme and layout.
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function adminBeforeFilter($event)
    {
        $controller = $this->Controller;
        $controller->Menu->add('Dashboard', [
            'url' => [
                'plugin' => 'CakeManager',
                'prefix' => 'admin',
                'controller' => 'pages',
                'action' => 'dashboard',
            ],
            'weight' => -1,
        ]);

        $controller->Menu->add('Users', [
            'url' => [
                'plugin' => 'CakeManager',
                'prefix' => 'admin',
                'controller' => 'users',
                'action' => 'index',
            ],
            'weight' => 0,
        ]);

        $controller->Menu->add('Roles', [
            'url' => [
                'plugin' => 'CakeManager',
                'prefix' => 'admin',
                'controller' => 'roles',
                'action' => 'index',
            ],
            'weight' => 1,
        ]);

        $controller->Menu->add('Plugins', [
            'url' => [
                'plugin' => 'CakeManager',
                'prefix' => 'admin',
                'controller' => 'pages',
                'action' => 'plugins',
            ],
            'weight' => 1,
        ]);

        $controller->Menu->area('headerLeft');

        if ($controller->authUser) {
            $controller->Menu->add('Logout', [
                'url' => [
                    'plugin' => 'CakeManager',
                    'controller' => 'Users',
                    'action' => 'logout',
                    'prefix' => false,
                ],
                'weight' => 10
            ]);
        } else {
            $controller->Menu->add('Login', [
                'url' => [
                    'plugin' => 'CakeManager',
                    'controller' => 'Users',
                    'action' => 'login',
                    'prefix' => false,
                ],
                'weight' => 10
            ]);
        }

        $controller->Menu->area('header');

        $controller->Menu->add('CakeManager Documentation', [
            'url' => 'http://cakemanager.org/docs/1.0/',
        ]);

        $controller->Menu->add('CakeManager GitHub', [
            'url' => 'https://github.com/bobmulder/cakephp-cakemanager',
        ]);

        $controller->Menu->add('Documentation', [
            'url' => 'http://book.cakephp.org/3.0/',
        ]);

        $controller->Menu->add('API', [
            'url' => 'http://api.cakephp.org/3.0/',
        ]);

        $controller->Menu->area('main');

        $this->Controller->theme = $this->config('adminTheme');
        $this->Controller->layout = $this->config('adminLayout');
    }

    /**
     * Admin BeforeRender
     *
     * Sets the last stuff before an call with the admin-prefix
     *
     * @param \Cake\Event\Event $event Event.
     * @return void
     */
    public function adminBeforeRender($event)
    {
        // setting up the default title-variable for default view
        if (!key_exists('title', $this->Controller->viewVars)) {
            $this->Controller->set('title', $this->Controller->name);
        }
    }

    /**
     * prefix
     *
     * Quick method to check if a specific prefix is set.
     *
     * @param string $expected The expected prefix.
     * @return bool
     */
    public function prefix($expected = null)
    {
        $current = null;

        if ($this->Controller->request->prefix !== null) {
            $current = $this->Controller->request->prefix;
        }

        if ($current == $expected) {
            return true;
        }

        return false;
    }

    /**
     * isPrefix
     *
     * Quick method to check if there is a prefix set
     *
     * @return bool
     */
    public function isPrefix()
    {
        $params = $this->Controller->request->params;
        if (key_exists('prefix', $params)) {
            $prefix = $params['prefix'];
            if ($prefix) {
                return true;
            }
        }
        return false;
    }

    /**
     * getPrefix
     *
     * Quick method to check if there is a prefix set
     *
     * @return bool
     */
    public function getPrefix()
    {
        $params = $this->Controller->request->params;
        if (key_exists('prefix', $params)) {
            $prefix = $params['prefix'];
            if ($prefix) {
                return $prefix;
            }
        }
        return false;
    }

    /**
     * _runCallback
     *
     * This method runs a callback on the current component.
     * This is used for callbacks like `adminBeforeFilter`.
     *
     * @param string $name Name of the callback (without prefix).
     * @param \Cake\Event\Event $event Event from parent event.
     * @param array $options Options.
     * @return void|bool
     */
    protected function _runCallback($name, $event, $options = [])
    {
        if ($this->isPrefix()) {
            $prefix = $this->getPrefix();
            $callback = $prefix . ucfirst($name);
            if (method_exists($this, $callback)) {
                $this->$callback($event);
                return true;
            }
        }
        return false;
    }

    /**
     * _runEvent
     *
     * This method runs an event of the current callback.
     * So when the callback `beforeFilter` is filled under $name,
     * the event `Component.Manager.beforeFilter.admin` would be fired.
     *
     * @param string $name Name of the callback.
     * @param array $params List of params send with the event.
     * @param array $options Options.
     * @return void
     */
    protected function _runEvent($name, $params = [], $options = [])
    {
        $_event = new Event('Component.Manager.' . $name . '.' . $this->getPrefix(), $this, $params);
        $this->Controller->eventManager()->dispatch($_event);
    }
}
