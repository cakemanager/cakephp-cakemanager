<?php

namespace CakeManager\Test\TestCase\Model\Behavior;

use CakeManager\Model\Behavior\IsAuthorizedBehavior;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Model\Behavior\IsAuthorizedBehavior Test Case
 */
class IsAuthorizedBehaviorTest extends TestCase
{

    public $fixtures = ['plugin.cake_manager.articles'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();

        $this->Model = \Cake\ORM\TableRegistry::get('Articles');
    }

    public function testLoadingBehavior() {

        $this->assertFalse($this->Model->behaviors()->has('IsAuthorized'));

        $this->Model->addBehavior('CakeManager.IsAuthorized');

        $this->assertTrue($this->Model->behaviors()->has('IsAuthorized'));
    }

    public function testAuthorizePass() {

        $this->AssertTrue($this->Model->authorize(1, ['id' => 1]));

        $this->AssertTrue($this->Model->authorize(2, ['id' => 3]));

        $this->AssertTrue($this->Model->authorize(3, ['id' => 1]));
    }

    public function testAuthorizeFail() {

        $this->AssertFalse($this->Model->authorize(1, ['id' => 2]));

        $this->AssertFalse($this->Model->authorize(2, ['id' => 2]));

        $this->AssertFalse($this->Model->authorize(3, ['id' => 2]));
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

}
