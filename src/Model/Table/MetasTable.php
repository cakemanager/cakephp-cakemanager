<?php

namespace CakeManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Event\Event;

/**
 * Metas Model
 */
class MetasTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        $this->table('metas');
        $this->displayField('name');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator instance
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create')
                ->allowEmpty('rel_model')
                ->add('rel_id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('rel_id')
                ->allowEmpty('name')
                ->allowEmpty('value');

        return $validator;
    }

    public function beforeFind($event, $query, $options, $primary) {



    }

}
