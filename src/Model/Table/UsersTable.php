<?php
/**
 * CakeManager (http://cakemanager.org)
 * Copyright (c) http://cakemanager.org
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) http://cakemanager.org
 * @link          http://cakemanager.org CakeManager Project
 * @since         1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace CakeManager\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 */
class UsersTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        $this->table('users');
        $this->displayField('email');
        $this->primaryKey('id');
        $this->addBehavior('Timestamp');

        $this->belongsTo('Roles', [
            'className' => 'CakeManager.Roles',
            'foreignKey' => 'role_id',
            'propertyName' => 'role',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
                ->add('id', 'valid', ['rule' => 'numeric'])
                ->allowEmpty('id', 'create')
                ->add('email', 'valid', ['rule' => 'email'])
                ->requirePresence('email', 'create')
                ->notEmpty('email')
                ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table'])
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

    /**
     * beforeSave Callback
     *
     * @param \Cake\Event\Event $event Event.
     * @param \Cake\ORM\Entity $entity Current entity.
     * @param array $options Options.
     * @return void
     */
    public function beforeSave($event, $entity, $options)
    {
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
    public function generateActivationKey()
    {
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
     * @param string $email E-mailaddress of the user.
     * @param string $activationKey Activation key of the user.
     * @return bool
     */
    public function validateActivationKey($email, $activationKey)
    {
        $query = $this->findByEmailAndActivationKey($email, $activationKey);

        if ($query->Count() > 0) {
            return true;
        }

        return false;
    }

    /**
     * Activates an user
     *
     * @param string $email E-mailaddress of the user.
     * @param string $activationKey Activation key of the user.
     * @return bool
     */
    public function activateUser($email, $activationKey)
    {
        if ($this->validateActivationKey($email, $activationKey)) {
            $user = $this->findByEmailAndActivationKey($email, $activationKey)->first();

            if ($user->active == 0) {
                $user->active = 1;
                $user->activation_key = null;
                if ($this->save($user)) {
                    return true;
                }
            }
        }

        return false;
    }
}
