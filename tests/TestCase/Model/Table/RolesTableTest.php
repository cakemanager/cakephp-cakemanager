<?php

namespace CakeManager\Test\TestCase\Model\Table;

use CakeManager\Model\Table\RolesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Model\Table\RolesTable Test Case
 */
class RolesTableTest extends TestCase
{

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Roles' => 'plugin.cake_manager.roles'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Roles') ? [] : ['className' => 'CakeManager\Model\Table\RolesTable'];
        $this->Roles = TableRegistry::get('Roles', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Roles);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testRedirectFrom()
    {

        $result = $this->Roles->redirectFrom(1);

        $this->assertEquals('admin/manager/users', $result);

        $result = $this->Roles->redirectFrom(2);

        $this->assertEquals('/', $result);

    }

}
