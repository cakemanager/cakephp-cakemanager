<?php
namespace CakeManager\Test\TestCase\Model\Behavior;

use CakeManager\Model\Behavior\WhoDidItBehavior;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Model\Behavior\WhoDidItBehavior Test Case
 */
class WhoDidItBehaviorTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->WhoDidIt = new WhoDidItBehavior();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->WhoDidIt);

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
