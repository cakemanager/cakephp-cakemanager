<?php
namespace CakeManager\Test\TestCase\Model\Behavior;

use CakeManager\Model\Behavior\MetaBehavior;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Model\Behavior\MetaBehavior Test Case
 */
class MetaBehaviorTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Meta = new MetaBehavior();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Meta);

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
