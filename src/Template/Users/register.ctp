<div class="users form">
    <?= $this->Flash->render('auth') ?>
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Register') ?></legend>
        <?= $this->Form->input('email') ?>
        <?= $this->Form->input('new_password', ['value' => '', 'type' => 'password']) ?>
        <?= $this->Form->input('confirm_password', ['value' => '', 'type' => 'password']) ?>
    </fieldset>
    <?= $this->Form->button(__('Register')); ?>
    <?= $this->Form->end() ?>
    <?= $this->Html->link('Login', ['action' => 'login']); ?>
</div>