<h3>Users</h3>

<?= $this->Html->link('All users', ['action' => 'index']) ?> | 
<?= $this->Html->link('Edit user', ['action' => 'edit', $user->id]) ?>

<hr>

<?= $this->Form->create($user); ?>
<fieldset>
    <legend><?= __('Change Password') ?></legend>
    <?php
    echo $this->Form->input('users_email', ['disabled', 'value' => $user->email]);
    echo $this->Form->input('new_password', ['type' => 'password', 'value' => '']);
    echo $this->Form->input('confirm_password', ['type' => 'password', 'value' => '']);
    echo $this->Form->input('send_mail', ['type' => 'checkbox']);
    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
