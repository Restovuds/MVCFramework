<?php
/**
 * @param array $post
 */

use App\Models\Gallery;

$thumbnail = empty($post['thumbnail']) ? null : $post['thumbnail'];

$target = Gallery::tableName();
$gallery = db()->query("SELECT path, name FROM {$target} WHERE post_id = :id", [':id' => $post['id']])->asArray();
?>

<div class="container">
    <div class="row">
        <div class="col-md-9 mx-auto">
            <h1><?= spec_chars($post['title']) ?></h1>

            <?php if ($thumbnail): ?>
                <div class="container-md text-center">
                    <img src="<?= base_url($thumbnail) ?>" class="img-fluid rounded" alt="<?= $post['title'] . ' image' ?>">
                </div>
            <?php endif; ?>

            <?php if ($gallery): ?>
                <div class="grid text-center">
                    <?php if (is_array($gallery)): ?>
                        <?php foreach ($gallery as $image): ?>
                            <div class="g-col-4">
                                <img
                                        src="<?= base_url($image['path']) ?>"
                                        class="rounded"
                                        style='max-height: 200px;'
                                        alt="<?= $image['name'] ?>"
                                >
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <blockquote class="blockquote">
                <p class="mb-0"><?= spec_chars($post['content']) ?></p>
            </blockquote>
        </div>
    </div>
</div>
