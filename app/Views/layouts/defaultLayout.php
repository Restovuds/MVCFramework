<?php

use Ocore\View;

/**
 * Default layout
 *
 * @var View $this
 *
 * @var string $title
 * @var string $content
 */
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Page'; ?></title>

    <link rel="stylesheet" href="<?= base_url('/assets/bootstrap/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('/assets/css/default-style.css'); ?>">
    <link rel="icon" href="<?= base_url('/images/Ocore.png'); ?>" type="image/x-icon">
<!--    <a href="https://www.flaticon.com/free-icons/letter-o" title="letter o icons">Letter o icons created by shohanur.rahman13 - Flaticon</a>-->
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?= base_url(); ?>">
            <img src="<?= base_url('/images/Ocore.png'); ?>" alt="Logo" width="24" height="24" class="d-inline-block align-text-top">
            OCore
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url(); ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/about'); ?>">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/contact'); ?>">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('/posts/create'); ?>">Create Post</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?= $this->content; ?>

<div class="container my-2 portal">
    <?php get_alerts(); ?>
</div>

<script src="<?= base_url('/assets/bootstrap/js/bootstrap.bundle.js'); ?>"></script>

<?php if(DEBUG): ?>
    <?php dump(db()->getQueries()); ?>
<?php endif; ?>

</body>
</html>
