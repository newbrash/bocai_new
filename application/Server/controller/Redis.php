<?php
namespace app\Server\controller;

use think\facade\Config;

class Redis
{
    /**
     * 创建一个redis链接
     */
    public static function Init()
    {
        $redisConfig = Config::get('worker.redis');
        
        $redis = new \Redis();
        $redis->connect($redisConfig['host'], $redisConfig['port']);
        return $redis;
    }
    /**
     * 设置一个字符串
     * @param array $arr ["key"=>value,"key1"=>value1,...]
     * @return array $res
     */
    public static function set($arr)
    {
        if (!is_array($arr)) {
            return false;
        }
        $redis = self::Init();
        $res = [];
        foreach ($arr as $key => $val) {
            $res[$key] = $redis->set($key, $val);
        }
        $redis->close();
        return $res;
    }

    /**
     * 设置一个周期字符串
     * @param array $arr [[key,time,value],[key1,time1,value1],...]
     * @return array $res
     */
    public static function setex($arr)
    {
        if (!is_array($arr)) {
            return false;
        }
        $redis = self::Init();
        $res = [];
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                dump("setex...............");
                echo $val[0]."-".$val[1]."-".$val[2]."\n";
                $res[$key] = $redis->setex($val[0], $val[1], $val[2]);
            } else {
                dump("set...............");
                $res[$key] = $redis->set($key, $val);
            }
        }
        $redis->close();
        return $res;
    }

    /**
     * 获取字符串
     * @param array|object|string $index  
     * @return array|string $res
     */
    public static function get($index = null)
    {
        if ($index === null || ((is_array($index) || is_object($index)) && empty($index))) {
            return false;
        }
        $redis = self::Init();
        if (is_array($index) || is_object($index)) {
            $res = [];
            foreach ($index as $key => $vo) {
                $res[$key] = $redis->get($vo);
            }
        } else {
            $res = $redis->get($index);
        }
        $redis->close();
        return $res;
    }

    /**
     * 删除指定的值
     * @param array|object|string $index
     * @return array|string $res
     */
    public static function del($index = null)
    {
        if ($index === null || ((is_array($index) || is_object($index)) && empty($index))) {
            return false;
        }
        $redis = self::Init();
        if (is_array($index) || is_object($index)) {
            $res = [];
            foreach ($index as $key => $vo) {
                $res[$key] = $redis->del($vo);
            }
        } else {
            $res = $redis->del($index);
        }
        $redis->close();
        return $res;
    }

    /**
     * @param array $arr
     * @return 
     */
    public static function lpush($arr){
        if(!is_array($arr)){
            return false;
        }
        $redis = self::Init();
        $res = [];
        foreach($arr as $key => $vo){
            $res[$key] = $redis->lpush($key, $vo);
        }
        $redis->close();
        return $res;
    }

    /**
     * @param array|string $index [key1,key2,key3,.....]|key
     * @return 
     */
    public static function lpop($index){
        $redis = self::Init();
        if(is_array($index)){
            foreach($index as $key => $vo){
                $res[] = $redis->lpop($vo);
            }
        }else{
            $res = $redis->lpop($index);
        }
        $redis->close();
        return $res;
    }

    /**
     * @param array|string $index [key1,key2,key3,.....]|key
     * @return 
     */
    public static function rpop($index){
        $redis = self::Init();
        if(is_array($index)){
            foreach($index as $key => $vo){
                $res[] = $redis->rpop($vo);
            }
        }else{
            $res = $redis->rpop($index);
        }
        $redis->close();
        return $res;
    }
}
