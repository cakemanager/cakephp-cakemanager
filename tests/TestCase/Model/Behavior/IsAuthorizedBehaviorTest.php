<?php
namespace CakeManager\Test\TestCase\Model\Behavior;

use CakeManager\Model\Behavior\IsAuthorizedBehavior;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Model\Behavior\IsAuthorizedBehavior Test Case
 */
class IsAuthorizedBehaviorTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->IsAuthorized = new IsAuthorizedBehavior();
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
		$this->markTestIncomplete('Not implemented yet.');
	}

}
