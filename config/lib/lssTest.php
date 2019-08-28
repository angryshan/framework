<?php

namespace config\lib;
/**
 * 方法测试
 * Class lssTest
 * @package config\lib
 */
class lssTest{
    public $ch;
    public function __construct()
    {
        $this->ch = curl_init();//初始化CURL句柄
    }

    public function geturl($url){
        $headerArray =array("Content-type:application/json;","Accept:application/json");

        curl_setopt($this->ch , CURLOPT_URL, $url);
        curl_setopt($this->ch , CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->ch , CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($this->ch , CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($url,CURLOPT_HTTPHEADER,$headerArray);

        $output = $this->com();
        return $output;
    }


    public function posturl($url,$data){
        $data  = json_encode($data);
        $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");

        curl_setopt($this->ch , CURLOPT_URL, $url);
        curl_setopt($this->ch , CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($this->ch , CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($this->ch , CURLOPT_POST, 1);
        curl_setopt($this->ch , CURLOPT_POSTFIELDS, $data);
        curl_setopt($this->ch ,CURLOPT_HTTPHEADER,$headerArray);
        curl_setopt($this->ch , CURLOPT_RETURNTRANSFER, 1);

        $output = $this->com();
        return $output;
    }


    public function puturl($url,$data){
        $data = json_encode($data);

        curl_setopt($this->ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt ($this->ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($this->ch, CURLOPT_CUSTOMREQUEST,"PUT"); //设置请求方式
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $data);//设置提交的字符串

        $output = $this->com();
        return $output;
    }

    public function delurl($url,$data){
        $data  = json_encode($data);

        curl_setopt ($this->ch,CURLOPT_URL,$url);
        curl_setopt ($this->ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt ($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($this->ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($this->ch, CURLOPT_POSTFIELDS,$data);

        $output = $this->com();
        return $output;
    }

    public function patchurl($url,$data){
        $data  = json_encode($data);

        curl_setopt ($this->ch,CURLOPT_URL,$url);
        curl_setopt ($this->ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt ($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($this->ch, CURLOPT_CUSTOMREQUEST, "PATCH");
        curl_setopt($this->ch, CURLOPT_POSTFIELDS,$data);     //20170611修改接口，用/id的方式传递，直接写在url中了

        $output = $this->com();
        return $output;
    }

    public function com(){
        $output = curl_exec($this->ch);
        curl_close($this->ch);
        $output = json_decode($output);
        return $output;
    }
}