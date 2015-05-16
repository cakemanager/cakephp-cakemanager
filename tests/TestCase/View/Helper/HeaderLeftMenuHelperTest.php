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
namespace CakeManager\Test\TestCase\View\Helper;

use CakeManager\View\Helper\HeaderLeftMenuHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * CakeManager\View\Helper\MainMenuHelper Test Case
 */
class HeaderLeftMenuHelperTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->View = new View();

        $this->View->set('menu', $this->_setMenu());

        $this->HeaderLeftMenuHelper = new HeaderLeftMenuHelper($this->View);
        $this->MenuHelper = new \Utils\View\Helper\MenuHelper($this->View);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HeaderLeftMenuHelper);

        parent::tearDown();
    }

    /**
     * Test afterMenu method
     *
     * @return void
     */
    public function testBuild()
    {
        $menu = $this->MenuHelper->menu('headerLeft', 'CakeManager.HeaderLeftMenu');

        $this->assertContains('| <a href="/users/logout">Logout</a>', $menu);
    }

    /**
     * Test afterMenu method
     *
     * @return void
     */
    public function testAfterMenu()
    {
        $this->assertEquals('', $this->HeaderLeftMenuHelper->afterMenu());
    }

    /**
     * Test afterSubItem method
     *
     * @return void
     */
    public function testAfterSubItem()
    {
        $this->assertEquals('', $this->HeaderLeftMenuHelper->afterSubItem());
    }

    /**
     * Test beforeMenu method
     *
     * @return void
     */
    public function testBeforeMenu()
    {
        $this->assertEquals('', $this->HeaderLeftMenuHelper->beforeMenu());
    }

    /**
     * Test beforeSubItem method
     *
     * @return void
     */
    public function testBeforeSubItem()
    {
        $this->assertEquals('', $this->HeaderLeftMenuHelper->beforeSubItem());
    }

    /**
     * Test item method
     *
     * @return void
     */
    public function testItem()
    {
        $data = [
            'url' => 'http://cakemanager.org',
            'title' => 'CakeManager'
        ];

        $expected = ' | <a href="http://cakemanager.org">CakeManager</a>';

        $this->assertEquals($expected, $this->HeaderLeftMenuHelper->item($data));
    }

    /**
     * Test subItem method
     *
     * @return void
     */
    public function testSubItem()
    {
        $this->assertEquals('', $this->HeaderLeftMenuHelper->subItem());
    }

    /**
     * _setMenu
     *
     * @eturn array
     */
    protected function _setMenu()
    {
        return [
            'headerLeft' => [
                'Logout' => [
                    'id' => 'Logout',
                    'parent' => false,
                    'url' => [
                        'plugin' => 'CakeManager',
                        'controller' => 'Users',
                        'action' => 'logout',
                        'prefix' => false,
                    ],
                    'title' => 'Logout',
                    'icon' => '',
                    'area' => 'header',
                    'active' => false,
                    'weight' => 10
                ],
            ]
        ];
    }
}
