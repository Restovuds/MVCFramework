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
    <link rel="icon" href="<?= base_url('/images/Ocore.png'); ?>" type="image/x-icon">
    <!--    <a href="https://www.flaticon.com/free-icons/letter-o" title="letter o icons">Letter o icons created by shohanur.rahman13 - Flaticon</a>-->
</head>
<body>
<div class="container">
    <?= $this->content; ?>
</div>
<script src="<?= base_url('/assets/bootstrap/js/bootstrap.bundle.js'); ?>"></script>
</body>
</html>
