<?php
$class = 'message';
if (!empty($params['class'])) {
	if(is_array($params['class'])){
		$params['class'] = implode(' ',$params['class']);
	}
	$class .= ' ' . $params['class'];
}
?>
<div class="<?= h($class) ?>"><?= h($message) ?></div>
