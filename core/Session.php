<?php

namespace Ocore;

class Session
{
    protected const string KEY_FLASH = 'FLASH';

    public function __construct()
    {
        session_start();
    }

    public function set(string $key, mixed $value): bool
    {
        return (bool)$_SESSION[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $_SESSION[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    public function remove(string $key): void
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    public function hasFlash(?string $key = null): bool
    {
        if (is_null($key)) {
            return isset($_SESSION[self::KEY_FLASH]);
        }
        return isset($_SESSION[self::KEY_FLASH][$key]);
    }

    public function setFlash(string $key, mixed $value): bool
    {
        return $_SESSION[self::KEY_FLASH][$key] = $value;
    }

    public function getFlash(string $key): mixed
    {
        if (isset($_SESSION[self::KEY_FLASH][$key])) {
            $value = $_SESSION[self::KEY_FLASH][$key];
            unset($_SESSION[self::KEY_FLASH][$key]);
        }

        return $value ?? null;
    }

    public function destroy(): void
    {
        session_destroy();
    }
}