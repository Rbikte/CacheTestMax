<?php

namespace  CacheTestMax;

use CacheTestMax\CacherCore\CacheFile;
use CacheTestMax\CacherCore\CacheRam;
use CacheTestMax\CacherCore\CacheRedis;

define('REDIS',1);
define('FILE',2);
define('RAM',3);
define('ROOT_PATH',dirname(__DIR__));
class Cacher
{
    public static function getCacher($type=null){
        if ($type == REDIS) {
            return new CacheRedis();
        } elseif ($type == FILE) {
            return new CacheFile();
        } else {
            return new CacheRam();
        }

    }


}