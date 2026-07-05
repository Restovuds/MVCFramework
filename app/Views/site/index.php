<?php
use Ocore\Pagination;


/**
 * @var array $posts
 * @var Pagination $pagination
 */
?>

<div class="container o-post-list-container">
    <h1>Look at the posts!</h1>

    <?php if (!empty($posts)): ?>
        <?php foreach ($posts as $post): ?>
            <div class="d-flex position-relative p-3 o-post-list-item">
                <img src="<?= isset($post['thumbnail']) ? base_url($post['thumbnail']) : base_url('/images/no-image.jpg') ?>" style="max-width: 144px; max-height: 144px;" class="flex-shrink-0 me-3 rounded">
                <div class="flex-grow-1">
                    <div class="row pb-2">
                        <a class="col link-secondary font-monospace fs-3" href="<?= base_url("/posts/{$post['slug']}") ?>"><?= $post['title']; ?></a>
                        <div class="btn-group col-1">
                            <a class="btn btn-primary stretched-link" href="<?= base_url("/posts/edit?id={$post['id']}"); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001m-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708z"/>
                                </svg>
                            </a>
                            <a class="btn btn-danger stretched-link" href="<?= base_url("/posts/delete?id={$post['id']}"); ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                    <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="row">
                        <p>
                            <?= mb_substr($post['content'], 0, 300, 'UTF-8') . '...' ?>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        <?= $pagination ?>
    <?php endif; ?>
</div>

