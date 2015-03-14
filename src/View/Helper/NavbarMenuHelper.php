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
namespace CakeManager\View\Helper;

use CakeManager\View\Helper\MenuBuilderInterface;
use Cake\View\Helper;

/**
 * Navbar Menu helper
 *
 * This helper is a template to build up the navbar menu.
 * That's the `navbar` area.
 *
 */
class NavBarMenuHelper extends Helper implements MenuBuilderInterface
{
    /**
     * Used helpers
     *
     * @var array
     */
    public $helpers = [
        'Html'
    ];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * afterMenu
     *
     * Method after the menu has been build.
     *
     * @param array $menu The menu items.
     * @param array $options Options.
     * @return string
     */
    public function afterMenu($menu = array(), $options = array())
    {
        return '</ul>';
    }

    /**
     * afterSubItem
     *
     * Method after a submenu item has been build.
     *
     * @param array $item The menu items.
     * @param array $options Options.
     * @return string
     */
    public function afterSubItem($item = array(), $options = array())
    {
        return '';
    }

    /**
     * beforeMenu
     *
     * Method before the menu has been build.
     *
     * @param array $menu The menu items.
     * @param array $options Options.
     * @return string
     */
    public function beforeMenu($menu = array(), $options = array())
    {
        return '<ul style="margin-left: 0px">';
    }

    /**
     * afterSubItem
     *
     * Method before a submenu item has been build.
     *
     * @param array $item The menu items.
     * @param array $options Options.
     * @return string
     */
    public function beforeSubItem($item = array(), $options = array())
    {
        return '';
    }

    /**
     * item
     *
     * Method to build an menu item.
     *
     * @param array $item The menu item.
     * @param array $options Options.
     * @return string
     */
    public function item($item = array(), $options = array())
    {
        $html = '<li style="display: inline; list-style-type: none; padding-right: 20px;">';
        $html .= ($item['active'] ? '<b>' : '');
        $html .= $this->Html->link(__($item['title']), $item['url']);
        $html .= ($item['active'] ? '</b>' : '');
        $html .= '</li>';
        return $html;
    }

    /**
     * item
     *
     * Method to build an submenu item.
     *
     * @param array $item The menu item.
     * @param array $options Options.
     * @return string
     */
    public function subItem($item = array(), $options = array())
    {
        return '';
    }
}
