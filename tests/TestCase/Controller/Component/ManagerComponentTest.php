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

use CakeManager\Controller\Component\ManagerComponent;
use Cake\Controller\ComponentRegistry;
use Cake\Event\Event;
use Cake\Network\Request;
use Cake\Network\Response;
use Cake\TestSuite\TestCase;

/**
 * CakeManager\Controller\Component\ManagerComponent Test Case
 */
class ManagerComponentTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->Manager = $this->setUpRequest([
            'prefix' => null,
            'plugin' => 'cakemanager',
            'controller' => 'users',
            'action' => 'index'
        ]);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Manager);

        parent::tearDown();
    }

    /**
     * Test startup event
     *
     * @return void
     */
    public function testStartupEvent()
    {
        // Setup our component and fake test controller
        $request = new Request(['params' => [
                'prefix' => 'admin',
                'plugin' => 'cakemanager',
                'controller' => 'users',
                'action' => 'index'
        ]]);
        $response = new Response();

        $eventManager = $this->getMock('Cake\Event\EventManager', ['dispatch']);

        $this->controller = $this->getMock('Cake\Controller\Controller', ['redirect'], [$request, $response, null, $eventManager]);

        $eventManager->expects($this->at(0))->method('dispatch')
            ->with($this->logicalAnd($this->isInstanceOf('Cake\Event\Event'), $this->attributeEqualTo('_name', 'Component.Manager.startup')))
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $eventManager->expects($this->at(1))->method('dispatch')
            ->with($this->logicalAnd($this->isInstanceOf('Cake\Event\Event'), $this->attributeEqualTo('_name', 'Component.Manager.startup.admin')))
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $registry = new ComponentRegistry($this->controller);

        $manager = $this->getMock('CakeManager\Controller\Component\ManagerComponent', ['adminStartup'], [$registry]);

        $manager->expects($this->once())->method('adminStartup');

        $event = new Event('Controller.startup', $this->controller);

        $manager->startup($event);
    }

    /**
     * Test beforeFilter event
     *
     * @return void
     */
    public function testBeforeFilterEvent()
    {
        // Setup our component and fake test controller
        $request = new Request(['params' => [
                'prefix' => 'admin',
                'plugin' => 'cakemanager',
                'controller' => 'users',
                'action' => 'index'
        ]]);
        $response = new Response();

        $eventManager = $this->getMock('Cake\Event\EventManager', ['dispatch']);

        $this->controller = $this->getMock('Cake\Controller\Controller', ['redirect'], [$request, $response, null, $eventManager]);

        $eventManager->expects($this->at(0))->method('dispatch')
            ->with($this->logicalAnd($this->isInstanceOf('Cake\Event\Event'), $this->attributeEqualTo('_name', 'Component.Manager.beforeFilter')))
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $eventManager->expects($this->at(1))->method('dispatch')
            ->with($this->logicalAnd($this->isInstanceOf('Cake\Event\Event'), $this->attributeEqualTo('_name', 'Component.Manager.beforeFilter.admin')))
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $registry = new ComponentRegistry($this->controller);

        $manager = $this->getMock('CakeManager\Controller\Component\ManagerComponent', ['adminBeforeFilter'], [$registry]);

        $manager->expects($this->once())->method('adminBeforeFilter');

        $event = new Event('Controller.beforeFilter', $this->controller);

        $manager->beforeFilter($event);
    }

    /**
     * Test adminBeforeFilter event
     *
     * @return void
     */
    public function testAdminBeforeFilterEvent()
    {
        // Setup our component and fake test controller
        $request = new Request(['params' => [
                'prefix' => 'admin',
                'plugin' => 'cakemanager',
                'controller' => 'users',
                'action' => 'index'
        ]]);
        $response = new Response();

        $eventManager = $this->getMock('Cake\Event\EventManager', ['dispatch']);

        $this->controller = $this->getMock('Cake\Controller\Controller', ['redirect'], [$request, $response, null, $eventManager]);

        $event = new Event('Controller.adminBeforeFilter', $this->controller);

        $this->Manager->Controller->Menu->clear();
        
        $expected = ['main' => []];

        $this->assertEquals($expected, $this->Manager->Controller->Menu->getMenu());

        $this->Manager->adminBeforeFilter($event);

        $this->assertNotEquals($expected, $this->Manager->Controller->Menu->getMenu());
    }

    /**
     * Test beforeRender event
     *
     * @return void
     */
    public function testBeforeRenderEvent()
    {
        // Setup our component and fake test controller
        $request = new Request(['params' => [
                'prefix' => 'admin',
                'plugin' => 'cakemanager',
                'controller' => 'users',
                'action' => 'index'
        ]]);
        $response = new Response();

        $eventManager = $this->getMock('Cake\Event\EventManager', ['dispatch']);

        $this->controller = $this->getMock('Cake\Controller\Controller', ['redirect'], [$request, $response, null, $eventManager]);

        $eventManager->expects($this->at(0))->method('dispatch')
            ->with($this->logicalAnd($this->isInstanceOf('Cake\Event\Event'), $this->attributeEqualTo('_name', 'Component.Manager.beforeRender')))
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $eventManager->expects($this->at(1))->method('dispatch')
            ->with($this->logicalAnd($this->isInstanceOf('Cake\Event\Event'), $this->attributeEqualTo('_name', 'Component.Manager.beforeRender.admin')))
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $registry = new ComponentRegistry($this->controller);

        $manager = $this->getMock('CakeManager\Controller\Component\ManagerComponent', ['adminBeforeRender'], [$registry]);

        $manager->expects($this->once())->method('adminBeforeRender');

        $event = new Event('Controller.beforeRender', $this->controller);

        $manager->beforeRender($event);
    }

    /**
     * Test adminBeforeRender event
     *
     * @return void
     */
    public function testAdminBeforeRenderEvent()
    {
        // Setup our component and fake test controller
        $request = new Request(['params' => [
                'prefix' => 'admin',
                'plugin' => 'cakemanager',
                'controller' => 'users',
                'action' => 'index'
        ]]);
        $response = new Response();

        $eventManager = $this->getMock('Cake\Event\EventManager', ['dispatch']);

        $this->controller = $this->getMock('Cake\Controller\Controller', ['redirect'], [$request, $response, null, $eventManager]);

        $event = new Event('Controller.adminBeforeRender', $this->controller);

        $this->assertEmpty($this->Manager->Controller->viewVars);

        $this->Manager->adminBeforeRender($event);
    }

    /**
     * Test shutdown event
     *
     * @return void
     */
    public function testShutdownEvent()
    {
        // Setup our component and fake test controller
        $request = new Request(['params' => [
                'prefix' => 'admin',
                'plugin' => 'cakemanager',
                'controller' => 'users',
                'action' => 'index'
        ]]);
        $response = new Response();

        $eventManager = $this->getMock('Cake\Event\EventManager', ['dispatch']);

        $this->controller = $this->getMock('Cake\Controller\Controller', ['redirect'], [$request, $response, null, $eventManager]);

        $eventManager->expects($this->at(0))->method('dispatch')
            ->with($this->logicalAnd($this->isInstanceOf('Cake\Event\Event'), $this->attributeEqualTo('_name', 'Component.Manager.shutdown')))
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $eventManager->expects($this->at(1))->method('dispatch')
            ->with($this->logicalAnd($this->isInstanceOf('Cake\Event\Event'), $this->attributeEqualTo('_name', 'Component.Manager.shutdown.admin')))
            ->will($this->returnValue($this->getMock('Cake\Event\Event', null, [], '', false)));

        $registry = new ComponentRegistry($this->controller);

        $manager = $this->getMock('CakeManager\Controller\Component\ManagerComponent', ['adminShutdown'], [$registry]);

        $manager->expects($this->once())->method('adminShutdown');

        $event = new Event('Controller.shutdown', $this->controller);

        $manager->shutdown($event);
    }

    /**
     * Test testPrefix method
     *
     * @return void
     */
    public function testPrefix()
    {
        $request = $this->setUpRequest([
            'prefix' => null,
            'plugin' => 'cakemanager',
            'controller' => 'users',
            'action' => 'index'
        ]);

        $this->Manager->setController($request);

        $this->assertFalse($this->Manager->prefix('admin'));
        $this->assertFalse($this->Manager->prefix('moderator'));
        $this->assertFalse($this->Manager->prefix('user'));
        $this->assertTrue($this->Manager->prefix(''));

        $request = $this->setUpRequest([
            'prefix' => 'admin',
            'plugin' => 'cakemanager',
            'controller' => 'users',
            'action' => 'index'
        ]);

        $this->Manager->setController($request);

        $this->assertFalse($this->Manager->prefix(''));
        $this->assertFalse($this->Manager->prefix('moderator'));
        $this->assertFalse($this->Manager->prefix('user'));
        $this->assertTrue($this->Manager->prefix('admin'));
    }

    /**
     * Test testIsPrefix method
     *
     * @return void
     */
    public function testIsPrefix()
    {
        $request = $this->setUpRequest([
            'prefix' => null,
            'plugin' => 'cakemanager',
            'controller' => 'users',
            'action' => 'index'
        ]);

        $this->Manager->setController($request);

        $this->assertFalse($this->Manager->isPrefix());

        $request = $this->setUpRequest([
            'prefix' => 'admin',
            'plugin' => 'cakemanager',
            'controller' => 'users',
            'action' => 'index'
        ]);

        $this->Manager->setController($request);

        $this->assertTrue($this->Manager->isPrefix());

        $request = $this->setUpRequest([
            'prefix' => 'customPrefix',
            'plugin' => 'cakemanager',
            'controller' => 'users',
            'action' => 'index'
        ]);

        $this->Manager->setController($request);

        $this->assertTrue($this->Manager->isPrefix());
    }

    /**
     * Test testGetPrefix method
     *
     * @return void
     */
    public function testGetPrefix()
    {
        $request = $this->setUpRequest([
            'prefix' => 'admin',
            'plugin' => 'cakemanager',
            'controller' => 'users',
            'action' => 'index'
        ]);

        $this->Manager->setController($request);

        $this->assertEquals('admin', $this->Manager->getPrefix());

        $request = $this->setUpRequest([
            'prefix' => 'user',
            'plugin' => 'cakemanager',
            'controller' => 'users',
            'action' => 'index'
        ]);

        $this->Manager->setController($request);

        $this->assertEquals('user', $this->Manager->getPrefix());
    }

    /**
     * Helper to return a component with a given url
     *
     * @param array $params
     */
    public function setUpRequest($params)
    {
        // Setup our component and fake test controller
        $request = new Request(['params' => $params]);
        $response = new Response();

        $this->controller = $this->getMock('Cake\Controller\Controller', ['redirect'], [$request, $response]);

        $registry = new ComponentRegistry($this->controller);
        $manager = new ManagerComponent($registry);

        $manager->setController($this->controller);

        return $manager;
    }
}
