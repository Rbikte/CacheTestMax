<?php
namespace CacheTestMax\CacherCore;

interface ICache
{
    public function get(string $key);
    public function set(string $key,string $value,int $ttl = null);
    public function delete(string $key);
    public function update(string $key,string $value);
}