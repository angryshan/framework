<?php
namespace config\lib\drive\cache;
use config\lib\conf;
use config\lib\drive\cache\Redis;

class lssRedis extends Redis {

    #redis 初始化
    private $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $host = conf::get('redis','config');
        $this->redis ->connect($host['host'], $host['port']);
    }

    /**
     * 设置字符串
     * @param $key
     * @param $value
     * @return bool
     */
    public function set($key,$value){
        return $this->redis->set($key,$value);
    }

    /**
     * 获取指定 key 的值
     * @param $key
     * @return bool|string
     */
    public function get($key){
        return $this->redis->get($key);
    }

    /**
     * 命令用于获取存储在指定 key 中字符串的子字符串
     * 字符串的截取范围由 start 和 end 两个偏移量决定(包括 start 和 end 在内)
     * @param $key
     * @param $start
     * @param $end
     * @return string
     */
    public function getRange($key,$start,$end){
        return $this->redis->getRange($key,$start,$end);
    }

    /**
     * 用于设置指定 key 的值，并返回 key 的旧值。
     * @param $key
     * @param $value
     * @return string
     */
    public function getSet($key,$value){
        return $this->redis->getSet($key,$value);
    }

    /**
     * 对 key 所储存的字符串值，获取指定偏移量上的位(bit)
     * @param $key
     * @param $start
     * @param $end
     * @return int
     */
    public function getBit($key,$start,$end){
        return $this->redis->getBit($key,$start);
    }



}