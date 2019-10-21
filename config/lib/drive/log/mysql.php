<?php
namespace config\lib\drive\log;

#数据库
use config\lib\conf;

class mysql{
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
     * 写sql日志
     * @param $message
     * @param $postfix
     * @return bool|int
     */
    public function log($message,$postfix='.sql.log'){
        /**
         * 1.确定文件存储位置是否存在
         * 新建目录
         * 2.写入日志
         */
        if (!is_dir($this->path.date('Ym'))){
            mkdir($this->path.date('Ym'),'0777',true);
        }

        $logPath = $this->path.date('Ym').'/'.date('d').$postfix;
//        $file = file_put_contents($logPath, date('H:i:s'). '--' . substr(microtime(), 2, 6) . '--' .json_encode($message).PHP_EOL,FILE_APPEND);
        error_log(date('H:i:s') . '--' . substr(microtime(), 2, 6) . '--' . $message . PHP_EOL, 3, $logPath);

    }
}