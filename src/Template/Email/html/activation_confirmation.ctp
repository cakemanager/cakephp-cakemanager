<p style="font-family: Calibri, Arial">
    <?= __('Hey {0}', $user['email']) ?>,
</p>

<p style="font-family: Calibri, Arial">
    <?= __('Welcome to <a href="{0}">{0}</a>. Your activation passed successfully.', $fullBaseUrl) ?>
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