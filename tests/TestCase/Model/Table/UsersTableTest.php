<?php

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

        $activation_key = $this->Users->generateActivationKey();

        $email = 'info@cakemanager.com';

        $_user = [
            'email'    => $email,
            'password' => 'cakemanager',
        ];

        $entity = $this->Users->newEntity($_user);

        $entity->set('activation_key', $activation_key);

        $save = $this->Users->save($entity);

        // assert if saved
        $this->assertNotFalse($save);

        // test if key is null
        $this->assertFalse($this->Users->validateActivationKey($email, null));

        // test if key is wrong
        $this->assertFalse($this->Users->validateActivationKey($email, 'wrongActivationKey'));

        // test if email is wrong
        $this->assertFalse($this->Users->validateActivationKey('wrong_email', $activation_key));

        // test if its true
        $this->assertTrue($this->Users->validateActivationKey($email, $activation_key));

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

        $activation_key = $this->Users->generateActivationKey();

        $email = 'info@cakemanager.com';

        $_user = [
            'email'    => $email,
            'password' => 'cakemanager',
        ];

        $entity = $this->Users->newEntity($_user);

        $entity->set('activation_key', $activation_key);

        $save = $this->Users->save($entity);

        // assert if saved
        $this->assertNotFalse($save);

        // test if key is null
        $this->assertFalse($this->Users->activateUser($email, null));

        // test if key is wrong
        $this->assertFalse($this->Users->activateUser($email, 'wrongActivationKey'));

        // test if email is wrong
        $this->assertFalse($this->Users->activateUser('wrong_email', $activation_key));

        // test if its true
        $this->assertTrue($this->Users->activateUser($email, $activation_key));

        $save->set('activation_key', null);
        $this->Users->save($save);

        // test if key is null
        $this->assertFalse($this->Users->activateUser($email, null));
    }

}
