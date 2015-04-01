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

use CakeManager\View\Helper\HeaderMenuHelper;
use Cake\TestSuite\TestCase;
use Cake\View\View;

/**
 * CakeManager\View\Helper\MainMenuHelper Test Case
 */
class HeaderMenuHelperTest extends TestCase
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

        $this->HeaderMenuHelper = new HeaderMenuHelper($this->View);
        $this->MenuHelper = new \Utils\View\Helper\MenuHelper($this->View);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HeaderMenuHelper);

        parent::tearDown();
    }

    /**
     * Test afterMenu method
     *
     * @return void
     */
    public function testBuild()
    {
        $menu = $this->MenuHelper->menu('header', 'CakeManager.HeaderMenu');

        $this->assertContains('<div class="header-help">', $menu);
        $this->assertContains('<span><a target="_blank" href="http://cakemanager.org/docs/1.0/">CakeManager Documentation</a></span>', $menu);
        $this->assertContains('<span><a target="_blank" href="https://github.com/bobmulder/cakephp-cakemanager">CakeManager GitHub</a></span>', $menu);
        $this->assertContains('<span><a target="_blank" href="http://book.cakephp.org/3.0/">Documentation</a></span>', $menu);
        $this->assertContains('<span><a target="_blank" href="http://api.cakephp.org/3.0/">API</a></span>', $menu);
        $this->assertContains('</div>', $menu);
    }

    /**
     * Test afterMenu method
     *
     * @return void
     */
    public function testAfterMenu()
    {
        $this->assertEquals('</div>', $this->HeaderMenuHelper->afterMenu());
    }

    /**
     * Test afterSubItem method
     *
     * @return void
     */
    public function testAfterSubItem()
    {
        $this->assertEquals('', $this->HeaderMenuHelper->afterSubItem());
    }

    /**
     * Test beforeMenu method
     *
     * @return void
     */
    public function testBeforeMenu()
    {
        $this->assertEquals('<div class="header-help">', $this->HeaderMenuHelper->beforeMenu());
    }

    /**
     * Test beforeSubItem method
     *
     * @return void
     */
    public function testBeforeSubItem()
    {
        $this->assertEquals('', $this->HeaderMenuHelper->beforeSubItem());
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

        $expected = '<span><a target="_blank" href="http://cakemanager.org">CakeManager</a></span>';

        $this->assertEquals($expected, $this->HeaderMenuHelper->item($data));
    }

    /**
     * Test subItem method
     *
     * @return void
     */
    public function testSubItem()
    {
        $this->assertEquals('', $this->HeaderMenuHelper->subItem());
    }

    /**
     * _setMenu
     *
     * @eturn array
     */
    protected function _setMenu()
    {
        return [
            'header' => [
                'CakeManager Documentation' => [
                    'id' => 'CakeManager Documentation',
                    'parent' => false,
                    'url' => 'http://cakemanager.org/docs/1.0/',
                    'title' => 'CakeManager Documentation',
                    'icon' => '',
                    'area' => 'header',
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
                    'area' => 'header',
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
                    'area' => 'header',
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
                    'area' => 'header',
                    'active' => false,
                    'weight' => 10,
                    0 => ''
                ]
            ]
        ];
    }
}
