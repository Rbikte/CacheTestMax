<?php

namespace Tests;

use CacheTestMax\Cacher;
use PHPUnit\Framework\TestCase;
class CacherTest extends TestCase
{
    protected $cacher;

    /**
     * @param $driver
     *  @dataProvider additionProvider
     */
    public function testGetAndSet($driver){
        $this->cacher = Cacher::getCacher($driver);
        $this->assertTrue($this->cacher->set('testKey','testValue'));
        $this->assertSame('testValue',$this->cacher->get('testKey'));
        $this->assertTrue($this->cacher->set('testKeyTmp','dasd',2));
        $this->assertSame('dasd',$this->cacher->get('testKeyTmp'));
        sleep(3);
        $this->assertFalse($this->cacher->get('testKeyTmp'));
        $this->assertTrue($this->cacher->set('testKey1','testValue1'));
        $this->assertTrue($this->cacher->set('testKey2','testValue2'));
        $this->assertTrue($this->cacher->update('testKey1','testValue1Updated'));
        $this->assertSame('testValue1Updated',$this->cacher->get('testKey1'));
        $this->assertTrue($this->cacher->update('testKey2','testValue2Updated',2));
        $this->assertSame('testValue2Updated',$this->cacher->get('testKey2'));

        $this->assertTrue($this->cacher->delete('testKey1'));
        $this->assertFalse($this->cacher->get('testKey1'));

    }
    public function additionProvider()
    {
        return [
           [ REDIS],
            [FILE],
            [RAM]
        ];
    }

}
