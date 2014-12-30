<?php

namespace CakeManager\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Menu helper
 */
class MenuHelper extends Helper {

    public $helpers = [
        'Html'
    ];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    public function menu($area) {

        $menu = $this->_View->viewVars['menu'][$area];

        $html = '';

        foreach ($menu as $item):
            $html .= '<li '.($item['active'] ? 'class="active"' : '').'>' . $this->Html->link(__($item['title']), $item['url']) . '</li>';
        endforeach;

        return $html;
    }

}
