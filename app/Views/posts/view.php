<?php
/**
 * @param array $post
 */
?>

<div class="container">
    <div class="row">
        <div class="col-md-9 mx-auto">
            <h1><?= spec_chars($post['title']) ?></h1>
            <?php if ($post['thumbnail']): ?>
                <img src="<?= base_url($post['thumbnail']) ?>" class="img-fluid">
            <?php endif; ?>
            <blockquote class="blockquote">
                <p class="mb-0"><?= spec_chars($post['content']) ?></p>
            </blockquote>
        </div>
    </div>
</div>
