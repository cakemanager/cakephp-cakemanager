<?php

namespace CakeManager\View\Helper;

use Cake\View\Helper;
use Cake\View\View;

/**
 * Meta helper
 */
class MetaHelper extends Helper
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
    ];
    public $counter           = 0;

    public function __construct(View $View, array $config = array()) {

        parent::__construct($View, $config);

        $this->View = $View;
    }

    public function form($key = null) {

//        debug($this->_View->viewVars['metaData']);

        $metaData = $this->_View->viewVars['metaData'];

        $html = '';

        if (!$key) {
            foreach ($metaData['fields'] as $key => $settings) {
                $html .= $this->generateField($key, $settings);
                $this->counter++;
            }
        } else {
            if (key_exists($key, $metaData['fields'])) {
                $html .= $this->generateField($key, $metaData['fields'][$key]);
            }
        }


        return $html;
    }

    public function generateField($key, $settings) {

        $html = '';

        $html .= $this->_View->Form->input('metas.' . $this->counter . '.rel_model', [
            'type'  => 'hidden',
            'value' => 'Bookmarks'
        ]);

        $html .= $this->_View->Form->input('metas.' . $this->counter . '.name', [
            'type'  => 'hidden',
            'value' => $key,
        ]);

        $html .= $this->_View->Form->input('metas.' . $this->counter . '.value', $settings);


        return $html;
    }

}
