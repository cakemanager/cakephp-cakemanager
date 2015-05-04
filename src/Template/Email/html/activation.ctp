<p style="font-family: Calibri, Arial">
    <?= __('Hey {0}', $user['email']) ?>,
</p>

<p style="font-family: Calibri, Arial">
    <?= __('Welcome to <a href="{0}">{0}</a>.', $fullBaseUrl) ?>
</p>

<p style="font-family: Calibri, Arial">
    <b><?= __('Activating your account'); ?></b>
    <br>
    <?= __('<a href="{0}">Activate now</a> or use this url in your browser: {0}', $activationUrl) ?>
</p>

<p style="font-family: Calibri, Arial">
    <b><?= __('Login'); ?></b>
    <br>
    <?= __('Login at <a href="{0}">{0}</a>.', $loginUrl) ?>
</p>

<p style="font-family: Calibri, Arial">
    <?= __('Kind regards,') ?>
</p>

<p style="font-family: Calibri, Arial">
    <?= $from ?>
</p>