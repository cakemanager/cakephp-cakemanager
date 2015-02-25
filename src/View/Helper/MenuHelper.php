<?php

namespace CakeManager\View\Helper;

use Cake\View\Helper;
use Cake\View\View;
use Cake\Utility\Hash;

/**
 * Menu helper
 */
class MenuHelper extends Helper
{

    public $helpers = [
        'Html'
    ];

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
            'main' => 'CakeManager.MainMenu',
            'navbar' => 'CakeManager.NavBarMenu',
    ];

    public function menu($area, $options = []) {

        $_options = [
            'helper' => $this->config($area),
        ];

        $options = Hash::merge($_options, $options);

        $builder = $this->_View->helpers()->load($options['helper']);

        $menu = $this->_View->viewVars['menu'][$area];

        $html = '';

        $html .= $builder->beforeMenu($menu);

        foreach ($menu as $item):
            $html .= $builder->item($item);
        endforeach;

        $html .= $builder->afterMenu($menu);

        return $html;
    }

}
