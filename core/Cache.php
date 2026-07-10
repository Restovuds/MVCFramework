<?php 

namespace Ocore;

class Cache
{
    private const int DEFAULT_TTL = 3600;
    private const CACHE_NOT_SET_VALUE = '__ERR_0__CACHE_NOT_SET__';

    public static function set(string $key, mixed $data, int $ttl = self::DEFAULT_TTL): void
    {
        $content['data'] = $data;
        $content['ttl'] = time() + $ttl;
        $cacheFile = self::getCacheFilePath($key);
        file_put_contents($cacheFile, serialize($content), LOCK_EX);
    }

    public static function get(string $key, mixed $default = null): mixed
    {
        $cacheFile = self::getCacheFilePath($key);        
        if (file_exists($cacheFile)) {
            $content = unserialize(file_get_contents($cacheFile), ['allowed_classes' => false]);
            if ($content['ttl'] >= time()) {
                return $content['data'];
            } 
            self::deleteFileCache($cacheFile);
        }
        return $default;
    }

    public static function getOrSet(string $key, callable $callback, int $ttl = self::DEFAULT_TTL): mixed
    {
        $data = self::get($key, self::CACHE_NOT_SET_VALUE);
        if ($data !== self::CACHE_NOT_SET_VALUE) {
            return $data;
        }

        $data = call_user_func($callback);
        self::set($key, $data, $ttl);
        return $data;
    }

    public static function delete(string $key): bool
    {
        $cacheFile = self::getCacheFilePath($key);
        if (file_exists($cacheFile)) {
            return self::deleteFileCache($cacheFile);
        }
        return false;
    }

    private static function deleteFileCache(string $cacheFilePath): bool
    {
        return unlink($cacheFilePath);
    }

    private static function getCacheFilePath(string $key): string
    {
        return CACHE_PATH . DIRECTORY_SEPARATOR . md5($key) . '.txt';
    }
}