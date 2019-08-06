<?php
 require_once '../../config.php';
 if(empty($_GET['email'])){
   exit('缺少必要参数');
 }
 $email=$_GET['email'];
 //连接数据库
 $conn=mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
 if(!$conn){
 exit('连接数据库失败');
 }
 $sql="select avatar from users where email='{$email}'";
 $result=mysqli_query($conn,$sql);
 if(!$result){
  exit('查询失败');
 }
 //获取一行数据
 $row=mysqli_fetch_assoc($result);
 echo $row['avatar'];
?>
