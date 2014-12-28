<div class="actions columns large-2 medium-3">
	<h3><?= __('Actions') ?></h3>
	<ul class="side-nav">
		<?= $this->Menu->menu('main') ?>
	</ul>
</div>
<div class="roles form large-10 medium-9 columns">
	<?= $this->Form->create($role); ?>
	<fieldset>
		<legend><?= __('Edit Role') ?></legend>
		<?php
			echo $this->Form->input('name');
			echo $this->Form->input('login_redirect');
		?>
	</fieldset>
	<?= $this->Form->button(__('Submit')) ?>
	<?= $this->Form->end() ?>
</div>
