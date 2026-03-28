<?php
/**
 *
 */
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Contact form page</h1>
            <form method="post" action="/contact">

                <div class="mb-3">
                    <label for="fullName" class="form-label">Full Name</label>
                    <input type="text"
                           class="<?= mergeClasses(['form-control', getBootstrapValidationClass('fullName', $errors ?? [], false)]) ?>"
                           name="fullName" id="fullName" placeholder="John Snow" value="<?= old('fullName') ?>">
                    <?= getError('fullName', $errors ?? []); ?>
                </div>

                <div class="mb-3">
                    <label for="username" class="form-label">username</label>
                    <input type="text"
                           class="<?= mergeClasses(['form-control', getBootstrapValidationClass('username', $errors ?? [], false)]) ?>"
                           name="username" id="username" placeholder="John_Snow" value="<?= old('username') ?>">
                    <?= getError('username', $errors ?? []); ?>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="text"
                           class="<?= mergeClasses(['form-control', getBootstrapValidationClass('email', $errors ?? [])]) ?>"
                           name="email" id="email" aria-describedby="emailHelp" placeholder="john.snow@example.com"
                           value="<?= old('email') ?>">
                    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                    <?= getError('email', $errors ?? []); ?>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content"
                              class="<?= mergeClasses(['form-control', getBootstrapValidationClass('content', $errors ?? [], false)]) ?>"
                              id="content" rows="3"
                              placeholder="I am a King of the North!"><?= old('content') ?></textarea>
                    <?= getError('content', $errors ?? []); ?>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
