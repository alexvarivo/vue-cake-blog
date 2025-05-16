<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h1>Login</h1>

<?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your username and password') ?></legend>
        <?= $this->Form->control('username') ?>
        <?= $this->Form->control('password') ?>
    </fieldset>
<?= $this->Form->button(__('Login')) ?>
<?= $this->Form->end() ?>

