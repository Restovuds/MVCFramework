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
            <form method="post" action="<?= base_url('/login') ?>">
                <div class="mb-3">
                    <label for="email" class="form-label"><?= $getLabel('email') ?><span class="text-danger">*</span></label>
                    <input type="text"
                           class="<?= merge_classes('form-control', get_bootstrap_validation_class('email', $errors ?? [])) ?>"
                           name="email" id="email" aria-describedby="emailHelp" placeholder="Email address"
                           value="<?= old('email') ?>">
                    <?= get_error('email', $errors ?? []); ?>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label"><?= $getLabel('password') ?><span class="text-danger">*</span></label>
                    <input type="text"
                           class="<?= merge_classes('form-control', get_bootstrap_validation_class('password', $errors ?? [], false)) ?>"
                           name="password" id="password" placeholder="Password">
                    <?= get_error('password', $errors ?? []); ?>
                </div>

                <button type="submit" class="btn btn-primary">Sigh in</button>
            </form>
        </div>
    </div>
</div>
