<?php
namespace CakeManager\Test\TestCase\Controller\Component;

use CakeManager\Controller\Component\MenuComponent;
use Cake\Controller\ComponentRegistry;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Controller\Component\MenuComponent Test Case
 */
class MenuComponentTest extends TestCase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$registry = new ComponentRegistry();
		$this->Menu = new MenuComponent($registry);
	}

    public function testExisting() {

        $this->assertFalse(false);

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


}
