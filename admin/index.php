<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <title>Dashboard &laquo; Admin</title>
    <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
    <link rel="stylesheet" href="../static/assets/css/admin.css">
    <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
    <script src="../static/assets/vendors/echarts/echarts.min.js"></script>
</head>
<body>
<?php
//echo dirname(__FILE__);
 require_once '../functions.php';
$current_user=bx_get_current_user();
//连接数据库
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
 $posts_count=bx_fetch($conn,'select count(1) as num from posts')['num'];
//草稿数
$postsStatus_count=bx_fetch($conn,'select count(1) as num from posts where status = "drafted"')['num'];
$categories_count=bx_fetch($conn,'select count(1) as num from categories')['num'];
//var_dump($categories_count['num']);

$comments_count=bx_fetch($conn,'select count(1) as num from comments')['num'];
//评论待审核
$commentsStatus_count=bx_fetch($conn,'select count(1) as num from comments where status = "held"')['num'];
mysqli_close($conn);
?>
<script>NProgress.start()</script>

<div class="main">
   <?php include 'include/navbar.php';?>
    <div class="container-fluid">
        <div class="jumbotron text-center">
            <h1>One Belt, One Road</h1>
            <p>Thoughts, stories and ideas.</p>
            <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">站点内容统计：</h3>
                    </div>
                    <ul class="list-group">
                        <li class="list-group-item"><strong><?php echo $posts_count;?></strong>篇文章（<strong><?php echo $postsStatus_count;?></strong>篇草稿）</li>
                        <li class="list-group-item"><strong><?php echo $categories_count;?></strong></strong>个分类</li>
                        <li class="list-group-item"><strong><?php echo $comments_count;?></strong></strong>条评论（<strong><?php echo $commentsStatus_count;?></strong>条待审核）</li>
                 </ul>
                </div>
            </div>
            <div class="col-md-4" >
                <div id="main"style="height: 182px"></div>
            </div>
            <div class="col-md-4"></div>
        </div>
    </div>
</div>
<?php $current_page='index'; ?>
<?php include 'include/sidebar.php';?>

<script src="../static/assets/vendors/jquery/jquery.js"></script>
<script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
<script>
    // 绘制图表。
    echarts.init(document.getElementById('main')).setOption({

        tooltip: {},
        legend: {
            orient: 'vertical',
            x: 'left',
            data:['文章','分类','评论','已发布','草稿','已审核','未审核']
        },
        series: [
            {
               name:'站点内容统计',
                type:'pie',
                selectedMode: 'single',
                radius: [0, '30%'],

                label: {
                    normal: {
                        position: 'inner'
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },

                data:[
                    {value:<?php echo $posts_count;?>, name:'文章', selected:true},
                    {value:<?php echo $categories_count;?>, name:'分类'},
                    {value:<?php echo $comments_count;?>, name:'评论'}
                ]

            },
            {
                name:'站点内容统计',
                type:'pie',
                radius: ['40%', '55%'],
                data:[
                    {value:<?php echo $posts_count-$postsStatus_count;?>, name:'已发布'},
                    {value:<?php echo $postsStatus_count;?>, name:'草稿'},
                    {value:<?php echo $categories_count;?>, name:'分类'},
                    {value:<?php echo $comments_count-$commentsStatus_count;?>, name:'已审核'},
                    {value:<?php echo $commentsStatus_count;?>, name:'未审核'}
                ]

            }
        ]
    });
</script>
<script>NProgress.done()</script>
</body>
</html>
