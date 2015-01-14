<?php

namespace CakeManager\Test\Fixture;
use Cake\TestSuite\Fixture\TestFixture;
/**
 * Short description for class.
 *
 */
class ArticlesFixture extends TestFixture {
/**
 * fields property
 *
 * @var array
 */
	public $fields = array(
		'id' => ['type' => 'integer'],
		'user_id' => ['type' => 'integer', 'null' => true],
		'title' => ['type' => 'string', 'null' => true],
		'body' => 'text',
		'published' => ['type' => 'string', 'length' => 1, 'default' => 'N'],
        'created_by' => ['type' => 'integer'],
        'modified_by' => ['type' => 'integer'],
        'created_by_second' => ['type' => 'integer'],
        'modified_by_second' => ['type' => 'integer'],
		'_constraints' => ['primary' => ['type' => 'primary', 'columns' => ['id']]]
	);
/**
 * records property
 *
 * @var array
 */
	public $records = array(
		array('user_id' => 1, 'title' => 'First Article', 'body' => 'First Article Body', 'published' => 'Y', 'created_by' => 1, 'modified_by' => 1),
		array('user_id' => 3, 'title' => 'Second Article', 'body' => 'Second Article Body', 'published' => 'Y', 'created_by' => 1, 'modified_by' => 1),
		array('user_id' => 1, 'title' => 'Third Article', 'body' => 'Third Article Body', 'published' => 'Y', 'created_by' => 1, 'modified_by' => 1)
	);
}