<?php
namespace CakeManager\Model\Entity;

use Cake\ORM\Entity;

/**
 * Meta Entity.
 */
class Meta extends Entity {

/**
 * Fields that can be mass assigned using newEntity() or patchEntity().
 *
 * @var array
 */
	protected $_accessible = [
		'rel_model' => true,
		'rel_id' => true,
		'name' => true,
		'value' => true,
		'rel' => true,
	];

}
