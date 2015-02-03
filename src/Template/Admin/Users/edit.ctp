    <?= $this->Form->create($user); ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('email');
        echo $this->Form->input('role_id', ['options' => $roles]);
        echo $this->Form->input('active', ['type' => 'checkbox']);

        echo $this->Html->link('Change Password', ['action' => 'new_password', $user->id]);

        ?>



    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
