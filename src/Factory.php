<?php


namespace CacheTestMax;

use CacheTestMax\CacherCore\CacheRedis;
use CacheTestMax\CacherCore\CacheFile;
use CacheTestMax\CacherCore\CacheRam;

class Factory
{
    public static function getCacheDriver($type = null)
    {
        if ($type == REDIS) {
            return new CacheRedis();
        } elseif ($type == FILE) {
            return new CacheFile();
        } else {
            return new CacheRam();
        }

    }
}