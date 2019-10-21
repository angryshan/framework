<?php
namespace config\lib\drive\mysql;
use config\lib\conf;
use mysqli;

class Mysql extends Sql {
    protected $options;//存放mysql方法的数组
    protected $sql;//sql语句
    protected $tableName;//表名
    protected $setType;//操作类型
    public static $sqls;

    /**
     * 继承父类中的construct方法
     * sql_func constructor.
     */
    public function __construct(){
        $config = conf::get('database','config');
        parent::__construct($config);
        $this->initOptions();
    }

    /**
     * 日志
     * @param $msg
     */
    public function log($msg){
        parent::logs($msg);
    }

    /**
     * 外部调用受保护属性时间触发的方法
     * @param $name
     */
    public function __get($name){
        if ('sql' == $name) {
            $this->sql = $name;
        }
    }

    /**
     * 清空数组options中的值
     */
    protected function initOptions(){
        $array = ['table', 'field', 'where', 'group', 'order', 'having', 'limit'];
        foreach ($array AS $value) {
            $this->options[$value] = '';
            if ('table' == $value) {
                $this->options[$value] = $this->tableName;
            }
        }
    }

    /**
     * 获取sql语句
     * @return mixed
     */
    public static function getSql(){

        return self::$sqls ->sql;
    }

    /**
     * 获取table的方法
     * @param (string)$table
     * @return mixed
     */
    public static function table($table)
    {
        self::$sqls = new Mysql();
        if (!empty($table)) {
            self::$sqls ->options['table'] = $table;
        }
        return self::$sqls;
    }

    /**
     * 获取字段
     * function field
     * @param (string)$field
     * @return mixed
     */
    public function field($field='')
    {
        if (!empty($field)) {
            if (is_string($field)) {
                $this->options['field'] = $field;
            } else if (is_array($field)) {
                $this->options['field'] = join(',',$field);
            }
        } else {
            $this->options['field'] = '*';
        }
        return $this;
    }

    /**
     * where 方法
     * @param mixed $where
     * @return $this
     */
    public function where($where)
    {
        if (!empty($where)) {
            if (is_string($where)) {
                $this->options['where'] = 'WHERE ' . $where;
            } else if (is_array($where)) {
                $where = $this->parseValue($where);
                $data = '';
                foreach ($where AS $key => $value) {
                    if ('' === $data) {
                        $data .= $key . '=' . $value . ' ';
                    } else {
                        $data .= 'AND ' . $key . '=' . $value . ' ';
                    }
                }
                $this->options['where'] = 'WHERE ' . $data;
            }
        }
        return $this;
    }

    /**
     * group 方法（根据（）分组）
     * @param string $group
     * @return $this
     */
    public function group($group)
    {
        if (!empty($group)) {
            $this->options['group'] = 'GROUP BY ' . $group;
        }
        return $this;
    }

    /**
     * order 方法（order by () desc/asc）
     * @param string $order
     * @return $this
     */
    public function order($order)
    {
        if (!empty($order)) {
            $this->options['order'] = 'ORDER BY ' . $order;
        }
        return $this;
    }

    /**
     * having 方法
     * @param string $having
     * @return $this
     */
    public function having($having)
    {
        if (!empty($having)) {
            $this->options['having'] = 'HAVING ' . $having;
        }
        return $this;
    }

    /**
     * limit 方法
     * @param array $limit
     * @return $this
     */
    public function limit($limit)
    {
        if (!empty($limit)) {
            if (is_string($limit)) {
                $this->options['limit'] = 'LIMIT ' . $limit;
            } else if (is_array($limit)) {
                $this->options['limit'] = 'LIMIT ' . join(',', $limit);
            }
        }
        return $this;
    }

    /**
     * select 方法
     * is_one 是否查找一条记录
     * @return array
     */
    public function select($is_one = false){
        if (empty($this->options['field'])) {
            $this->options['field'] = '*';
        }
        $sql = 'SELECT %FIELD% FROM %TABLE% %HAVING% %GROUP% %ORDER% %WHERE% %LIMIT%';
        $sql = str_replace(['%FIELD%', '%TABLE%', '%HAVING%', '%GROUP%', '%ORDER%', '%WHERE%', '%LIMIT%'],
            [$this->options['field'], $this->options['table'], $this->options['having'], $this->options['group'],
                $this->options['order'], $this->options['where'], $this->options['limit']], $sql);

        $this->sql = $sql;
        return $this->query($sql,$is_one?2:'');
    }

    /**
     * insert 方法
     * @param array $data
     * @return array
     */
    public function insert($data)
    {
        $data = $this->parseValue($data);
        $keys = array_keys($data);
        $values = array_values($data);
        $sql = 'INSERT INTO %TABLE%(%FIELD%) values(%VALUES%)';
        $sql = str_replace(['%TABLE%', '%FIELD%', '%VALUES%'],
            [$this->options['table'], join(',', $keys), join(',', $values)], $sql);
        $this->sql = $sql;
        return $this->exec($sql);
    }

    /**
     * delete 方法
     * @return mixed
     */
    public function delete()
    {
        $sql = 'DELETE FROM %TABLE% %WHERE%';
        $sql = str_replace(['%TABLE%', '%WHERE%'], [$this->options['table'], $this->options['where']], $sql);
        $this->sql = $sql;
        return $this->exec($sql);
    }

    /**
     * updata 方法
     * @param array $data
     * @return mixed
     */
    public function update($data)
    {
        $data = $this->parseValue($data);
        $value = $this->parseUpdate($data);
        $sql = 'UPDATE %TABLE% SET %VALUE% %WHERE%';
        $sql = str_replace(['%TABLE%', '%VALUE%', '%WHERE%'], [$this->options['table'], $value, $this->options['where']], $sql);
        $this->sql = $sql;
        return $this->exec($sql);
    }

    /**
     *将数组拼接成固定格式
     * @param array $data
     * @return string
     */
    protected function parseUpdate($data)
    {
        foreach ($data AS $key=>$value) {
            $newData[] = $key . '=' . $value;
        }
        return join(',', $newData);
    }

    /**
     *给数组中值为字符串的加引号
     * @param array $data
     * @return array
     */
    protected function parseValue($data)
    {
        $newData = [];
        foreach ($data AS $key=>$value)
        {
            if (is_string($value)) {
                $value = '"' . $value . '"';
            }
            $newData[$key] = $value;
        }
        return $newData;
    }

    /**
     * query 方法
     * @param (string)$sql
     * @return array
     */
    public function query($sql,$type=1)
    {
        $this->initOptions();//清空数组中的值
        $res = mysqli_query($this->link, $sql);
        if (false !== $res) {
            switch ($type){
                case 1:$row = $res->fetch_all(MYSQLI_ASSOC);break;
                case 2:$row = $res->fetch_assoc();break;
            }
            $this->log($sql.'查询成功');
            return $row;
        } else {
            $this->log($sql.'查询失败');
            var_dump(mysqli_error($this->link));
            die('查询失败');
        }
    }

    /**
     * function exec
     * @param $sql
     * @return mixed
     */
    public function exec($sql){
        $this->initOptions();
        $res = mysqli_query($this->link, $sql);
        if (false === $res) {
            var_dump(mysqli_error($this->link));
            $this->log($sql.'操作失败');
            return false;
        } else {
            $this->log($sql.'操作成功');
            return mysqli_affected_rows($this->link);
        }
    }


}