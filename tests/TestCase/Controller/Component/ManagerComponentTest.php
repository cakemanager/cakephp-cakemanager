<?php
namespace CakeManager\Test\TestCase\Controller\Component;

use CakeManager\Controller\Component\ManagerComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Controller\Component\ManagerComponent Test Case
 */
class ManagerComponentTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$registry = new ComponentRegistry();
//		$this->Manager = new ManagerComponent($registry);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Manager);

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
