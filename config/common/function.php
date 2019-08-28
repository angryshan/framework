<?php
/**
 * 显示分页
 * @param $curr @当前页
 * @param $page @总页数
 * @param null $where @条件
 * @param string $sep
 * @return string
 */
function showPage($curr,$page,$where = null,$sep = "&nbsp;"){
    $where = ($where == null) ? null : "&".$where;
    $url = $_SERVER['PHP_SELF'];
    $index = ($curr == 1) ? '首页':"<a href='{$url}?curr=1{$where}'>首页</a>";
    $last = ($curr == $page) ? "尾页" : "<a href='{$url}?curr={$page}{$where}'>尾页</a>";
    $prevPage=($curr>=1)?$curr-1:1;
    $nextPage=($curr>=$page)?$page:$curr+1;
    $prev = ($curr == 1) ? "上一页" : "<a href='{$url}?curr={$prevPage}{$where}'>上一页</a>";
    $next = ($curr == $page) ? "下一页" : "<a href='{$url}?curr={$nextPage}{$where}'>下一页</a>";
    $str = "总共{$page}页/当前是第{$curr}页";
    $p = '';
    for($i = 1; $i <= $page; $i ++) {
        //当前页无连接
        if ($curr == $i) {
            $p .= "[{$i}]";
        } else {
            $p .= "<a href='{$url}?curr={$i}{$where}'>[{$i}]</a>";
        }
    }
    $pageStr=$str.$sep . $index .$sep. $prev.$sep . $p.$sep . $next.$sep . $last;
    return $pageStr;
}