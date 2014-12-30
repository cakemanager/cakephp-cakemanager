<?php
namespace CakeManager\Test\TestCase\Model\Behavior;

use CakeManager\Model\Behavior\StateableBehavior;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Model\Behavior\StateableBehavior Test Case
 */
class StateableBehaviorTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Stateable = new StateableBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Stateable);

        parent::tearDown();
    }

    /**
     * Test initial setup
     *
     * @return void
     */
    public function testInitialization()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
