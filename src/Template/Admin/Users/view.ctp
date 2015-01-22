<div class="actions columns large-2 medium-3">
	<h3><?= __('Actions') ?></h3>
	<ul class="side-nav">
		 <?= $this->Menu->menu('main') ?>
	</ul>
</div>
<div class="users view large-10 medium-9 columns actions" style="border-left: 0px">
    <h3><?= h($user->email) ?></h3>
	<div class="row">
		<div class="large-5 columns strings">
			<h6 class="subheader"><?= __('Email') ?></h6>
			<p><?= h($user->email) ?></p>
		</div>
		<div class="large-2 columns numbers end">
			<h6 class="subheader"><?= __('Id') ?></h6>
			<p><?= $this->Number->format($user->id) ?></p>
		</div>
		<div class="large-2 columns dates end">
			<h6 class="subheader"><?= __('Created') ?></h6>
			<p><?= h($user->created) ?></p>
			<h6 class="subheader"><?= __('modified') ?></h6>
			<p><?= h($user->modified) ?></p>
		</div>
	</div>
</div>
