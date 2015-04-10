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

use CakeManager\View\Helper\NavbarMenuHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * CakeManager\View\Helper\MainMenuHelper Test Case
 */
class NavbarMenuHelperTest extends TestCase
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

        $this->NavbarMenuHelper = new NavbarMenuHelper($this->View);
        $this->MenuHelper = new \Utils\View\Helper\MenuHelper($this->View);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->NavbarMenuHelper);

        parent::tearDown();
    }

    /**
     * Test afterMenu method
     *
     * @return void
     */
    public function testBuild()
    {
        $menu = $this->MenuHelper->menu('navbar', 'CakeManager.NavbarMenu');

        $this->assertContains('<ul style="margin-left: 0px">', $menu);
        $this->assertContains('<li style="display: inline; list-style-type: none; padding-right: 20px;">', $menu);
        $this->assertContains('<a href="http://cakemanager.org/docs/1.0/">CakeManager Documentation</a>', $menu);
        $this->assertContains('<a href="https://github.com/bobmulder/cakephp-cakemanager">CakeManager GitHub</a>', $menu);
        $this->assertContains('<a href="http://book.cakephp.org/3.0/">Documentation</a>', $menu);
        $this->assertContains('<a href="http://api.cakephp.org/3.0/">API</a>', $menu);
        $this->assertContains('</li>', $menu);
        $this->assertContains('</ul>', $menu);
    }

    /**
     * Test afterMenu method
     *
     * @return void
     */
    public function testAfterMenu()
    {
        $this->assertEquals('</ul>', $this->NavbarMenuHelper->afterMenu());
    }

    /**
     * Test afterSubItem method
     *
     * @return void
     */
    public function testAfterSubItem()
    {
        $this->assertEquals('', $this->NavbarMenuHelper->afterSubItem());
    }

    /**
     * Test beforeMenu method
     *
     * @return void
     */
    public function testBeforeMenu()
    {
        $this->assertEquals('<ul style="margin-left: 0px">', $this->NavbarMenuHelper->beforeMenu());
    }

    /**
     * Test beforeSubItem method
     *
     * @return void
     */
    public function testBeforeSubItem()
    {
        $this->assertEquals('', $this->NavbarMenuHelper->beforeSubItem());
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

        $expected = '<a href="http://cakemanager.org">CakeManager</a>';

        $this->assertContains($expected, $this->NavbarMenuHelper->item($data));
    }

    /**
     * Test subItem method
     *
     * @return void
     */
    public function testSubItem()
    {
        $this->assertEquals('', $this->NavbarMenuHelper->subItem());
    }

    /**
     * _setMenu
     *
     * @eturn array
     */
    protected function _setMenu()
    {
        return [
            'navbar' => [
                'CakeManager Documentation' => [
                    'id' => 'CakeManager Documentation',
                    'parent' => false,
                    'url' => 'http://cakemanager.org/docs/1.0/',
                    'title' => 'CakeManager Documentation',
                    'icon' => '',
                    'area' => 'navbar',
                    'active' => false,
                    'weight' => 10,
                    0 => ''
                ],
                'CakeManager GitHub' => [
                    'id' => 'CakeManager GitHub',
                    'parent' => false,
                    'url' => 'https://github.com/bobmulder/cakephp-cakemanager',
                    'title' => 'CakeManager GitHub',
                    'icon' => '',
                    'area' => 'navbar',
                    'active' => false,
                    'weight' => 10,
                    0 => ''
                ],
                'Documentation' => [
                    'id' => 'Documentation',
                    'parent' => false,
                    'url' => 'http://book.cakephp.org/3.0/',
                    'title' => 'Documentation',
                    'icon' => '',
                    'area' => 'navbar',
                    'active' => false,
                    'weight' => 10,
                    0 => ''
                ],
                'API' => [
                    'id' => 'API',
                    'parent' => false,
                    'url' => 'http://api.cakephp.org/3.0/',
                    'title' => 'API',
                    'icon' => '',
                    'area' => 'navbar',
                    'active' => false,
                    'weight' => 10,
                    0 => ''
                ]
            ]
        ];
    }
}
