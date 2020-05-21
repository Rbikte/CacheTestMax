<?php


namespace CacheTestMax\CacherCore;



class CacheRedis implements ICache
{
    private $redis;
    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('localhost',6379);
        if (!$this->redis->ping()) {
             throw new \Exception('cannot connect to redis');
        }

    }
    /**
        get data from redis by key
     * @param $key
     * @return string|bool
     */
    public function get(string $key){
        return $this->redis->get($key);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $ttl
     * @return bool
     * @throws \Exception
     */
    public function set(string $key, string $value,int $ttl = null)
    {
        $result = $this->redis->set($key,$value);
        if(!$result){
            return false;
        }
        if(is_int($ttl)){
            $resultExpire = $this->redis->expire($key,$ttl);
            if(!$resultExpire){
                throw new \Exception('cannot set ttl on key '.$key);
            }
        }
        return true;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key)
    {
        return (bool)$this->redis->del($key);
    }

    /**
     * @param string $key
     * @param string $value
     * @param int $ttl
     * @return bool
     */
    public function update(string $key,string $value){
        if($this->redis->get($key)){
            $this->redis->set($key,$value);
            return true;
        }
        return false;

    }

}