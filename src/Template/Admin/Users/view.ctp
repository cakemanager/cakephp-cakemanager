<h3>Users</h3>

<?= $this->Html->link(__('All users'), ['action' => 'index']) ?> | 
<?= $this->Html->link(__('Edit user'), ['action' => 'edit', $user->id]) ?> | 
<?= $this->Html->link(__('New password'), ['action' => 'newPassword', $user->id]) ?> | 
<?= $this->Form->postLink(__('Delete user'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete {0}?', $user->email)]) ?>

<hr>    

<h4><?= h($user->email) ?></h4>
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
