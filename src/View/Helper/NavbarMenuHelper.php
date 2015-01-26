<?php

namespace CakeManager\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use CakeManager\View\Helper\MenuBuilderInterface;

/**
 * Menu helper
 */
class NavBarMenuHelper extends Helper implements MenuBuilderInterface
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
        return '</ul>';
    }

    public function afterSubItem($item = array(), $options = array()) {
        return '';
    }

    public function beforeMenu($menu = array(), $options = array()) {
        return '<ul style="margin-left: 0px">';
    }

    public function beforeSubItem($item = array(), $options = array()) {
        return '';
    }

    public function item($item = array(), $options = array()) {
        $html = '<li style="display: inline; list-style-type: none; padding-right: 20px;">';
        $html .= ($item['active'] ? '<b>' : '');
        $html .= $this->Html->link(__($item['title']), $item['url']);
        $html .= ($item['active'] ? '</b>' : '');
        $html .= '</li>';
        return $html;
    }

    public function subItem($item = array(), $options = array()) {
        return '';
    }

}
