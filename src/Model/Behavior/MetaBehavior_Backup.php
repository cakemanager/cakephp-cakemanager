<?php

namespace CakeManager\Model\Behavior;

use Cake\ORM\Behavior;
use Cake\ORM\Table;
use Cake\Event\Event;
use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

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
        ],
        'defaultTableSettings' => [
            'foreignKey' => 'rel_id',
            'table'      => 'metas',
        ]
    ];

    public function __construct(Table $table, array $config = array()) {
        parent::__construct($table, $config);

        // set the model to use
        $this->Table = $table;

        $this->config('alias', $table->alias());

        $this->config('defaultTableSettings.conditions', ['Metas.rel_model' => $this->config('alias')]);

        $this->convertFields();

        // set the alias
//        $this->Table->HasMany('CakeManager.Metas', [
//            'foreignKey' => 'rel_id',
//            'conditions' => ['Metas.rel_model' => $this->config('alias')]
//        ]);

        $this->MetaTable = TableRegistry::get('CakeManager.Metas', $this->config('defaultTableSettings'));
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

//        debug($event);
    }

    public function afterSave($event, $entity) {

        debug($this->config());

        $metaFields = $this->config('fields');

        foreach ($metaFields as $field => $settings) {
            if ($entity->get($field) !== null) {

                debug($event->subject());

                $data = [
                    'rel_model' => $this->config('alias'),
                    'rel_id'    => $entity->get('id'),
                    'name'      => $field,
                    'value'     => $entity->get($field),
                ];

                debug($data);

                $meta = $this->MetaTable->newEntity($data);

                $this->MetaTable->save($meta);
            }
        }
    }

    public function beforeFind($event, $query, $options, $primary) {

        debug($event->subject());

    }

    public function convertFields() {

        $_fields = $this->config('fields');

        $defaultSettings = $this->config('defaultFieldSettings');

        $fields = [];

        foreach ($_fields as $key => $_field) {

            if (is_array($_field)) {
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
