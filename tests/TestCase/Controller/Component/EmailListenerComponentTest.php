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
namespace CakeManager\Test\TestCase\Controller\Component;

use CakeManager\Controller\Component\EmailListenerComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Core\Configure;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Controller\Component\EmailListenerComponent Test Case
 */
class EmailListenerComponentTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $registry = new ComponentRegistry();
        $this->EmailListener = new EmailListenerComponent($registry);

        $this->Mail = $this->getMock('Cake\Network\Email\Email', ['send']);

        $this->Mail
            ->expects($this->any())
            ->method('send')
            ->willReturn(true);

        $this->EmailListener->setEmailObject($this->Mail);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmailListener);

        parent::tearDown();
    }

    /**
     * Test implemented events
     *
     * @return void
     */
    public function testImplementedEvents()
    {
        $result = $this->EmailListener->implementedEvents();

        $this->assertArrayHasKey('Controller.Users.afterRegister', $result);
        $this->assertArrayHasKey('Controller.Users.afterActivate', $result);
        $this->assertArrayHasKey('Controller.Users.afterForgotPassword', $result);
        $this->assertArrayHasKey('Controller.Users.afterResetPassword', $result);

        $this->assertEquals($result['Controller.Users.afterRegister'], 'afterRegister');
        $this->assertEquals($result['Controller.Users.afterActivate'], 'afterActivate');
        $this->assertEquals($result['Controller.Users.afterForgotPassword'], 'afterForgotPassword');
        $this->assertEquals($result['Controller.Users.afterResetPassword'], 'afterResetPassword');
    }

    /**
     * Test setMailObject
     *
     * @return void
     */
    public function testSetEmailObject()
    {
        $this->EmailListener->setEmailObject('test');

        $this->assertEquals('test', $this->EmailListener->EmailObject);
    }

    /**
     * Test getMailInstance
     *
     * @return void
     */
    public function testGetMailInstance()
    {
        $result = $this->EmailListener->getMailInstance();

        $this->assertNotNull($result);
    }

    /**
     * Test testActivationFail
     *
     * @return void
     */
    public function testActivationFail()
    {
        Configure::write('CM.Mail.activation', false);

        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->activation($user);

        $this->assertNull($result);
    }

    /**
     * Test testActivation
     *
     * @return void
     */
    public function testActivation()
    {
        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->activation($user);

        $_viewVars = $this->readAttribute($result, '_viewVars');

        $this->assertArrayHasKey('user', $_viewVars);
        $this->assertContains('/users/activate/bob@cakemanager.org/CUSTOMKEY', $_viewVars['activationUrl']);
        $this->assertContains('/login', $_viewVars['loginUrl']);
        $this->assertEquals('CakeManager', $_viewVars['from']);

        $_to = $this->readAttribute($result, '_to');

        $this->assertEquals('bob@cakemanager.org', $_to['bob@cakemanager.org']);

        $this->assertEquals('html', $this->readAttribute($result, '_emailFormat'));

        $this->assertEquals('CakeManager.base', $this->readAttribute($result, '_layout'));

        $this->assertEquals('CakeManager.activation', $this->readAttribute($result, '_template'));

        $_from = $this->readAttribute($result, '_from');

        $this->assertEquals('CakeManager', $_from['no-reply@mymail.com']);

        $this->assertEquals('Activation for CakeManager', $this->readAttribute($result, '_subject'));

        $this->assertNotNull($result);
    }

    /**
     * Test testActivationCustomSettings
     *
     * @return void
     */
    public function testActivationCustomSettings()
    {
        Configure::write('CM.Mail.activation', [
            'subject' => 'Activation for CakeManager Custom',
            'layout' => 'CakeManager.custom',
            'template' => 'CakeManager.activationCustom',
        ]);

        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->activation($user);

        $_viewVars = $this->readAttribute($result, '_viewVars');

        $this->assertArrayHasKey('user', $_viewVars);
        $this->assertContains('/users/activate/bob@cakemanager.org/CUSTOMKEY', $_viewVars['activationUrl']);
        $this->assertContains('/login', $_viewVars['loginUrl']);
        $this->assertEquals('CakeManager', $_viewVars['from']);

        $_to = $this->readAttribute($result, '_to');

        $this->assertEquals('bob@cakemanager.org', $_to['bob@cakemanager.org']);

        $this->assertEquals('html', $this->readAttribute($result, '_emailFormat'));

        $this->assertEquals('CakeManager.custom', $this->readAttribute($result, '_layout'));

        $this->assertEquals('CakeManager.activationCustom', $this->readAttribute($result, '_template'));

        $_from = $this->readAttribute($result, '_from');

        $this->assertEquals('CakeManager', $_from['no-reply@mymail.com']);

        $this->assertEquals('Activation for CakeManager Custom', $this->readAttribute($result, '_subject'));

        $this->assertNotNull($result);
    }

    /**
     * Test testActivationConfirmationFail
     *
     * @return void
     */
    public function testActivationConfirmationFail()
    {
        Configure::write('CM.Mail.activationConfirmation', false);

        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->activationConfirmation($user);

        $this->assertNull($result);
    }

    /**
     * Test testActivationConfirmation
     *
     * @return void
     */
    public function testActivationConfirmation()
    {
        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->activationConfirmation($user);

        $_viewVars = $this->readAttribute($result, '_viewVars');

        $this->assertContains('/login', $_viewVars['loginUrl']);
        $this->assertEquals('CakeManager', $_viewVars['from']);

        $_to = $this->readAttribute($result, '_to');

        $this->assertEquals('bob@cakemanager.org', $_to['bob@cakemanager.org']);

        $this->assertEquals('html', $this->readAttribute($result, '_emailFormat'));

        $this->assertEquals('CakeManager.base', $this->readAttribute($result, '_layout'));

        $this->assertEquals('CakeManager.activationConfirmation', $this->readAttribute($result, '_template'));

        $_from = $this->readAttribute($result, '_from');

        $this->assertEquals('CakeManager', $_from['no-reply@mymail.com']);

        $this->assertEquals('Welcome to CakeManager!', $this->readAttribute($result, '_subject'));

        $this->assertNotNull($result);
    }

    /**
     * Test testActivationConfirmation
     *
     * @return void
     */
    public function testActivationConfirmationCustomSettings()
    {
        Configure::write('CM.Mail.activationConfirmation', [
            'subject' => 'Welcome to CakeManager! Custom',
            'layout' => 'CakeManager.custom',
            'template' => 'CakeManager.activationConfirmationCustom',
        ]);

        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->activationConfirmation($user);

        $_viewVars = $this->readAttribute($result, '_viewVars');

        $this->assertContains('/login', $_viewVars['loginUrl']);
        $this->assertEquals('CakeManager', $_viewVars['from']);

        $_to = $this->readAttribute($result, '_to');

        $this->assertEquals('bob@cakemanager.org', $_to['bob@cakemanager.org']);

        $this->assertEquals('html', $this->readAttribute($result, '_emailFormat'));

        $this->assertEquals('CakeManager.custom', $this->readAttribute($result, '_layout'));

        $this->assertEquals('CakeManager.activationConfirmationCustom', $this->readAttribute($result, '_template'));

        $_from = $this->readAttribute($result, '_from');

        $this->assertEquals('CakeManager', $_from['no-reply@mymail.com']);

        $this->assertEquals('Welcome to CakeManager! Custom', $this->readAttribute($result, '_subject'));

        $this->assertNotNull($result);
    }

    /**
     * Test testForgotPasswordFail
     *
     * @return void
     */
    public function testForgotPasswordFail()
    {
        Configure::write('CM.Mail.forgotPassword', false);

        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->forgotPassword($user);

        $this->assertNull($result);
    }

    /**
     * Test testForgotPassword
     *
     * @return void
     */
    public function testForgotPassword()
    {
        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->forgotPassword($user);

        $_viewVars = $this->readAttribute($result, '_viewVars');

        $this->assertContains('/login', $_viewVars['loginUrl']);
        $this->assertEquals('CakeManager', $_viewVars['from']);

        $_to = $this->readAttribute($result, '_to');

        $this->assertEquals('bob@cakemanager.org', $_to['bob@cakemanager.org']);

        $this->assertEquals('html', $this->readAttribute($result, '_emailFormat'));

        $this->assertEquals('CakeManager.base', $this->readAttribute($result, '_layout'));

        $this->assertEquals('CakeManager.forgotPassword', $this->readAttribute($result, '_template'));

        $_from = $this->readAttribute($result, '_from');

        $this->assertEquals('CakeManager', $_from['no-reply@mymail.com']);

        $this->assertEquals('New password request', $this->readAttribute($result, '_subject'));

        $this->assertNotNull($result);
    }

    /**
     * Test testForgotPassword
     *
     * @return void
     */
    public function testForgotPasswordCustomSettings()
    {
        Configure::write('CM.Mail.forgotPassword', [
            'subject' => 'New password request custom',
            'layout' => 'CakeManager.custom',
            'template' => 'CakeManager.forgotPasswordCustom',
        ]);

        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->forgotPassword($user);

        $_viewVars = $this->readAttribute($result, '_viewVars');

        $this->assertContains('/login', $_viewVars['loginUrl']);
        $this->assertEquals('CakeManager', $_viewVars['from']);

        $_to = $this->readAttribute($result, '_to');

        $this->assertEquals('bob@cakemanager.org', $_to['bob@cakemanager.org']);

        $this->assertEquals('html', $this->readAttribute($result, '_emailFormat'));

        $this->assertEquals('CakeManager.custom', $this->readAttribute($result, '_layout'));

        $this->assertEquals('CakeManager.forgotPasswordCustom', $this->readAttribute($result, '_template'));

        $_from = $this->readAttribute($result, '_from');

        $this->assertEquals('CakeManager', $_from['no-reply@mymail.com']);

        $this->assertEquals('New password request custom', $this->readAttribute($result, '_subject'));

        $this->assertNotNull($result);
    }

    /**
     * Test testPasswordConfirmationFail
     *
     * @return void
     */
    public function testPasswordConfirmationFail()
    {
        Configure::write('CM.Mail.passwordConfirmation', false);

        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->passwordConfirmation($user);

        $this->assertNull($result);
    }

    /**
     * Test testPasswordConfirmation
     *
     * @return void
     */
    public function testPasswordConfirmation()
    {
        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->passwordConfirmation($user);

        $_viewVars = $this->readAttribute($result, '_viewVars');

        $this->assertContains('/login', $_viewVars['loginUrl']);
        $this->assertEquals('CakeManager', $_viewVars['from']);

        $_to = $this->readAttribute($result, '_to');

        $this->assertEquals('bob@cakemanager.org', $_to['bob@cakemanager.org']);

        $this->assertEquals('html', $this->readAttribute($result, '_emailFormat'));

        $this->assertEquals('CakeManager.base', $this->readAttribute($result, '_layout'));

        $this->assertEquals('CakeManager.passwordConfirmation', $this->readAttribute($result, '_template'));

        $_from = $this->readAttribute($result, '_from');

        $this->assertEquals('CakeManager', $_from['no-reply@mymail.com']);

        $this->assertEquals('Password changed', $this->readAttribute($result, '_subject'));

        $this->assertNotNull($result);
    }

    /**
     * Test testPasswordConfirmation
     *
     * @return void
     */
    public function testPasswordConfirmationCustomSettings()
    {
        Configure::write('CM.Mail.passwordConfirmation', [
            'subject' => 'Password changed custom',
            'layout' => 'CakeManager.custom',
            'template' => 'CakeManager.passwordConfirmationCustom',
        ]);

        $user = [
            'id' => 1,
            'role_id' => 1,
            'email' => 'bob@cakemanager.org',
            'active' => 1,
            'activation_key' => 'CUSTOMKEY',
        ];

        $result = $this->EmailListener->passwordConfirmation($user);

        $_viewVars = $this->readAttribute($result, '_viewVars');

        $this->assertContains('/login', $_viewVars['loginUrl']);
        $this->assertEquals('CakeManager', $_viewVars['from']);

        $_to = $this->readAttribute($result, '_to');

        $this->assertEquals('bob@cakemanager.org', $_to['bob@cakemanager.org']);

        $this->assertEquals('html', $this->readAttribute($result, '_emailFormat'));

        $this->assertEquals('CakeManager.custom', $this->readAttribute($result, '_layout'));

        $this->assertEquals('CakeManager.passwordConfirmationCustom', $this->readAttribute($result, '_template'));

        $_from = $this->readAttribute($result, '_from');

        $this->assertEquals('CakeManager', $_from['no-reply@mymail.com']);

        $this->assertEquals('Password changed custom', $this->readAttribute($result, '_subject'));

        $this->assertNotNull($result);
    }
}
