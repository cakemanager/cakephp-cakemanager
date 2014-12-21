<?php

namespace CakeManager\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\ORM\Entity;

/**
 * Meta behavior
 */
class MetaBehavior extends Behavior
{

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'metaTable'            => 'metas',
        'alias'                => null,
        'fields'               => [],
        'defaultFieldSettings' => [
            'type'  => 'text',
            'value' => null,
        ]
    ];

    public function __construct(Table $table, array $config = array()) {
        parent::__construct($table, $config);

        // set the model to use
        $this->Table = $table;

        $this->config('alias', $table->alias());

        $this->convertFields();

        // set the alias

        $this->Table->HasMany('CakeManager.Metas', [
            'foreignKey' => 'rel_id',
            'conditions' => ['Metas.rel_model' => $this->config('alias')]
        ]);
    }

    public function initialize(array $config) {
        parent::initialize($config);

        //initializing
    }

    /**
     * Saves a new key + value
     *
     * @param type $key
     * @param type $value
     */
    public function saveMeta($key, $value) {

    }

    public function beforeSave(Event $event, Entity $entity) {

    }

    public function convertFields() {

        $_fields = $this->config('fields');

        $defaultSettings = $this->config('defaultFieldSettings');

        $fields = [];

        foreach($_fields as $key => $_field) {

            if(is_array($_field)) {
                $key = $key;
                $settings = array_merge($defaultSettings, $_field);

            } else {
                $key = $_field;
                $settings = $defaultSettings;
            }

            $fields[$key] = $settings;


        }

            $this->config('fields', $fields, false);
    }

}
