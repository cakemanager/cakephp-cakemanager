<div class="actions columns large-2 medium-3">
    <h3><?= __('Actions') ?></h3>
    <ul class="side-nav">
        <?= $this->Menu->menu('main') ?>
    </ul>
</div>
<div class="users form large-10 medium-9 columns">
    <?= $this->Form->create($user); ?>
    <fieldset>
        <legend><?= __('Edit User') ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('email');
        echo $this->Form->input('role_id', ['options' => $roles]);

        echo $this->Html->link('Change Password', ['action' => 'new_password', $user->id]);

        ?>



    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
