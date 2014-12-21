<?php
namespace CakeManager\Test\TestCase\Model\Table;

use CakeManager\Model\Table\MetasTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Model\Table\MetasTable Test Case
 */
class MetasTableTest extends TestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = [
		'Metas' => 'plugin.cake_manager.metas',
		'Rels' => 'plugin.cake_manager.rels'
	];

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$config = TableRegistry::exists('Metas') ? [] : ['className' => 'CakeManager\Model\Table\MetasTable'];
		$this->Metas = TableRegistry::get('Metas', $config);
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Metas);

		parent::tearDown();
	}

/**
 * Test initialize method
 *
 * @return void
 */
	public function testInitialize() {
		$this->markTestIncomplete('Not implemented yet.');
	}

/**
 * Test validationDefault method
 *
 * @return void
 */
	public function testValidationDefault() {
		$this->markTestIncomplete('Not implemented yet.');
	}

}
