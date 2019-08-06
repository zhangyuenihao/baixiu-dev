<?php
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

