<?php
/**
 * @var array $posts
 */
?>

<div class="container">
    <h1>Welcome to the Home Page!</h1>

    <?php if(!empty($posts)): ?>
        <?php foreach($posts as $post): ?>
            <h3><?= $post['title']; ?></h3>
            <p><?= $post['content']; ?></p>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

