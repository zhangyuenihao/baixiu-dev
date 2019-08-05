
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
</head>
<body>
<?php
    //载入配置文件
    require_once '../config.php';
   //检测
   function login(){
   //1.接收并效验
   //2.持久化
   //3.响应
   $email=$_POST['email'];
   $password=$_POST['password'];
   //表单效验
       if(empty($email)){
         $GLOBALS['message']='请填写邮箱';
         return;
       }
          if(empty($password)){
         $GLOBALS['message']='请填密码';
         return;
       }
       $conn=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
       if(!$conn){
         exit('<h1>连接数据库失败</h1>');
}
$sql="select * from users where email='{$email}' limit 1";
$query=mysqli_query($conn,$sql);

if(!$query){
$GLOBALS['message']='登录失败，请重试';
return;
}
//只取第一行数据
$user=mysqli_fetch_assoc($query);
if(!$user){
$GLOBALS['message']='用户名不存在';
return;
}
if($user['password']!==$password){
$GLOBALS['message']='用户明与密码不匹配';
return;
}
header('location:index.php');
}
//判断是否是post请求
if($_SERVER['REQUEST_METHOD']==='POST'){
login();
}
?>
  <div class="login">
    <!--可以在form上添加novalidate取消浏览器自带的效验功能-->
    <form class="login-wrap" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" novalidate>
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <?php if(isset($message)):?>
       <div class="alert alert-danger">
          <strong>错误！</strong> <?php echo $message;?>
        </div>
      <?php endif;?>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" name="email" class="form-control" placeholder="邮箱" autofocus value="<?php echo isset($_POST['email'])? $_POST['email']:''; ?>">
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" name="password" type="password" class="form-control" placeholder="密码">
      </div>
      <button class="btn btn-primary btn-block">登 录</button>
    </form>
  </div>
</body>
</html>
