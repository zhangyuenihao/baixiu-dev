<?php
  //校验数据，当前访问用户的箱子（session）有没有登录的登录标识
  session_start();
  if(empty($_SESSION['current_login_user'])){
      //没有当前登录用户信息，跳转页面
      header('Location:login.php');
  }
?>