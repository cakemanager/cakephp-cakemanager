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
namespace CakeManager\Test\TestCase\Model\Table;

use CakeManager\Model\Table\UsersTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Model\Table\UsersTable Test Case
 */
class UsersTableTest extends TestCase
{
    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'Users' => 'plugin.cake_manager.users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Users') ? [] : ['className' => 'CakeManager\Model\Table\UsersTable'];
        $this->Users = TableRegistry::get('Users', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Users);

        parent::tearDown();
    }

    /**
     * Test GenerateActivationKey-method
     *
     * GenerateActivationKey generates an unique key
     *
     */
    public function testGenerateActivationKey()
    {
        $data = $this->Users->generateActivationKey();
        $_data = $this->Users->generateActivationKey();

        $this->assertEquals(40, strlen($data));
        $this->assertEquals(40, strlen($_data));
        $this->assertNotEmpty($data);
        $this->assertNotEmpty($_data);
        $this->assertNotEquals($data, $_data);
    }

    /**
     * Test validateActivationKey-method
     *
     * Tests if a key is valid to an user (email)
     *
     */
    public function testValidateActivationKey()
    {
        $activationKey = $this->Users->generateActivationKey();

        $email = 'info@cakemanager.com';

        $_user = [
            'email' => $email,
            'password' => 'cakemanager',
        ];

        $entity = $this->Users->newEntity($_user);

        $entity->set('activation_key', $activationKey);

        $save = $this->Users->save($entity);

        // assert if saved
        $this->assertNotFalse($save);

        // test if key is null
        $this->assertFalse($this->Users->validateActivationKey($email, null));

        // test if key is wrong
        $this->assertFalse($this->Users->validateActivationKey($email, 'wrongActivationKey'));

        // test if email is wrong
        $this->assertFalse($this->Users->validateActivationKey('wrong_email', $activationKey));

        // test if its true
        $this->assertTrue($this->Users->validateActivationKey($email, $activationKey));

        $save->set('activation_key', null);
        $this->Users->save($save);

        // test if key is null
        $this->assertFalse($this->Users->validateActivationKey($email, null));
    }

    /**
     * Test validateActivationKey-method
     *
     * Tests if a key is valid to an user (email)
     *
     */
    public function testActivateUser()
    {
        $activationKey = $this->Users->generateActivationKey();

        $email = 'info@cakemanager.com';

        $_user = [
            'email' => $email,
            'password' => 'cakemanager',
        ];

        $entity = $this->Users->newEntity($_user);

        $entity->set('activation_key', $activationKey);

        $save = $this->Users->save($entity);

        // assert if saved
        $this->assertNotFalse($save);

        // test if key is null
        $this->assertFalse($this->Users->activateUser($email, null));

        // test if key is wrong
        $this->assertFalse($this->Users->activateUser($email, 'wrongActivationKey'));

        // test if email is wrong
        $this->assertFalse($this->Users->activateUser('wrong_email', $activationKey));

        // test if its true
        $this->assertTrue($this->Users->activateUser($email, $activationKey));

        $save->set('activation_key', null);
        $this->Users->save($save);

        // test if key is null
        $this->assertFalse($this->Users->activateUser($email, null));
    }
}
