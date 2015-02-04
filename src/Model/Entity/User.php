<?php

namespace CakeManager\Model\Entity;

use Cake\ORM\Entity;
use Cake\Auth\DefaultPasswordHasher;

/**
 * User Entity.
 */
class User extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'email'            => true,
        'password'         => true,
        'role_id'          => true,
        'confirm_password' => true,
        'new_password'     => true,
        'active'           => true,
        'activation_key'   => true,
    ];

    protected function _setPassword($password) {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($password);
    }

    protected $_hidden = [
        'password'
    ];

}
