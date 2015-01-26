<?php
namespace CakeManager\Test\TestCase\Shell;

use CakeManager\Shell\ManagerShell;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Shell\ManagerShell Test Case
 */
class ManagerShellTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMock('Cake\Console\ConsoleIo');
        $this->Manager = new ManagerShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Manager);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
