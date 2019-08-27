<?php
namespace config\lib\drive\log;
use config\lib\conf;
class file{
    public $path;#日志存储位置

    /**
     * 初始化
     * file constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $conf = conf::get('log','config');//获取单个配置名
        $this->path = $conf['OPTION']['PATH'];
    }

    /**
     * 写日志
     * @param $message
     * @param $postfix
     * @return bool|int
     */
    public function log($message,$postfix='.log'){
        /**
         * 1.确定文件存储位置是否存在
         * 新建目录
         * 2.写入日志
         */
        if (!is_dir($this->path.date('Ym'))){
            mkdir($this->path.date('Ym'),'0777',true);
        }
        $file = file_put_contents($this->path.date('Ym').'/'.date('d').$postfix,
            date('Y-m-d H:i:s').json_encode($message).PHP_EOL,FILE_APPEND);
        return $file;
    }
}