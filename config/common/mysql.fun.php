<?php
//链接数据库
function connect(){
    $conn = mysqli_connect(HOST,USERNAME,PASSWORD,TABLE);//数据库帐号密码为安装数据库时设置
    if(mysqli_errno($conn)){
        echo mysqli_errno($conn);
        exit;
    }
    mysqli_set_charset($conn,'utf8');
}
function conn(){
    $conn = mysqli_connect(HOST,USERNAME,PASSWORD,TABLE);//数据库帐号密码为安装数据库时设置
    return $conn;
}

function msg($msg,$url){
    echo "<script>alert('$msg')</script>";
    echo "<script>window.location='$url'</script>";
}


/**
 * 添加数据库
 * @param $table @数据表
 * @param $arr @数组
 * @return bool|mysqli_result
 */
function insert($table,$arr){
    $keys = implode(',',array_keys($arr));
    $values = "'".implode("','",array_values($arr))."'";
    $sql = "insert into $table ($keys)VALUES ($values)";
    return mysqli_query(conn(),$sql);
}

/**
 * 查询一条数据
 * @param $table
 * @param string $find
 * @param string $where
 * @return array|null
 */
function find($table,$find='*',$where=''){
    $where = $where?"where $where":'';
    $sql = "select {$find} from {$table} ".$where;
    $res = mysqli_query(conn(),$sql);
    return mysqli_fetch_assoc($res);
}

/**
 * 查全部数据
 * @param $table
 * @param string $find
 * @param string $where
 * @return array|null
 */
function select($table,$find='*',$where=''){
    $where = $where?"where $where":'';
    $sql = "select {$find} from {$table} $where";
    $res = mysqli_query(conn(),$sql);
    return mysqli_fetch_all($res,MYSQLI_ASSOC);
}

/**
 * 获取总条数
 * @param $table
 * @param string $find
 * @param string $where
 * @return int
 */
function sql_count($table,$find='*',$where=''){
    $where = $where?'where '.$where:'';
    $sql = "select {$find} from {$table} $where";
    $res = mysqli_query(conn(),$sql);
    return mysqli_num_rows($res);
}

/**
 * 数据表分页
 * @param int $curr 当前页
 * @param int $limit 每页的行数
 */
function page($table,$find='*',$curr=1,$limit=10,$where=''){
    $where = $where?'where '.$where:'';
    $offset = ($curr-1)*$limit;
    $sql = "select {$find} from {$table} $where limit $offset,$limit";
    $res = mysqli_query(conn(),$sql);
    return mysqli_fetch_all($res,MYSQLI_ASSOC);
}
/**
 * 修改
 * @param $table
 * @param $array
 * @param null $where
 * @return bool|int
 */
function update($table,$array,$where=null){
    $str = '';
    foreach($array as $key=>$val){
        if($str==null){
            $sep = "";
        }else{
            $sep = ",";
        }
        $str.=$sep.$key."='".$val."'";
    }
    $sql = "update {$table} set {$str} ".($where==null?null:" where ".$where);//修改
    $result = mysqli_query(conn(),$sql);//执行mysql
    return $result;
}