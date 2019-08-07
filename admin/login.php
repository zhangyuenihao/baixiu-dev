
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
<?php
    //载入配置文件
    require_once '../config.php';
    //给用户找一个箱子(session)如果你之前有就用之前的，没有就给个新的
      session_start();
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
       $conn=mysqli_connect(BX_DB_HOST,BX_DB_USER,BX_DB_PASS,BX_DB_NAME);
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
if($user['password']==md5($password)){
//用户名密码正确，通过Cookie保存用户的登录状态
//存一个登录标识
$_SESSION['current_login_user']=$user;
header('location:index.php');
exit;
}
$GLOBALS['message']='用户名账号不匹配';

}
//判断是否是post请求
if($_SERVER['REQUEST_METHOD']==='POST'){
login();
}
?>
  <script>NProgress.start()</script>
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
<script src="../static/assets/vendors/jquery/jquery.js"></script>
<script>
  $(function($) {
   //单独作用域
    //确保页面加载过后执行
    //目标：在用户输入自己的邮箱后显示对应头像
    //实现：
    //时机:邮箱文本框失去焦点，并且能够拿到文本框填写的邮箱是
    //事情：获取文本框头像，展示到img
    let emailFormat=/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-Z0-9]+$/;
    let imgsrc=$('.avatar').attr('src');
    $('#email').on('blur',function () {
       let value=$(this).val();
       //如果邮箱为空，或者格式不正确则返回
       if(!value||!emailFormat.test(value)){
         console.log(value)
         $('.avatar').fadeOut(function () {
           $(this).fadeIn();
         }).attr('src',imgsrc);
       }
       //通过ajax请求
      $.get('api/avatar.php',{email:value},function (res) {
        if(!res) return
        $('.avatar').fadeOut(function () {
         console.log(res)
          $(this).fadeIn();
        }).attr('src','..'+res);
      })

    })
  })
  NProgress.done()
</script>
</body>
</html>
