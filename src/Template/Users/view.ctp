<div class="actions columns large-2 medium-3">
	<h3><?= __('Actions') ?></h3>
	<ul class="side-nav">
		 <?= $this->Menu->menu('main') ?>
	</ul>
</div>
<div class="users view large-10 medium-9 columns">
	<h2><?= h($user->id) ?></h2>
	<div class="row">
		<div class="large-5 columns strings">
			<h6 class="subheader"><?= __('Email') ?></h6>
			<p><?= h($user->email) ?></p>
			<h6 class="subheader"><?= __('Password') ?></h6>
			<p><?= h($user->password) ?></p>
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
<div class="related row">
	<div class="column large-12">
	<h4 class="subheader"><?= __('Related Bookmarks') ?></h4>
	<?php if (!empty($user->bookmarks)): ?>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?= __('Id') ?></th>
			<th><?= __('User Id') ?></th>
			<th><?= __('Title') ?></th>
			<th><?= __('Description') ?></th>
			<th><?= __('Url') ?></th>
			<th><?= __('Created') ?></th>
			<th><?= __('modified') ?></th>
			<th class="actions"><?= __('Actions') ?></th>
		</tr>
		<?php foreach ($user->bookmarks as $bookmarks): ?>
		<tr>
			<td><?= h($bookmarks->id) ?></td>
			<td><?= h($bookmarks->user_id) ?></td>
			<td><?= h($bookmarks->title) ?></td>
			<td><?= h($bookmarks->description) ?></td>
			<td><?= h($bookmarks->url) ?></td>
			<td><?= h($bookmarks->created) ?></td>
			<td><?= h($bookmarks->modified) ?></td>

			<td class="actions">
				<?= $this->Html->link(__('View'), ['controller' => 'Bookmarks', 'action' => 'view', $bookmarks->id]) ?>

				<?= $this->Html->link(__('Edit'), ['controller' => 'Bookmarks', 'action' => 'edit', $bookmarks->id]) ?>

				<?= $this->Form->postLink(__('Delete'), ['controller' => 'Bookmarks', 'action' => 'delete', $bookmarks->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bookmarks->id)]) ?>

			</td>
		</tr>

		<?php endforeach; ?>
	</table>
	<?php endif; ?>
	</div>
</div>
