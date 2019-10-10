<?php
namespace config\lib\dataStructure;
/**
 * 排序算法
 * Class sortStructure
 * @package config\lib\dataStructure
 */
class sortStructure{
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

    /**
     * 快速排序1
     * @param $arr array 待排序数组
     * @return array
     */
    public function quickSort($arr) {
        if (count($arr) <=1){
            return $arr;
        }
        $pivotIndex = floor(count($arr)/2);//关机键字的位置
        $pivot = array_splice($arr,$pivotIndex,1)[0];//关键字
        $left = [];
        $right = [];
        for ($i = 0;$i<count($arr);$i++){
            if ($arr[$i] < $pivot){
                array_push($left,$arr[$i]);
            }else{
                array_push($right,$arr[$i]);
            }
        }
        return array_merge($this->quickSort($left),[$pivot],$this->quickSort($right));
    }

    /**
     * 快速排序
     * @param $arr @待排数组
     * @param $left @
     * @param $right
     * @return mixed
     */
    public function quickSort2($arr,$left,$right){
        if ($left<$right){

            $x = $arr[$right];
            $i=$left-1;

            for ($j = $left;$j<=$right;$j++){
                if ($arr[$j] <= $x){
                    $i++;
                    $temp = $arr[$i];
                    $arr[$i] = $arr[$j];
                    $arr[$j] = $temp;
                }
            }
            $arr = $this->quickSort2($arr,$left,$i-1);
            $arr =$this->quickSort2($arr,$i+1,$right);
        }
        return $arr;
    }

    /**
     * 堆排序
     * @param $arr @排序数组
     * @return mixed
     */
    public function heapSort($arr){
        $heapSize = count($arr);//数组长度大小

        //找出顶端最大的元素
        for ($i = floor($heapSize/2)-1;$i>=0;$i--){//$i当前节点的下标
            $arr = $this->heapify($arr,$i,$heapSize);//大根堆排序
        }

        //$arr已经按照大根堆排序好，将最大元素沉到数组末端
        for ($j = $heapSize-1;$j>=1;$j--){
            //最后一个元素与第一个元素交换
            $temp = $arr[0];
            $arr[0] = $arr[$j];
            $arr[$j] = $temp;

            //除了最后一个元素位置不变，其他的按照大根堆排序
            $arr = $this->heapify($arr,0,--$heapSize);

        }

        return $arr;
    }

    /**
     * 按大根堆排序好
     * @param $arr @数组
     * @param $x @当前节点下标
     * @param $len @数组长度
     * @return mixed
     */
    public function heapify($arr,$x,$len){
        $l = 2*$x+1;//左子树下标
        $r = 2*$x+2;//右子树下标
        $largest = $x;//当前节点下标
        if ($l < $len && $arr[$l]>$arr[$largest]){//左子树下标小于总长度，且左子树的值大于当前节点的值
            $largest = $l;//当前节点的值=左子树的值
        }
        if ($r < $len && $arr[$r] > $arr[$largest]){//道理同上
            $largest = $r;
        }

        //交换数组当前节点与非当前节点的值
        if ($largest !=$x){
            $temp = $arr[$x];
            $arr[$x] = $arr[$largest];
            $arr[$largest] = $temp;
            $arr = $this->heapify($arr,$largest,$len);
        }

        return $arr;
    }

    /**
     * 计数排序
     * @param $arr
     * @return array
     */
    public function countingSort($arr){
        $len = count($arr);//数组长度

        $c = $b = [];
        $min = $max = 0;

        //通过循环找出数组中的最大值和最小值   或者可用max（$arr） min($arr)
        for ($i=0;$i<$len;$i++){
            $min = $min <= $arr[$i] ? $min : $arr[$i];
            $max = $max >= $arr[$i] ? $max : $arr[$i];
            $c[$arr[$i]] = 1;
        }

        for ($j = $min; $j < $max;$j++){
            $c[$j+1] = ($c[$j+1] ? $c[$j+1] : 0 ) + ($c[$j] ? $c[$j] : 0);
        }

        for ($k= $len-1; $k>=0;$k--){
            $b[$c[$arr[$k]]-1] = $arr[$k];
            $c[$arr[$k]]--;
        }
        ksort($b);//由于php的数组是键值对的存在，因此只能再排序了
        return $b;
    }

}