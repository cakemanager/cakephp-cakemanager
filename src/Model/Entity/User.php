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
        'email'           => true,
        'password'        => true,
        'bookmarks'       => true,
        'role_id'         => true,
    ];

    protected function _setPassword($password) {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($password);
    }

}
