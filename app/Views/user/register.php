<?php
/**
 * @var string $title
 */

$userAttrClass = new \App\Models\User();

$getLabel = function ($attr) use ($userAttrClass) {
    return $userAttrClass->getAttributeLabel($attr);
}

?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1><?= $title ?></h1>
            <form method="post" action="<?= base_url('/register') ?>">

                <div class="mb-3">
                    <label for="first_name" class="form-label"><?= $getLabel('first_name') ?><span class="text-danger">*</span></label>
                    <input type="text"
                           class="<?= merge_classes('form-control', get_bootstrap_validation_class('first_name', $errors ?? [], false)) ?>"
                           name="first_name" id="first_name" placeholder="First Name" value="<?= old('first_name') ?>">
                    <?= get_error('first_name', $errors ?? []); ?>
                </div>

                <div class="mb-3">
                    <label for="last_name" class="form-label"><?= $getLabel('last_name') ?></label>
                    <input type="text"
                           class="<?= merge_classes('form-control', get_bootstrap_validation_class('last_name', $errors ?? [], false)) ?>"
                           name="last_name" id="last_name" placeholder="Last Name" value="<?= old('last_name') ?>">
                    <?= get_error('last_name', $errors ?? []); ?>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label"><?= $getLabel('email') ?><span class="text-danger">*</span></label>
                    <input type="text"
                           class="<?= merge_classes('form-control', get_bootstrap_validation_class('email', $errors ?? [])) ?>"
                           name="email" id="email" aria-describedby="emailHelp" placeholder="Email address"
                           value="<?= old('email') ?>">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    <?= get_error('email', $errors ?? []); ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label"><?= $getLabel('password') ?><span class="text-danger">*</span></label>
                    <input type="text"
                           class="<?= merge_classes('form-control', get_bootstrap_validation_class('password', $errors ?? [], false)) ?>"
                           name="password" id="password" placeholder="Password" value="<?= old('password') ?>">
                    <?= get_error('password', $errors ?? []); ?>
                </div>

                <div class="mb-3">
                    <label for="password_repeat" class="form-label"><?= $getLabel('password_repeat') ?><span class="text-danger">*</span></label>
                    <input type="text"
                           class="<?= merge_classes('form-control', get_bootstrap_validation_class('password_repeat', $errors ?? [], false)) ?>"
                           name="password_repeat" id="password_repeat" placeholder="Repeat password" value="<?= old('password_repeat') ?>">
                    <?= get_error('password_repeat', $errors ?? []); ?>
                </div>

                <button type="submit" class="btn btn-primary">Sigh up</button>
            </form>
        </div>
    </div>
</div>
