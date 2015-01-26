<?php

namespace CakeManager\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use CakeManager\View\Helper\MenuBuilderInterface;

/**
 * Menu helper
 */
class MainMenuHelper extends Helper implements MenuBuilderInterface
{

    public $helpers = [
        'Html'
    ];

     /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function afterMenu($menu = array(), $options = array()) {
        return '';
    }

    public function afterSubItem($item = array(), $options = array()) {
        return '';
    }

    public function beforeMenu($menu = array(), $options = array()) {
        return '';
    }

    public function beforeSubItem($item = array(), $options = array()) {
        return '';
    }

    public function item($item = array(), $options = array()) {
        $html = '<li ' . ($item['active'] ? 'class="active"' : '') . '>' . $this->Html->link(__($item['title']), $item['url']) . '</li>';
        return $html;
    }

    public function subItem($item = array(), $options = array()) {
        return '';
    }

}
