<?php


namespace CacheTestMax\CacherCore;


class CacheFile implements ICache
{
    private $path = ROOT_PATH.'/storage';
    /**
     *get data from private class field storage by key
     * @param $key
     * @return string|bool
     */
    public function get(string $key)
    {
        $fileName = $this->path.'/'.$key.'.txt';
        if(!file_exists($fileName)){
            return false;
        }
        $jsonValue = file_get_contents($fileName);
        $element = json_decode($jsonValue);
        if(isset($element->liveUntil)){
            $currentTimeStamp = time();
            if($currentTimeStamp > $element->liveUntil){
                unlink($fileName);
                return false;
            }
        }
        return $element->value;
    }
    /**
     * @param string $key
     * @param string $value
     * @param int $ttl
     * @return bool
     */
    public function set(string $key,string $value,int $ttl = null)
    {

        $fileName = $this->path.'/'.$key.'.txt';
        if(file_exists($fileName)){
            return false;
        }
        $arr= ['value'=>$value];
        if(is_int($ttl)){
            $currentTime = time();
            $arr['liveUntil'] = $currentTime + $ttl;
        }
        file_put_contents($fileName,json_encode($arr));
        return true;
    }
    /**
     * @param string $key
     * @return bool
     */
    public function delete(string $key)
    {
        $fileName = $this->path.'/'.$key.'.txt';
        if(!file_exists($fileName)){
            return false;
        }
        unlink($fileName);
        return true;
    }
    /**
     * @param string $key
     * @param string $value
     * @param int $ttl
     * @return bool
     */
    public function update(string $key,string $value,int $ttl =null)
    {
        $fileName = $this->path.'/'.$key.'.txt';
        if(!file_exists($fileName)){
            return false;
        }
        $jsonValue = file_get_contents($fileName);
        $element = json_decode($jsonValue);
        if(isset($element->liveUntil)){
            $currentTimeStamp = time();
            if($currentTimeStamp > $element->liveUntil){
                unset($fileName);
                return false;
            }
        }
        $element->value = $value;
        file_put_contents($fileName,json_encode($element));
    }
}