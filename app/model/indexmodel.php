<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/1/9 0009
 * Time: 下午 5:03
 */
namespace app\model;
use config\lib\model;

class indexmodel extends model{
    public function login($table,$where){
        $list = $this->find($table,'*',$where);
        return $list;
    }



}