<?php
namespace CakeManager\Test\TestCase\View\Helper;

use CakeManager\View\Helper\MenuHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * CakeManager\View\Helper\MenuHelper Test Case
 */
class MenuHelperTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$view = new View();
		$this->Menu = new MenuHelper($view);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Menu);

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
