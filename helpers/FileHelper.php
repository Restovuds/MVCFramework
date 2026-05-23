<?php

namespace helpers;

use InvalidArgumentException;

class FileHelper
{
    public static function formatBytes(int $bytes, $to = 'auto', $lowerCase = false, $spaceBetween = true): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        $power = $to === 'auto' ? ($bytes > 0 ? min(floor(log($bytes, 1024)), count($units) - 1) : 0) : array_search(strtoupper($to), $units);

        if ($power === false || $power >= count($units)) {
            throw new InvalidArgumentException("Invalid unit or unit not supported: '$to'");
        }

        $normalized = $bytes / (1024 ** $power);
        $formatted = number_format($normalized, $power > 0 ? 2 : 0);

        $divider = $spaceBetween ? ' ' : '';
        $unitSuffix = $lowerCase ? strtolower($units[$power]) : $units[$power];

        return $formatted . $divider . $unitSuffix;
    }
}