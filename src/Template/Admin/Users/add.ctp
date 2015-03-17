<?= $this->Form->create($user); ?>
<fieldset>
    <legend><?= __('Add User') ?></legend>
    <?php
    echo $this->Form->input('email');
    echo $this->Form->input('password');
    echo $this->Form->input('active', ['type' => 'checkbox']);

    foreach($customFields as $key => $field) {
        echo $this->Form->input($key, ($field ? $field : []));
    }
    
    echo $this->Form->input('role_id', ['options' => $roles]);
    ?>
</fieldset>
<?= $this->Form->button(__('Submit')) ?>
<?= $this->Form->end() ?>
