<?php
/**
 * @var array $posts
 */
?>

<div class="container">
    <h1>Welcome to the Home Page!</h1>

    <?php if(!empty($posts)): ?>
        <?php foreach($posts as $post): ?>
            <h3><a href="<?= base_url("/posts/edit?id={$post['id']}"); ?>"><?= $post['title']; ?></a></h3>
        <?php endforeach; ?>
    <?php endif; ?>

</div>

