<?php
/**
*根据客户端传来的id删除对应数据
**/
require_once '../functions.php';
if(empty($_GET['id'])){
exit('缺少必要参数');
}
//$id=(int)$_GET['id'];
//'id=1or1=1'   获取的id是1永远等于1就会把所有的都删掉
//sql注入
$id=$_GET['id'];
$rows=bx_execute('delete from posts where id in('.$id.')');
var_dump($rows);
//http referer访问请求的来源
header('Location:'.$_SERVER['HTTP_REFERER']);
