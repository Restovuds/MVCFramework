<?php

/**
 * @var string $title
 * @var string $message
 * @var int $code
 */

?>
<h1>
    <?= $title ?>
    <span class="badge rounded-pill text-bg-danger">
        <?= $code ?>
    </span>
</h1>
<div class="alert alert-danger d-flex align-items-center" role="alert">
    <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
    <div>
        <?= $message ?>
    </div>
</div>
