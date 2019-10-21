<?php
namespace config\lib\drive\mysql;
use config\lib\conf;
use mysqli;

class Sql{
    protected $name;
    protected $host;
    protected $username;
    protected $password;
    protected $charset;
    protected $statement;

    protected  $link;//存放数据库资源

    /**
     * Sql constructor.
     */
    protected  function __construct(array $config)
    {
        $this->link = $this->connect($config);
    }

    /**
     * 数据库连接
     */
    public function connect(array $config)
    {
        $this->name = isset($config['database_name']) ? strtolower($config['database_name']) : '';
        $this->host = isset($config['host']) ? strtolower($config['host']) : 'localhost';
        $this->username = isset($config['username']) ? strtolower($config['username']) : 'root';
        $this->password = isset($config['password']) ? strtolower($config['password']) : '123';
        $this->charset = isset($config['charset']) ? strtolower($config['charset']) : 'utf8';

        $link = mysqli_connect($this->host, $this->username, $this->password,$this->name);
        if (!$link) {
            die('连接数据库失败');
        }
        mysqli_select_db($link,   $this->username );
        mysqli_set_charset($link, 'utf8');
        return $link;
    }

    /**
     * 写sql日志
     * @param $message
     * @param $postfix
     * @return bool|int
     */
    public function logs($message,$postfix='.sql.log'){
        /**
         * 1.确定文件存储位置是否存在
         * 新建目录
         * 2.写入日志
         */
        $conf = conf::get('log','config');//获取单个配置名
        $path = $conf['OPTION']['PATH'];
        if (!is_dir($path.date('Ym'))){
            mkdir($path.date('Ym'),'0777',true);
        }

        $logPath = $path.date('Ym').'/'.date('d').$postfix;
//        $file = file_put_contents($logPath, date('H:i:s'). '--' . substr(microtime(), 2, 6) . '--' .json_encode($message).PHP_EOL,FILE_APPEND);
        error_log(date('H:i:s') . '--' . substr(microtime(), 2, 6) . '--' . $message . PHP_EOL, 3, $logPath);

    }
}