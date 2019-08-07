<?php

 require_once '../config.php';

 /**
 *封装公共函数
 **/
session_start();
//判断函数是否未定义
/**
 *获取当前用户登录信息
 **/
function bx_get_current_user(){
   if(empty($_SESSION['current_login_user'])){
    //没有当前用户信息，意味着没有登录，跳转到登录界面
    header('Location:login.php');
    exit();//没有必要再执行以后的代码
    }
    return $_SESSION['current_login_user'];
}
/**
*通过数据库查询获取多条数据
**/
function bx_fetch_all($sql){

 //连接数据库
 $conn=mysqli_connect(BX_DB_HOST,BX_DB_USER,BX_DB_PASS,BX_DB_NAME);
 if(!$conn){
 exit('连接数据库失败');
 }

 $query=mysqli_query($conn,$sql);
 if(!$query){
  return false;
 }
 //获取数据
 while($row=mysqli_fetch_assoc($query)){
 $result[]=$row;
 }
 mysqli_free_result($query);
 mysqli_close($conn);
 return $result;
}
/**
*通过数据库查询获取单条数据
**/
function bx_fetch_one($sql){
 $res=bx_fetch_all($sql);
 return isset($res[0])?$res[0]:null;
}
/**
*查询多条数据，但只连接一次
**/
function bx_fetch_more(){
  $conn=mysqli_connect(BX_DB_HOST,BX_DB_USER,BX_DB_PASS,BX_DB_NAME);
  if(!$conn){
  exit('连接数据库失败');
  }
  function bx_fetch($conn,$sql){
    $query=mysqli_query($conn,$sql);
    if(!$query){
    return false;
    }
    //获取数据
    while($row=mysqli_fetch_assoc($query)){
      $result[]=$row;
    }
    mysqli_free_result($query);
    return isset($result[0])?$result[0]:'';
  }
   //评论待审核
   //$commentsStatus_count=bx_fetch($conn,'select count(1) as num from comments where status = "held"')['num'];
   mysqli_close($conn);
}
 /**
 *执行一个增删改数据
 **/
function bx_execute($sql){

 //连接数据库
 $conn=mysqli_connect(BX_DB_HOST,BX_DB_USER,BX_DB_PASS,BX_DB_NAME);
 if(!$conn){
 exit('连接数据库失败');
 }
 $query=mysqli_query($conn,$sql);
 if(!$query){
  return false;
 }
 //增删改获取数据
 $affected_rows=mysqli_affected_rows($conn);

 mysqli_close($conn);
 return $affected_rows;
}