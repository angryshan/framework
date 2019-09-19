<?php
namespace config\lib\dataStructure;
class dataStructure{
    public $arr ;

    public function __construct(array $arr){
        $this->arr = $arr;
    }


    /**
     * 最效率冒泡，正向或反向冒泡，取得最大值和最小值
     * @param $arr
     * @return mixed
     */
    public function bubbleSort() {
        $arr = $this->arr;
        $i = count($arr)-1;  //初始时,最后位置保持不变
        while ( $i> 0) {
            $pos= 0; //每趟开始时,无记录交换
            for ($j= 0; $j< $i; $j++)
                if ($arr[$j]> $arr[$j+1]) {
                    $pos= $j; //记录交换的位置
                    $tmp = $arr[$j]; $arr[$j]=$arr[$j+1];$arr[$j+1]=$tmp;
                }
            $i= $pos; //为下一趟排序作准备
        }

        return $arr;
    }

    /**
     * 两边一起冒泡，效率第二
     * @param $arr
     * @return mixed
     */
    public function bubbleSort2(){
        $arr = $this->arr;
        $low = 0;
        $high = count($arr) - 1; //设置变量的初始值

        while ($low < $high) {
            for ($j = $low; $j < $high; ++$j) //正向冒泡,找到最大者
                if ($arr[$j] > $arr[$j + 1]) {
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $tmp;
                }
            --$high;                 //修改high值, 前移一位
            for ($j = $high; $j > $low; --$j) //反向冒泡,找到最小者
                if ($arr[$j] > $arr[$j + 1]) {
                    $tmp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $tmp;
                }
        }
        return $arr;
    }

    /**
     * 简单冒泡
     * @param $arr
     * @return mixed
     */
    public function bubbleSort3(){
        $arr = $this->arr;
        for ($i=0;$i<count($arr);$i++){
            for ($j=0;$j<count($arr)-1-$i;$j++){
                if ($arr[$j]>$arr[$j+1]){
                    $temp = $arr[$j+1];
                    $arr[$j+1] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
        }
        return $arr;
    }

    /**
     * 选择排序
     * @param $arr
     * @return mixed
     */
    public function selectionSort($arr){

        $len = count($arr);
        //双重循环完成，外层控制轮数，内层控制比较次数
        for ($i=0;$i<$len-1;$i++){
            $minIndex = $i;//假设最小的数的坐标是i
            //循环找出最小的数值坐标
            for ($j=$i+1;$j<$len;$j++){
                if ($arr[$j] < $arr[$minIndex]){
                    //比较，发现更小的,记录下最小值的位置；并且在下次比较时采用已知的最小值进行比较。
                    $minIndex = $j;
                }
            }
            //最小数的坐标与当前要替换的初始坐标不等，替换两者的位置
            if ($minIndex!=$i){
                $temp = $arr[$i];
                $arr[$i] = $arr[$minIndex];
                $arr[$minIndex] = $temp;
            }
        }

        return $arr;
    }

    /**
     * 插入排序1
     * @param $arr
     * @return mixed
     */
    public function insertionSort($arr){
        $len = count($arr);
        //需要循环的次数
        for ($i=1;$i<$len;$i++){

            $key = $arr[$i];#获得当前需要比较的元素值。下一个元素值
            $j = $i-1;#已排序元素下标

            while ($j>=0 && $arr[$j]>$key){#前面的元素是否大于后面的元素
                $arr[$j+1] = $arr[$j];#前后位置替换，直到跳出循环
                $j--;
            }
            $arr[$j+1] = $key;#将当前值插入到指定位置

        }
        return $arr;
    }

    /**
     * 插入排序2
     * @param $arr
     * @return mixed
     */
    public function insertionSort2($arr){

        $len=count($arr);
        //需要循环的次数
        for($i=1; $i<$len; $i++) {

            $tmp = $arr[$i];#获得当前需要比较的元素值。下一个元素值

            //内层循环控制 比较 并 插入
            for($j=$i-1; $j>=0; $j--) {
                //$arr[$i];//需要插入的元素; $arr[$j];//需要比较的元素
                if($tmp < $arr[$j]) {
                    //发现插入的元素要小，交换位置
                    //将后边的元素与前面的元素互换
                    $arr[$j+1] = $arr[$j];
                    //将前面的数设置为 当前需要交换的数
                    $arr[$j] = $tmp;
                } else {
                    //如果碰到不需要移动的元素
                    //由于是已经排序好是数组，则前面的就不需要再次比较了。
                    break;
                }
            }
        }
        //将这个元素 插入到已经排序好的序列内。
        //返回
        return $arr;
    }

    /**
     * 插入排序-升级版,二分查找
     * @param $arr
     * @return mixed
     */
    public function binaryInsertionSort($arr) {

        //需要循环的次数
        for ($i = 1; $i < count($arr); $i++) {
            $key = $arr[$i]; #获得当前需要比较的元素值。下一个元素值
            $left = 0; #最左边
            $right = $i - 1;#当前比较的元素前的右边

            while ($left <= $right) {
                $middle = floor(($left + $right) / 2);#取中间数
                if ($key < $arr[$middle]) {#当前比较元素小于中间值，中间数的下标往前移一位
                    $right = $middle - 1;
                } else {#否则中间数的下标往后移一位
                    $left = $middle + 1;
                }
            }
            for ($j = $i - 1; $j >= $left; $j--) {
                $arr[$j + 1] = $arr[$j];
            }
            $arr[$left] = $key;
        }

        return $arr;
    }

    /**
     * 希尔排序
     * @param $arr array 需要排序的数组
     * @param $t int 定的多少会对排序时间复杂度有轻微影响
     * @return mixed
     */
    public function shellSort($arr,$t){
        $len = count($arr);
        $gap = 1;
        while($gap < $len/$t){
            $gap = $t+1;
        }
        for ($gap;$gap>0;$gap = floor($gap/$t)){
            for ($i=$gap;$i < $len;$i++){
                $temp = $arr[$i];
                for ($j = $i-$gap;$j >= 0 && $arr[$j]>$temp;$j-=$gap){
                    $arr[$j+$gap] = $arr[$j];
                }
                $arr[$j+$gap] = $temp;
            }
        }
        return $arr;
    }

}