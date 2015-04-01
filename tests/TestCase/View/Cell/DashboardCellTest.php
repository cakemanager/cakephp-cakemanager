<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeManager\Test\TestCase\View\Cell;

use Cake\TestSuite\TestCase;

/**
 * CakeManager\View\Cell\DashboardCell Test Case
 */
class DashboardCellTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->request = $this->getMock('Cake\Network\Request');
        $this->response = $this->getMock('Cake\Network\Response');
        $this->View = new \Cake\View\View($this->request, $this->response);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->View);

        parent::tearDown();
    }

    /**
     * testDisplay
     *
     * @return void
     */
    public function testDisplay()
    {
        $cell = $this->View->cell('CakeManager.Dashboard::Welcome');
        $render = "{$cell}";

        $this->assertEquals('welcome', $cell->template);
        $this->assertContains('<h4>Welcome by the CakeManager</h4>', $render);
    }

    public function testLatestPosts()
    {
        $cell = $this->View->cell('CakeManager.Dashboard::LatestPosts');
        $render = "{$cell}";

        $this->assertEquals('latest_posts', $cell->template);
        $this->assertContains('<h4>Latest Posts</h4>', $render);
    }

    public function testGettingStarted()
    {
        $cell = $this->View->cell('CakeManager.Dashboard::GettingStarted');
        $render = "{$cell}";

        $this->assertEquals('getting_started', $cell->template);
        $this->assertContains('<h4>Getting Started</h4>', $render);
    }

    public function testGettingHelp()
    {
        $cell = $this->View->cell('CakeManager.Dashboard::GettingHelp');
        $render = "{$cell}";

        $this->assertEquals('getting_help', $cell->template);
        $this->assertContains('<h4>Getting Help</h4>', $render);
    }

    public function testPlugins()
    {
        $cell = $this->View->cell('CakeManager.Dashboard::Plugins');
        $render = "{$cell}";

        $this->assertEquals('plugins', $cell->template);
        $this->assertContains('<h4>Useful Plugins from the CakeManager Team</h4>', $render);
    }
}
