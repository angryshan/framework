<?php
namespace lss\mysql;
use mysqli;

class lssMySql{
    public $mysqli;
    protected $name;
    protected $host;
    protected $username;
    protected $password;
    protected $charset;
    protected $statement;

    public function __construct(array $config){

        $this->name = isset($config['database_name']) ? strtolower($config['database_name']) : '';
        $this->host = isset($config['host']) ? strtolower($config['host']) : 'localhost';
        $this->username = isset($config['username']) ? strtolower($config['username']) : 'root';
        $this->password = isset($config['password']) ? strtolower($config['password']) : '123';
        $this->charset = isset($config['charset']) ? strtolower($config['charset']) : 'utf8';
        $this->mysqli = new mysqli($this->host, $this->username , $this->password , $this->name);
        if ($this->mysqli ->connect_error) {
            die($this->mysqli ->connect_error) ;
        }
        mysqli_set_charset($this->mysqli , $this->charset);
    }

    /**
     * 插入数据
     * @param $table @数据表
     * @param $arr @数组 ['id'=>1]
     * @return bool|\mysqli_result
     */
    public function insert($table, $arr)
    {
        $keys = implode(',', array_keys($arr));
        $values = array_values($arr);

        $place = implode(',',array_fill(0,count($arr),'?'));

        $sql = "insert into $table ($keys)VALUES ($place)";
        return $this->query($sql,$values)->insert_id;
    }

    /**
     * 插入多条数据
     * @param $table
     * @param $arr  array 二维数组  [['id'=>1],['id'=>2]]
     * @return bool
     */
    public function insertArr($table, $arr)
    {
        $sql = '';
        foreach ($arr as $key => $value){
            $keys = implode(',', array_keys($value));
            $values = "'" . implode("','", array_values($value)) . "'";
            $sql .= "insert into $table ($keys)VALUES ($values)";
        }

        return $this->mysqli->multi_query($sql);
    }

    /**
     * 对sql语句预处理
     * @param $sql  string sql语句
     * @param $values array 需要处理的数组的val值
     * @return bool|\mysqli_stmt
     */
    public function query($sql,$values){
        $statement = $this->mysqli->prepare($sql);
        if ($statement){
            $params = array_merge([str_repeat('s',count($values))],$values);

            foreach ($params as $k=>$v){
                $params[$k] = &$params[$k];
            }

            call_user_func_array([$statement,'bind_param'],$params);//$stmt->bind_param("sss", $firstname, $lastname, $email);
            $statement->execute();
            $this->statement = $statement;

            return $statement;
        }
        return false;
    }

    /**
     * 查询一条数据
     * @param $table
     * @param string $find
     * @param string $where
     * @return array|null
     */
    public function find($table, $find = '*', $where = '')
    {
        $where = $where ? "where $where" : '';
        $sql = "select {$find} from {$table} " . $where;
        $res = $this->mysqli->query($sql);

        return mysqli_fetch_assoc($res);
    }

    /**
     * 查全部数据
     * @param $table
     * @param string $find
     * @param string $where
     * @return array|null
     */
    public function select($table, $find = '*', $where = '')
    {
        $where = $where ? "where $where" : '';
        $sql = "select {$find} from {$table} $where";
        $res = $this->mysqli->query($sql);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    /**
     * 获取总条数
     * @param $table
     * @param string $find
     * @param string $where
     * @return int
     */
    public function sql_count($table, $find = '*', $where = '')
    {
        $where = $where ? 'where ' . $where : '';
        $sql = "select {$find} from {$table} $where";
        $res = $this->mysqli->query($sql);
        return mysqli_num_rows($res);
    }

    /**
     * 数据表分页
     * @param int $curr 当前页
     * @param int $limit 每页的行数
     */
    public function page($table, $find = '*', $curr = 1, $limit = 10, $where = '')
    {
        $where = $where ? 'where ' . $where : '';
        $offset = ($curr - 1) * $limit;
        $sql = "select {$find} from {$table} $where limit $offset,$limit";
        $res = $this->mysqli->query($sql);
        return mysqli_fetch_all($res, MYSQLI_ASSOC);
    }

    /**
     * 修改
     * @param $table
     * @param $array
     * @param null $where
     * @return bool|int
     */
    public function update($table, $array, $where = null)
    {
        $str = '';
        foreach ($array as $key => $val) {
            if ($str == null) {
                $sep = "";
            } else {
                $sep = ",";
            }
            $str .= $sep . $key . "='" . $val . "'";
        }
        $sql = "update {$table} set {$str} " . ($where == null ? null : " where " . $where);//修改
        $res = $this->mysqli->query($sql);
        return $res;
    }

    /**
     * 删除
     * @param $table
     * @param $where
     * @return bool|\mysqli_result
     */
    public function del($table,$where){
        $sql = "DELETE FROM $table WHERE $where";
        $res = $this->mysqli->query($sql);
        return $res;
    }
}