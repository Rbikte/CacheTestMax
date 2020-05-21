<?php


namespace CacheTestMax\CacherCore;


class CacheRam implements ICache
{
    private $storage = [];

    /**
     *get data from private class field storage by key
     * @param $key
     * @return string|bool
     */
    public function get(string $key)
    {
        if(!isset($this->storage[$key])){
            return false;
        }
        if(isset($this->storage[$key]['liveUntil'])){
            $currentTimeStamp = time();
            if($currentTimeStamp > $this->storage[$key]['liveUntil']){
                return false;
            }
        }
        return $this->storage[$key]['value'];
    }
    /**
     * @param string $key
     * @param string $value
     * @param int $ttl
     * @return bool
     */
    public function set(string $key,string $value, int $ttl = null)
    {
        $arr = ['value' => $value];
        if(is_int($ttl)){
            $arr['liveUntil'] = time()+ $ttl;
        }
        $this->storage[$key] = $arr;
        if(!isset($this->storage[$key])){
            return false;
        }
        return true;
    }
    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key)
    {
        unset($this->storage[$key]);
        if(!isset($this->storage[$key])){
            return true;
        }
        return false;
    }
    /**
     * @param string $key
     * @param string $value
     * @param int $ttl
     * @return bool
     */
    public function update(string $key,string $value)
    {
        if(!isset($this->storage[$key])){
            return false;
        }
        $this->storage[$key]['value'] = $value;
        return true;
    }

}