<?php

namespace CakeManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * IsAuthorized component
 */
class IsAuthorizedComponent extends Component
{

    /**
     * Default configuration.
     *
     * @var array
     *
     * ### Options
     * - model      string      is the model to check on, default the default model
     *
     */
    protected $_defaultConfig = [
        'model'   => false,
        'method'  => 'authorize',
        'actions' => ['edit', 'delete'],
        'param'   => 0,
    ];

    /**
     * Constructor
     *
     * @param ComponentRegistry $registry
     * @param array $config
     */
    public function __construct(ComponentRegistry $registry, array $config = array()) {
        parent::__construct($registry, $config);
    }

    /**
     * Initialize the component
     *
     * @param array $config
     */
    public function initialize(array $config) {
        parent::initialize($config);

        $this->Controller = $this->_registry->getController();
    }

    /**
     * The famous and high-tech method to check if a request is authorized to view / edit / or delete
     *
     * Use this method in your controller!
     *
     * You must be sure the IsAuthorized-Behavior is loaded. Use the behaviorIsset-method to check
     *
     * @return true or false
     */
    public function authorize() {

        $controller = $this->Controller;

        // allow all actions except the given actions in the config
        if (!$this->actionIsset()) {
            return true;
        }

        $behavior = $this->getBehavior();

        return call_user_method($this->config('method'), $behavior, $controller->request->params['pass'][$this->config('param')], $controller->Auth->user()
        );
    }

    /**
     * This method checks if the IsAuthorized-behavior isset
     *
     * @param type $controller
     */
    public function behaviorIsset() {

        $controller = $this->Controller;

        if ($this->config('model')) {
            $_model = $this->config('model');
        } else {
            $_model = $controller->name;
        }

        $model = $controller->{$_model};

        if (isset($model->behaviors()->IsAuthorized)) {
            return true;
        }
        return false;
    }

    /**
     * This method returns the current behavior to do some actions
     *
     * @return the class
     */
    protected function getBehavior() {

        $controller = $this->Controller;

        if ($this->behaviorIsset()) {
            if ($this->config('model')) {
                $_model = $this->config('model');
            } else {
                $_model = $controller->name;
            }

            $model = $controller->{$_model};

            return $model->behaviors()->IsAuthorized;
        }

        return false;
    }

    /**
     * This method returns true if the action must be checked.
     *
     * @return boolean
     */
    protected function actionIsset() {

        $controller = $this->Controller;

        $actions = $this->config('actions');

        $action = $controller->request->params['action'];

        if (in_array($action, $actions)) {
            return true;
        }

        return false;
    }

}
