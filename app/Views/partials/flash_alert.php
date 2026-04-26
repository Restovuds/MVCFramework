<?php
/**
 * @param string $type
 * @param string $message
 */

$type = $type ?? \Ocore\helpers\FlashHelper::FLASH_ALERT_INFO;
$message = $message ?? 'You have a nice shirt bro!';

$class = match ($type) {
    \Ocore\helpers\FlashHelper::FLASH_ALERT_SUCCESS => 'alert-success',
    \Ocore\helpers\FlashHelper::FLASH_ALERT_ERROR => 'alert-danger',
    \Ocore\helpers\FlashHelper::FLASH_ALERT_INFO => 'alert-info',
    \Ocore\helpers\FlashHelper::FLASH_ALERT_WARNING => 'alert-warning',
};

?>


<div class="<?= merge_classes('alert', $class, 'alert-dismissible', 'fade', 'show') ?>" role="alert">
    <?= $message; ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
