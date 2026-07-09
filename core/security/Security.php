<?php

namespace Ocore\security;

use Ocore\exception\RuntimeException;

class Security
{
    public const string DEFAULT_CIPHER = 'aes256';
    private bool $hasExtension;

    public function __construct()
    {
        if (DEBUG) {
            $this->hasExtension = true;

        } else {
            if ($this->hasExtension = extension_loaded('openssl')) {
                trigger_error("OpenSSL extension is not loaded", E_USER_WARNING);
            }
        }
    }



    public static function availableCiphers(bool $aliases = false): array
    {
        return openssl_get_cipher_methods($aliases);
    }

    public function encrypt(string $data, string $key, string $cipher = self::DEFAULT_CIPHER): string
    {
        if (!$this->hasExtension) {
            return $data;
        }

        if (!in_array($cipher, static::availableCiphers())) {
            $cipher = static::DEFAULT_CIPHER;
        }

        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = openssl_random_pseudo_bytes($ivlen);
        $encryptedRaw = openssl_encrypt($data, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $encryptedRaw, $key, $as_binary = true);

        return base64_encode($iv.$hmac.$encryptedRaw);
    }

    public function decrypt(string $data, string $key, string $cipher = self::DEFAULT_CIPHER): string
    {
        if (!$this->hasExtension) {
            return $data;
        }

        if (!in_array($cipher, static::availableCiphers())) {
            $cipher = static::DEFAULT_CIPHER;
        }

        $c = base64_decode($data); // true
        $ivlen = openssl_cipher_iv_length($cipher);
        $iv = substr($c, 0, $ivlen);
        $hmac = substr($c, $ivlen, $sha2len = 32);
        $encryptedRaw = substr($c, $ivlen + $sha2len);
        $original = openssl_decrypt($encryptedRaw, $cipher, $key, $options = OPENSSL_RAW_DATA, $iv);
        $calcmac = hash_hmac('sha256', $encryptedRaw, $key, $as_binary=true);

        if (hash_equals($hmac, $calcmac)) {
            return $original;
        }

        throw new RuntimeException("Invalid hash");
    }
}