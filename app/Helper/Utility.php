<?php

/*常用方法*/
 
//分页
//Tcount 总数
//Tpage	 每页显示数量
//p		 参数
function multi($Tcount, $Tpage, $p, $url='', $url1='') {

    $mu = "";

    //总页数
    $z = ceil($Tcount / $Tpage);
    $l = 6;	//长度
    $v = $l/2;

    $mu .= "共 ".$Tcount." 条记录<div class=\"am-fr\">\r\n<ul class=\"am-pagination\">";
    if($p>1)  $mu .= "<li><a href=\"".$url.$url1."\">首页</a></li>\r\n";
    if($p>$v) $mu .= "...\r\n";
    //开始
    $ca = (($p - $v)<0) ? 0 : ($p - $v);
    //结束
    $cb = (($p + $v)>$z) ? $z : ($p + $v);

    if($cb-$ca<($l+1)){
        $x = ($l+1)-($cb-$ca);
        if($ca==0 && $cb<$z){
            if(($z-$cb)<$x){
                $cb = $cb + ($z-$cb);
            }else{
                $cb = $cb + $x;
            }
        }elseif($cb==$z && $ca>0){
            if(($ca-$x)<0){
                $ca = 0;
            }else{
                $ca = $ca - $x;
            }
        }
    }

    for($i=$ca;$i<$cb;$i++){
        if($p==($i+1)){
            $mu .= "<li class=\"am-active\"><a href=\"".$url.$url1."\">".intval($i+1)."</a></li>\r\n";
        }else{
            if($i==0){
                $mu .= "<li><a href=\"".$url.$url1."\" >".intval($i+1)."</a></li>\r\n";
            }else{
                $mu .= "<li><a href=\"".$url.($i+1).$url1."\">".intval($i+1)."</a></li>\r\n";
            }
        }
    }

    if(($p+$v)<$z) $mu .= "...\r\n";
    if($p<$z) $mu .= "<li><a href=\"".$url.$z.$url1."\">尾页</a></li>\r\n";
    $mu .= "</ul></div>";
    return $mu;
}
