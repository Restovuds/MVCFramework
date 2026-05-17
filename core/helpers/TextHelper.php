<?php

namespace Ocore\helpers;

class TextHelper
{
    public static function createSlug($text): string
    {
        // replace non-alphanumeric characters with hyphens
        $text = preg_replace('~[^\\pL\\d]+~u', '-', $text);
        // transliterate (convert accents to plain letters)
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        // remove anything that isn't a hyphen, letter, or number
        $text = preg_replace('~[^-\\w]+~', '', $text);
        // trim hyphens from both ends
        $text = trim($text, '-');
        // remove duplicate hyphens
        $text = preg_replace('~-+~', '-', $text);
        // lowercase
        return strtolower($text);
    }
}
