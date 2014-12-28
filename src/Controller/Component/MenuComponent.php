<?php

namespace CakeManager\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;

/**
 * Menu component
 */
class MenuComponent extends Component {

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

    /**
     * The current area
     * @var type
     */
    protected $area = 'main';

    /**
     * The overall data of the whole menu
     * @var type
     */
    protected static $data = ['main' => []];
    private $Controller    = null;

    public function initialize(array $config) {
        parent::initialize($config);

        $this->Controller = $this->_registry->getController();
    }

    /**
     * Method to set or get the current area
     * Leave empty to get the current area
     * Set with a string to set a new area
     *
     * @param type $area
     * @return type
     */
    public function area($area = null) {
        if ($area) {
            $this->area = $arae;
        }
        return $this->area;
    }

    /**
     * Returns the menu-data of a specific area, or full data if area is not set
     *
     * @param string $area
     * @return array menu-data
     */
    public function getMenu($area = null) {

        if (!key_exists($area, self::$data)) {
            return self::$data;
        } else {
            return self::$data[$area];
        }
    }

    /**
     *
     * @param type $title
     * @param type $item
     *
     * ### OPTIONS
     * - id
     * - parent
     * - url
     * - title
     * - icon
     * - area
     */
    public function add($title, $item = array()) {

        $list = self::$data;

        $_item = [
            'id'     => $title,
            'parent' => false,
            'url'    => '#',
            'title'  => $title,
            'icon'   => '',
            'area'   => false,
        ];

        $item = array_merge($_item, $item);

        if ($item['area']) {
            $this->area = $item['area'];
        }

        self::$data[$this->area][$item['id']] = $item;
    }

    public function remove($id, $options = array()) {

        $_options = [
            'area' => false,
        ];

        $options = array_merge($_options, $options);

        if ($options['area']) {
            $this->area = $item['area'];
        }

        unset(self::$data[$this->area][$id]);
    }

    public function beforeRender() {

        $this->Controller->set('menu', self::$data);
    }

}
