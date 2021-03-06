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
namespace CakeManager\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * User Entity.
 *
 */
class User extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'email' => true,
        'password' => true,
        'role_id' => false,
        'confirm_password' => true,
        'new_password' => true,
        'active' => false,
        'activation_key' => false,
    ];

    /**
     * _setPassword
     *
     * Setter for the password column.
     * This method will hash the password with the DefaultPasswordHasher class.
     *
     * @param string $password The clean password.
     * @return string
     */
    protected function _setPassword($password)
    {
        $hasher = new DefaultPasswordHasher();

        return $hasher->hash($password);
    }
    
    /**
     * Fields that should be hidden.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
