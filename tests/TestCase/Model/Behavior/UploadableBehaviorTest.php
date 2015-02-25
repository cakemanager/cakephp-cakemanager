<?php
namespace CakeManager\Test\TestCase\Model\Behavior;

use CakeManager\Model\Behavior\UploadableBehavior;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Model\Behavior\UploadableBehavior Test Case
 */
class UploadableBehaviorTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->Uploadable = new UploadableBehavior();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Uploadable);

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
