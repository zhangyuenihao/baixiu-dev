<?php
require_once '../functions.php';
//判断是否为登录状态
$current_user=bx_get_current_user();

function add_posts($current_user){
//检验表单数据是否合法
       if(empty($_POST['slug'])||empty($_POST['title'])||empty($_POST['created'])||empty($_POST['content'])||empty($_POST['status'])||empty($_POST['category'])){
            $GLOBALS['success']=false;
            $GLOBALS['message']='请完整填写所有内容';
            return;
        }else if(bx_fetch_one("select count(1) as count from posts where slug='{$_POST['slug']}'")['count']>0){
                $GLOBALS['success']=false;
                $GLOBALS['message']='别名重复';
               return;
        }else{
        //数据合法
              if (empty($_FILES['feature']['error'])) {
                         // PHP 在会自动接收客户端上传的文件到一个临时的目录
                         $temp_file = $_FILES['feature']['tmp_name'];
                         // 我们只需要把文件保存到我们指定上传目录
                         $target_file = '../static/uploads/' . $_FILES['feature']['name'];
                         if (move_uploaded_file($temp_file, $target_file)) {
                           $image_file = '../static/uploads/' . $_FILES['feature']['name'];
                           var_dump($image_file);
                         }
                       }
        $slug = $_POST['slug'];
        $title = $_POST['title'];
        $feature = isset($image_file)?$image_file:''; // 图片稍后再考虑
        $created = $_POST['created'];
        $content = $_POST['content'];
        $status = $_POST['status'];
        // 作者 ID 可以从当前登录用户信息中获取
        $user_id = $current_user['id'];
        $category_id = $_POST['category'];
        $rows=bx_execute("insert into posts values (null,'{$slug}','{$title}','{$feature}','{$created}','{$content}',0,0,'{$status}',{$user_id},{$category_id})");
               //如果有返回数据

               if($rows>0){
               $GLOBALS['success']=true;
               $GLOBALS['message']='添加成功!';
               //成功跳转页面
               header('Location:posts.php');

               }else{
                $GLOBALS['success']=true;
               $GLOBALS['message']='添加失败!';
               }

        }

   }
if($_SERVER['REQUEST_METHOD']==='POST'){
  add_posts($current_user);
  }
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'include/navbar.php';?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
          <?php if(isset($message)):?>
                <?php if(!$success):?>
           <div class="alert alert-danger">
             <strong>错误！</strong><?php echo $message;?>
           </div>

                 <?php else:?>
           <div class="alert alert-success">
             <strong>成功！</strong><?php echo $message;?>
           </div>

                 <?php endif;?>
           <?php endif;?>
      <form class="row" action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容" ></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug" value="<?php echo isset($_POST['slug']) ? $_POST['slug'] : '' ?>">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file" accept="image/*">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="1">未分类</option>
              <option value="2">奇趣事</option>
              <option value="3">会生活</option>
              <option value="4">爱旅行</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local" value="<?php echo isset($_POST['created']) ? $_POST['created'] : '' ?>">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status" >
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit">保存</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <?php $current_page='post-add'; ?>
  <?php include 'include/sidebar.php';?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
