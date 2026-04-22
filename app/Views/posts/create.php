<?php
/**
 *
 */
?>

<div class="container">
    <div class="row">
        <div class="col-md-6 offset-md-3">

            <h1>Create a new post</h1>

            <form method="post" action="<?= base_url('/posts/store'); ?>">

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text"
                           class="<?= mergeClasses(['form-control', getBootstrapValidationClass('title', $errors ?? [], false)]) ?>"
                           name="title" id="title" placeholder="Some interesting theme" value="<?= old('title') ?>">
                    <?= getError('title', $errors ?? []); ?>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content"
                              class="<?= mergeClasses(['form-control', getBootstrapValidationClass('content', $errors ?? [], false)]) ?>"
                              id="content" rows="3"
                              placeholder="Who is a king of the north?"><?= old('content') ?></textarea>
                    <?= getError('content', $errors ?? []); ?>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>

            </form>
        </div>
    </div>
</div>
