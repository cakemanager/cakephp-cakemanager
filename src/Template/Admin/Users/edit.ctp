<h3>Users</h3>

<?= $this->Html->link(__('All users'), ['action' => 'index']) ?> | 
<?= $this->Html->link(__('New password'), ['action' => 'newPassword', $user->id]) ?> | 
<?= $this->Form->postLink(__('Delete user'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete {0}?', $user->email)]) ?>

<hr>

<?= $this->Form->create($user); ?>
<fieldset>
    <legend><?= __('Edit User') ?></legend>
    <?php
    echo $this->Form->input('id');
    echo $this->Form->input('email');
    echo $this->Form->input('role_id', ['options' => $roles]);
    echo $this->Form->input('active', ['type' => 'checkbox']);

    foreach ($customFields as $key => $field) {
        echo $this->Form->input($key, ($field ? $field : []));
    }

    echo $this->Html->link('Change Password', ['action' => 'newPassword', $user->id]);
    ?>



</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
