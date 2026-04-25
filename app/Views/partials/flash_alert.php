<?php
/**
 * @param string $type
 * @param string $message
 */

$type = $type ?? \Ocore\helpers\FlashHelper::FLASH_ALERT_INFO;
$message = $message ?? 'You have a nice shirt bro!';
?>

<?php if ($type === \Ocore\helpers\FlashHelper::FLASH_ALERT_SUCCESS): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php elseif ($type === \Ocore\helpers\FlashHelper::FLASH_ALERT_ERROR): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>
<?php elseif ($type === \Ocore\helpers\FlashHelper::FLASH_ALERT_INFO): ?>
    <div class="alert alert-primary alert-dismissible fade show" role="alert">
        <?= $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>

    </div>
<?php elseif ($type === \Ocore\helpers\FlashHelper::FLASH_ALERT_WARNING): ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <?= $message; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif; ?>
