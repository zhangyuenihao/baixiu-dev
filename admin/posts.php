<?php
  require_once '../functions.php';
  //获取当前用户登录信息
  $current_user=bx_get_current_user();

    //接收筛选参数
    $where='1=1';
    $search='';
    if(isset($_GET['category'])&&$_GET['category']!=='all'){
    $where.=' and posts.category_id='.$_GET['category'];
    $search.='&category='.$_GET['category'];
    }
  if(isset($_GET['status'])&&$_GET['status']!=='all'){
    $where.=" and posts.status='{$_GET['status']}'";
    $search.='&status='.$_GET['status'];
    }

  //页码查询
  $size=20;
  $total_count=bx_fetch_one("select count(1) as count
                from posts
                inner join users on posts.user_id=users.id
                inner join categories on posts.category_id=categories.id
                where {$where}
                ")['count'];
  $total_page=ceil($total_count/$size);
  $page=empty($_GET['page'])?1:(int)$_GET['page'];
  $page=$page<=0?1:$page;
  $page=$page>=$total_page?$total_page:$page;
  //偏移量
  $offset=(int)($page-1)*$size;
  $visables=5;
  //处理分页页码
  $postsArr=bx_get_pages($total_page,$page,$size,$visables);
  $begin=$postsArr[0];
  $end=$postsArr[1];

   //posts关联users categories查询
  $posts=bx_fetch_all("select posts.id,posts.title,users.nickname as user_name,categories.name as category_name,posts.created,posts.status
  from posts
  inner join users on posts.user_id=users.id
  inner join categories on posts.category_id=categories.id
  where {$where}
  order by posts.created desc
  limit {$offset},{$size}");
  // var_dump($posts);
  //查询分类数据
  $categories=bx_fetch_all("select * from categories");
 //var_dump($categories);
  //处理数据格式转换
  //状态转换
    function convert_status($status){
         $dict=array(
         'published'=>'已发布',
          'drafted'=>'草稿',
          'trashed'=>'回收站'
         );
        return isset($dict[$status])?$dict[$status]:'未知';
    }
    //时间转换
    function convert_date($created){
        date_default_timezone_set("PRC");
        //时间戳
        $timestamp=strtotime($created);
        return date('Y年m月d日<b\r> H:i:s',$timestamp);
    }
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline" action="<?php echo $_SERVER['PHP_SELF'];?>">
          <select name="category" class="form-control input-sm">
            <option value="all" <?php echo isset($_GET['category'])=='all'?'selected':'';?>>所有分类</option>
            <?php foreach($categories as $item):?>
            <option value="<?php echo $item['id']?>" <?php echo isset($_GET['category'])&&$_GET['category']==$item['id']?'selected':'';?>><?php echo $item['name'];?></option>
            <?php endforeach;?>
          </select>
          <select name="status" class="form-control input-sm">
            <option value="all" <?php echo isset($_GET['status'])&&$_GET['status']=='all'?'selected':'';?>>所有状态</option>
            <option value="drafted" <?php echo isset($_GET['status'])&&$_GET['status']=='drafted'?'selected':'';?>>草稿</option>
            <option value="published" <?php echo isset($_GET['status'])&&$_GET['status']=='published'?'selected':'';?>>已发布</option>
            <option value="trashed" <?php echo isset($_GET['status'])&&$_GET['status']=='trashed'?'selected':'';?>回收站</option>
          </select>
          <button class="btn btn-default btn-sm">筛选</button>
        </form>
        <ul class="pagination pagination-sm pull-right">
        <?php if($page-1>0):?>
        <li><a href="?page=<?php echo ($page-1).$search;?>">&laquo;上一页</a></li>
        <?php endif;?>

        <?php if($begin>1):?>
        <li><a href="?page=<?php echo ($begin-1).$search;?>">&hellip;</a></li>
        <?php endif;?>
        <?php for($i=$begin;$i<=$end;$i++):?>
            <li <?php echo $i==$page?'class="active"':'';?>><a href="?page=<?php echo $i.$search?>"><?php echo $i;?></a></li>
        <?php endfor;?>
             <?php if($end<$total_page):?>
                <li><a href="?page=<?php echo ($end+1).$search;?>">&hellip;</a></li>
                <?php endif;?>
        <?php if($page<$total_page):?>
        <li><a href="?page=<?php echo ($page+1).$search;?>">下一页&raquo;</a></li>
        <?php endif;?>

        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
         <?php foreach($posts as $item):?>
           <tr>
             <td class="text-center"><input type="checkbox"></td>
             <td><?php echo $item['title'];?></td>
             <td><?php echo $item['user_name'];?></td>
             <td><?php echo $item['category_name'];?></td>
             <td class="text-center"><?php echo convert_date($item['created']);?></td>
             <td class="text-center"><?php echo convert_status($item['status']);?></td>
             <td class="text-center">
               <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
               <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
             </td>
           </tr>

         <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <?php $current_page='posts'; ?>
  <?php include 'include/sidebar.php';?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
