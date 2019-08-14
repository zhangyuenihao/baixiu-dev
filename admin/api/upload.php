<?php
//var_dump($_FILES['avatar']);
//接收文件
//返回文件
//返回这个文件的访问url
if(empty($_FILES['avatar'])){
exit('必须上传文件');
}
$avatar=$_FILES['avatar'];
//var_dump($avatar);
if($avatar['error']!==0){
exit('上传失败');
}
//效验类型 大小
//移动文件到网站范围之内
$ext=pathinfo($avatar['name'],PATHINFO_EXTENSION);
$target='../../static/uploads/img-'.uniqid().'.'.$ext;
//var_dump($target);
if(!move_uploaded_file($avatar['tmp_name'],$target)){
exit('上传错误');
};
//上传成功
echo substr($target,3);
?>