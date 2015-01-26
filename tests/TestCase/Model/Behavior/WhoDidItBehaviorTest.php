<?php

namespace CakeManager\Test\TestCase\Model\Behavior;

use CakeManager\Model\Behavior\WhoDidItBehavior;
use Cake\TestSuite\TestCase;
use Cake\Core\Configure;

/**
 * CakeManager\Model\Behavior\WhoDidItBehavior Test Case
 */
class WhoDidItBehaviorTest extends TestCase
{

    public $fixtures = ['plugin.cake_manager.articles', 'plugin.cake_manager.users'];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp() {
        parent::setUp();

        $this->Model = \Cake\ORM\TableRegistry::get('Articles');
    }

    public function testLoadingBehavior() {

        $this->assertFalse($this->Model->behaviors()->has('WhoDidIt'));

        $this->Model->addBehavior('CakeManager.WhoDidIt');

        $this->assertTrue($this->Model->behaviors()->has('WhoDidIt'));

    }

    public function testFind() {

        $this->Model->addBehavior('CakeManager.WhoDidIt');

        $data = $this->Model->get(1);

        $this->AssertEquals(1, $data->created_by->id);
        $this->AssertEquals(1, $data->modified_by->id);
    }

    public function testAddArticle() {

        $this->Model->addBehavior('CakeManager.WhoDidIt');

        $this->AssertEquals(3, $this->Model->find('all')->Count());

        $_SESSION['Auth'] = [
            'User' => [
                'id'       => 1,
                'username' => 'testing account',
            ]
        ];

        $_data = [
            'user_id'   => 1,
            'title'     => 'Fourth Article',
            'body'      => 'Fourth Article Body',
            'published' => 'Y',
        ];

        $entity = $this->Model->newEntity($_data);

        $this->Model->save($entity);

        $this->AssertEquals(4, $this->Model->find('all')->Count());

        $data = $this->Model->get(4);

        $this->AssertEquals("Fourth Article", $data->title);
        $this->AssertEquals(1, $data->created_by->id);
        $this->AssertEquals(1, $data->modified_by->id);
    }

    public function testEditArticle() {

        $this->Model->addBehavior('CakeManager.WhoDidIt');

        // change the users id
        $_SESSION['Auth'] = [
            'User' => [
                'id'       => 2,
                'username' => 'testing account',
            ]
        ];

        $data = $this->Model->get(3);

        $_data = $data->toArray();
        $_data['title'] = "Thirth Article Edited";

        $entity = $this->Model->patchEntity($data, $_data);

        $this->Model->save($entity);

        $result = $this->Model->get(3);

        $this->AssertEquals("Thirth Article Edited", $result->title);
        $this->AssertEquals(1, $result->created_by->id);
        $this->AssertEquals(2, $result->modified_by->id);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown() {
        unset($this->Model);

        parent::tearDown();
    }

}
