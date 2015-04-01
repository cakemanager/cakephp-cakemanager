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

use CakeManager\View\Helper\MainMenuHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * CakeManager\View\Helper\MainMenuHelper Test Case
 */
class MainMenuHelperTest extends TestCase
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

        $this->MainMenuHelper = new MainMenuHelper($this->View);
        $this->MenuHelper = new \Utils\View\Helper\MenuHelper($this->View);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MainMenuHelper);

        parent::tearDown();
    }

    /**
     * Test afterMenu method
     *
     * @return void
     */
    public function testBuild()
    {
        $menu = $this->MenuHelper->menu('main', 'CakeManager.MainMenu');

        $this->assertContains('<li class="active"><a href="/admin/manager/pages/dashboard">Dashboard</a></li>', $menu);
        $this->assertContains('<li ><a href="/admin/manager/users">Users</a></li>', $menu);
        $this->assertContains('<li ><a href="/admin/manager/roles">Roles</a></li>', $menu);
        $this->assertContains('<li ><a href="/admin/manager/pages/plugins">Plugins</a></li>', $menu);
    }

    /**
     * Test afterMenu method
     *
     * @return void
     */
    public function testAfterMenu()
    {
        $this->assertEquals('', $this->MainMenuHelper->afterMenu());
    }

    /**
     * Test afterSubItem method
     *
     * @return void
     */
    public function testAfterSubItem()
    {
        $this->assertEquals('', $this->MainMenuHelper->afterSubItem());
    }

    /**
     * Test beforeMenu method
     *
     * @return void
     */
    public function testBeforeMenu()
    {
        $this->assertEquals('', $this->MainMenuHelper->beforeMenu());
    }

    /**
     * Test beforeSubItem method
     *
     * @return void
     */
    public function testBeforeSubItem()
    {
        $this->assertEquals('', $this->MainMenuHelper->beforeSubItem());
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
            'title' => 'CakeManager',
            'active' => true
        ];

        $expected = '<li class="active"><a href="http://cakemanager.org">CakeManager</a></li>';

        $this->assertEquals($expected, $this->MainMenuHelper->item($data));

        $data = [
            'url' => 'http://cakemanager.org',
            'title' => 'CakeManager',
            'active' => false
        ];

        $expected = '<li ><a href="http://cakemanager.org">CakeManager</a></li>';

        $this->assertEquals($expected, $this->MainMenuHelper->item($data));
    }

    /**
     * Test subItem method
     *
     * @return void
     */
    public function testSubItem()
    {
        $this->assertEquals('', $this->MainMenuHelper->subItem());
    }

    /**
     * _setMenu
     *
     * @eturn array
     */
    protected function _setMenu()
    {
        return [
            'main' => [
                'Dashboard' => [
                    'id' => 'Dashboard',
                    'parent' => false,
                    'url' => [
                        'plugin' => 'CakeManager',
                        'prefix' => 'admin',
                        'controller' => 'pages',
                        'action' => 'dashboard'
                    ],
                    'title' => 'Dashboard',
                    'icon' => '',
                    'area' => 'main',
                    'active' => true,
                    'weight' => -1,
                    0 => ''
                ],
                'Users' => [
                    'id' => 'Users',
                    'parent' => false,
                    'url' => [
                        'plugin' => 'CakeManager',
                        'prefix' => 'admin',
                        'controller' => 'users',
                        'action' => 'index'
                    ],
                    'title' => 'Users',
                    'icon' => '',
                    'area' => 'main',
                    'active' => false,
                    'weight' => 0,
                    0 => ''
                ],
                'Roles' => [
                    'id' => 'Roles',
                    'parent' => false,
                    'url' => [
                        'plugin' => 'CakeManager',
                        'prefix' => 'admin',
                        'controller' => 'roles',
                        'action' => 'index'
                    ],
                    'title' => 'Roles',
                    'icon' => '',
                    'area' => 'main',
                    'active' => false,
                    'weight' => 1,
                    0 => ''
                ],
                'Plugins' => [
                    'id' => 'Plugins',
                    'parent' => false,
                    'url' => [
                        'plugin' => 'CakeManager',
                        'prefix' => 'admin',
                        'controller' => 'pages',
                        'action' => 'plugins'
                    ],
                    'title' => 'Plugins',
                    'icon' => '',
                    'area' => 'main',
                    'active' => false,
                    'weight' => 1,
                    0 => ''
                ],
            ],
        ];
    }
}
