<?php

namespace CakeManager\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
        $this->table('users');
        $this->displayField('email');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');

        $this->addBehavior('CakeManager.IsAuthorized', [
            'field' => 'id',
        ]);

        $this->belongsTo('Roles', [
            'className'    => 'CakeManager.Roles',
            'foreignKey'   => 'role_id',
            'propertyName' => 'role',
        ]);
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
                ->add('email', 'valid', ['rule' => 'email'])
                ->requirePresence('email', 'create')
                ->notEmpty('email')
                ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
                ->requirePresence('password', 'create')
                ->notEmpty('password');

        $validator->add('new_password', 'custom', [
            'rule' => function ($value, $context) {

                if ($value !== $context['data']['confirm_password']) {
                    return false;
                }
                return true;
            },
            'message' => 'Passwords are not equal!',
        ]);

        $validator->add('confirm_password', 'custom', [
            'rule' => function ($value, $context) {

                if ($value !== $context['data']['new_password']) {
                    return false;
                }
                return true;
            },
            'message' => 'Passwords are not equal!',
        ]);


        return $validator;
    }

    public function beforeSave($event, $entity, $options) {

        if (!empty($entity->new_password)) {
            $entity->password = $entity->new_password; // set for password-changes
        }
    }

    /**
     * This method generates an activation key for a new user.
     * This key will be mailed at the user so he can activate it's account.
     * For activation is needed: e-mail and activation-key
     *
     * @return string
     */
    public function generateActivationKey() {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $activationKey = '';
        for ($i = 0; $i < 40; $i++) {
            $activationKey .= $characters[rand(0, $charactersLength - 1)];
        }
        return $activationKey;
    }

    /**
     * Checks if an user is allowed to do an action with a required activation-key
     *
     * User-data: e-mailaddress
     *
     * @param type $email
     * @param type $activation_key
     * @return boolean
     */
    public function validateActivationKey($email, $activation_key) {

        $query = $this->findByEmailAndActivationKey($email, $activation_key);

        if ($query->Count() > 0) {
            return true;
        }

        return false;
    }

    public function activateUser($email, $activation_key) {

        if ($this->validateActivationKey($email, $activation_key)) {


            $user = $this->findByEmailAndActivationKey($email, $activation_key)->first();

            if ($user->active == 0) {
                $user->active = 1;
                $user->activation_key = null;
                if($this->save($user)) {
                    return true;
                }
            }
        }

        return false;
    }

}
