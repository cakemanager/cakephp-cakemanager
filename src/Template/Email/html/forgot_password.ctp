<p style="font-family: Calibri, Arial">
    <?= __('Hey {0}', $user['email']) ?>,
</p>

<p style="font-family: Calibri, Arial">
    <?= __('You requested a new password at {0}.', $fullBaseUrl) ?>
</p>

<p style="font-family: Calibri, Arial">
    <b><?= __('Setting up a new password'); ?></b>
    <br>
    <?= __('<a href="{0}">New password</a> or use this url in your browser: {0}', $url) ?>
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