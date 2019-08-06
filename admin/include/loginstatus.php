<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
  //校验数据，当前访问用户的箱子（session）有没有登录的登录标识
  session_start();
  if(empty($_SESSION['current_login_user'])){
      //没有当前登录用户信息，跳转页面
      header('Location:login.php');
  }
?>
</body>
</html>