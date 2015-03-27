<h3>Users</h3>

<?= $this->Html->link('All users', ['action' => 'index']) ?> | 
<?= $this->Html->link('Edit user', ['action' => 'edit', $user->id]) ?>

<hr>

<?= $this->Form->create($user); ?>
<fieldset>
    <legend><?= __('Edit User') ?></legend>
    <?php
    echo $this->Form->input('users_email', ['disabled', 'value' => $user->email]);
    echo $this->Form->input('new_password', ['type' => 'password', 'value' => '']);
    echo $this->Form->input('confirm_password', ['type' => 'password', 'value' => '']);
    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
