<p style="font-family: Calibri, Arial">
    <?= __('Hey {0}', $user['email']) ?>,
</p>

<p style="font-family: Calibri, Arial">
    <?= __('Your new password was changed successfully.') ?>
</p>

<p style="font-family: Calibri, Arial">
    <b><?= __('Login'); ?></b>
    <br>
    <?= __('Login with your new password at <a href="{0}">{0}</a>.', $loginUrl) ?>
</p>

<p style="font-family: Calibri, Arial">
    <?= __('Kind regards,') ?>
</p>

<p style="font-family: Calibri, Arial">
    <?= $from ?>
</p>