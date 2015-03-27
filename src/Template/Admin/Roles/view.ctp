<h3>Roles</h3>

<?= $this->Html->link(__('All roles'), ['action' => 'index']) ?> | 
<?= $this->Html->link(__('Edit role'), ['action' => 'edit', $role->id]) ?> | 
<?= $this->Form->postLink(__('Delete role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete {0}?', $role->name)]) ?>

<hr>

<h4><?= h($role->name) ?></h4>
<div class="row">
    <div class="large-5 columns strings">
        <h6 class="subheader"><?= __('Name') ?></h6>
        <p><?= h($role->name) ?></p>
    </div>
    <div class="large-2 columns numbers end">
        <h6 class="subheader"><?= __('Id') ?></h6>
        <p><?= $this->Number->format($role->id) ?></p>
    </div>
    <div class="large-2 columns dates end">
        <h6 class="subheader"><?= __('Created') ?></h6>
        <p><?= h($role->created) ?></p>
        <h6 class="subheader"><?= __('Modified') ?></h6>
        <p><?= h($role->modified) ?></p>
    </div>
</div>