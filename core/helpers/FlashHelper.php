<?php

namespace Ocore\helpers;

use Ocore\Session;

class FlashHelper
{
    public const string FLASH_ALERT_SUCCESS = 'ALERT_SUCCESS';
    public const string FLASH_ALERT_WARNING = 'ALERT_WARNING';
    public const string FLASH_ALERT_ERROR = 'ALERT_ERROR';
    public const string FLASH_ALERT_INFO = 'ALERT_INFO';

    protected const string PARTIAL_ALERT_VIEW_PATH = 'partials/flash_alert';

    public static function createSuccessAlert(string $message = "Action succeed"): void
    {
        self::createAlert(type: self::FLASH_ALERT_SUCCESS, message: $message);
    }

    public static function createWarningAlert(string $message = "Maybe something went wrong. We don`t know :("): void
    {
        self::createAlert(type: self::FLASH_ALERT_WARNING, message: $message);
    }

    public static function createErrorAlert(string $message = "Action failed"): void
    {
        self::createAlert(type: self::FLASH_ALERT_ERROR, message: $message);
    }

    public static function createInfoAlert(string $message = "We need to say something to you!"): void
    {
        self::createAlert(type: self::FLASH_ALERT_INFO, message: $message);
    }

    public static function createAlert(string $type, string $message): void
    {
        session()->setFlash(key: $type, value: $message);
    }

    public static function get_alerts()
    {
        $data = [];

        $returnFlash = false;
        if (session()->hasFlash()) {
            if (session()->hasFlash(self::FLASH_ALERT_SUCCESS)) {
                $data['message'] = session()->getFlash(self::FLASH_ALERT_SUCCESS);
                $data['type'] = self::FLASH_ALERT_SUCCESS;
                $returnFlash = true;
            }
            if (session()->hasFlash(self::FLASH_ALERT_WARNING)) {
                $data['message'] = session()->getFlash(self::FLASH_ALERT_WARNING);
                $data['type'] = self::FLASH_ALERT_WARNING;
                $returnFlash = true;
            }
            if (session()->hasFlash(self::FLASH_ALERT_ERROR)) {
                $data['message'] = session()->getFlash(self::FLASH_ALERT_ERROR);
                $data['type'] = self::FLASH_ALERT_ERROR;
                $returnFlash = true;
            }
            if (session()->hasFlash(self::FLASH_ALERT_INFO)) {
                $data['message'] = session()->getFlash(self::FLASH_ALERT_INFO);
                $data['type'] = self::FLASH_ALERT_INFO;
                $returnFlash = true;
            }

            if ($returnFlash) {
                view()->renderPartial(self::PARTIAL_ALERT_VIEW_PATH, $data);
            }
        }
    }
}