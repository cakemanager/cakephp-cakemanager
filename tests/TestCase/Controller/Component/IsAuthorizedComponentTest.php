<?php

namespace CakeManager\Test\TestCase\Controller\Component;

use CakeManager\Controller\Component\IsAuthorizedComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;
use Cake\TestSuite\IntegrationTestCase;

/**
 * CakeManager\Controller\Component\IsAuthorizedComponent Test Case
 */
class IsAuthorizedComponentTest extends TestCase
{

    public $fixtures = ['plugin.cake_manager.articles'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();

        // Setup our component and fake test controller
        $collection = new ComponentRegistry();
        $this->IsAuthorized = new IsAuthorizedComponent($collection);

        $this->controller = $this->getMock(
                'Cake\Controller\Controller', ['redirect']
        );

        $session = $this->controller->request->session();

        $session->write('Auth', [
            'User' => [
                'id' => 1,
            ]
        ]);

        $this->controller->request->session($session);

        $this->controller->loadComponent('Auth');

        $this->IsAuthorized->setController($this->controller);

        // creating a test-model
        $this->controller->loadModel('Articles');

        // set the name (the component will find the model this way)
        $this->controller->name = "Articles";
    }

    public function testBehaviorIsset() {

        // assertions
        $this->assertFalse($this->IsAuthorized->behaviorIsset());

        $this->controller->Articles->addBehavior('CakeManager.IsAuthorized');

        $this->assertTrue($this->IsAuthorized->behaviorIsset());
    }

    public function testActionIsset() {

        $this->IsAuthorized->config('actions', null);
        $this->IsAuthorized->config('actions', ['edit', 'delete']);

        // setting the action manually
        $this->controller->request->params['action'] = 'index';
        $this->assertFalse($this->IsAuthorized->actionIsset());

        $this->controller->request->params['action'] = 'view';
        $this->assertFalse($this->IsAuthorized->actionIsset());

        $this->controller->request->params['action'] = 'edit';
        $this->assertTrue($this->IsAuthorized->actionIsset());

        $this->controller->request->params['action'] = 'add';
        $this->assertFalse($this->IsAuthorized->actionIsset());

        $this->controller->request->params['action'] = 'delete';
        $this->assertTrue($this->IsAuthorized->actionIsset());

        // adding our own set of actions
        $this->IsAuthorized->config('actions', ['view']);

        $this->controller->request->params['action'] = 'index';
        $this->assertFalse($this->IsAuthorized->actionIsset());

        $this->controller->request->params['action'] = 'view';
        $this->assertTrue($this->IsAuthorized->actionIsset());

        $this->controller->request->params['action'] = 'edit';
        $this->assertTrue($this->IsAuthorized->actionIsset());

        $this->controller->request->params['action'] = 'add';
        $this->assertFalse($this->IsAuthorized->actionIsset());

        $this->controller->request->params['action'] = 'delete';
        $this->assertTrue($this->IsAuthorized->actionIsset());
    }

    public function testAuthorize() {

        $this->controller->request->params['action'] = 'edit';

        $this->assertTrue($this->IsAuthorized->actionIsset());

        $this->controller->request->params['pass'][0] = '1';
        $this->assertTrue($this->IsAuthorized->authorize());

        $this->controller->request->params['pass'][0] = '2';

        $this->assertFalse($this->IsAuthorized->authorize());

        $this->controller->request->params['pass'][0] = '3';

        $this->assertTrue($this->IsAuthorized->authorize());
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->IsAuthorized);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization() {

    }

}
