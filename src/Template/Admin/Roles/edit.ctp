<h3>Roles</h3>

<?= $this->Html->link(__('All roles'), ['action' => 'index']) ?> | 
<?= $this->Form->postLink(__('Delete role'), ['action' => 'delete', $role->id], ['confirm' => __('Are you sure you want to delete {0}?', $role->name)]) ?>

<hr>

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
