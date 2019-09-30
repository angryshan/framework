<?php
namespace config\lib;
class lssRedis{

    #redis 初始化
    public static $redis = [];

    public function __construct()
    {
        self::$redis = new \Redis();
        self::$redis ->connect('0.0.0.0', 6379);
    }

    /**
     * 设置字符串
     * @param $key
     * @param $value
     * @return bool
     */
    public static function set($key,$value){
        return self::$redis->set($key,$value);
    }

    /**
     * 获取指定 key 的值
     * @param $key
     * @return bool|string
     */
    public static function get($key){
        return self::$redis->get($key);
    }

    /**
     * 命令用于获取存储在指定 key 中字符串的子字符串
     * 字符串的截取范围由 start 和 end 两个偏移量决定(包括 start 和 end 在内)
     * @param $key
     * @param $start
     * @param $end
     * @return string
     */
    public static function getRange($key,$start,$end){
        return self::$redis->getRange($key,$start,$end);
    }

    /**
     * 用于设置指定 key 的值，并返回 key 的旧值。
     * @param $key
     * @param $value
     * @return string
     */
    public static function getSet($key,$value){
        return self::$redis->getSet($key,$value);
    }

    /**
     * 对 key 所储存的字符串值，获取指定偏移量上的位(bit)
     * @param $key
     * @param $start
     * @param $end
     * @return int
     */
    public static function getBit($key,$start,$end){
        return self::$redis->getBit($key,$start);
    }



}