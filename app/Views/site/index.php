<?php
/**
 * @var array $posts
 */
?>

<div class="container">
    <h1>Welcome to the Home Page!</h1>

    <?php if(!empty($posts)): ?>
        <?php foreach($posts as $post): ?>
            <h3><a href="#"><?= $post['title']; ?></a> | <a href="<?= base_url("/posts/edit?id={$post['id']}"); ?>">Edit</a> | <a href="<?= base_url("/posts/delete?id={$post['id']}"); ?>">Delete</a></h3>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

