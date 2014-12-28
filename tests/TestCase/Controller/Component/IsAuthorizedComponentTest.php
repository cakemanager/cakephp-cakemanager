<?php
namespace CakeManager\Test\TestCase\Controller\Component;

use CakeManager\Controller\Component\IsAuthorizedComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Controller\Component\IsAuthorizedComponent Test Case
 */
class IsAuthorizedComponentTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$registry = new ComponentRegistry();
		$this->IsAuthorized = new IsAuthorizedComponent($registry);
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
