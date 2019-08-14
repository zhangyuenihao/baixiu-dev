<?php
 require_once '../functions.php';
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Comments &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <style>
  .lds-default {
    display: inline-block;
    position: fixed;
    top:50%;
    left:50%;
    transform:(translat(-50%,-50%));
    width: 64px;
    height: 64px;
    display:none;
  }
  .lds-default div {
    position: absolute;
    width: 5px;
    height: 5px;
    background: #ccc;
    border-radius: 50%;
    animation: lds-default 1.2s linear infinite;
  }
  .lds-default div:nth-child(1) {
    animation-delay: 0s;
    top: 29px;
    left: 53px;
  }
  .lds-default div:nth-child(2) {
    animation-delay: -0.1s;
    top: 18px;
    left: 50px;
  }
  .lds-default div:nth-child(3) {
    animation-delay: -0.2s;
    top: 9px;
    left: 41px;
  }
  .lds-default div:nth-child(4) {
    animation-delay: -0.3s;
    top: 6px;
    left: 29px;
  }
  .lds-default div:nth-child(5) {
    animation-delay: -0.4s;
    top: 9px;
    left: 18px;
  }
  .lds-default div:nth-child(6) {
    animation-delay: -0.5s;
    top: 18px;
    left: 9px;
  }
  .lds-default div:nth-child(7) {
    animation-delay: -0.6s;
    top: 29px;
    left: 6px;
  }
  .lds-default div:nth-child(8) {
    animation-delay: -0.7s;
    top: 41px;
    left: 9px;
  }
  .lds-default div:nth-child(9) {
    animation-delay: -0.8s;
    top: 50px;
    left: 18px;
  }
  .lds-default div:nth-child(10) {
    animation-delay: -0.9s;
    top: 53px;
    left: 29px;
  }
  .lds-default div:nth-child(11) {
    animation-delay: -1s;
    top: 50px;
    left: 41px;
  }
  .lds-default div:nth-child(12) {
    animation-delay: -1.1s;
    top: 41px;
    left: 50px;
  }
  @keyframes lds-default {
    0%, 20%, 80%, 100% {
      transform: scale(1);
    }
    50% {
      transform: scale(1.5);
    }
  }
  </style>
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include 'include/navbar.php';?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>所有评论</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <div class="btn-batch" style="display: none">
          <button class="btn btn-info btn-sm">批量批准</button>
          <button class="btn btn-warning btn-sm">批量拒绝</button>
          <button class="btn btn-danger btn-sm">批量删除</button>
        </div>
        <ul class="pagination pagination-sm pull-right">

        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th width="80">作者</th>
            <th>评论</th>
            <th width="150">评论在</th>
            <th width="100">提交于</th>
            <th>状态</th>
            <th class="text-center" width="150">操作</th>
          </tr>
        </thead>
        <tbody>

        </tbody>
      </table>

    </div>

  </div>
  <?php $current_page='comments'; ?>
  <?php include 'include/sidebar.php';?>
   <div class="lds-default">
              <div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div>
              </div>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/jsrender/jsrender.js"></script>
  <script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
  <script id="comments_tmpl" type="text/x-jsrender">
   {{for comments}}
   <tr {{if status=="held"}} class="warning"{{else status=="rejected"}} class="danger" {{else status=="approved"}} class="success" {{/if}}  >
               <td class="text-center"><input type="checkbox"></td>
               <td>{{:author}}</td>
               <td>{{:content}}</td>
               <td>《{{:post_title}}》</td>
               <td>{{:created}}</td>
               <td>{{:status}}</td>
               <td class="text-center">
               {{if status=="held"}}
                <a href="post-add.php" class="btn btn-info btn-xs">批准</a>
                 <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                  {{else status=="rejected"}}
                                  <a href="post-add.php" class="btn btn-info btn-xs">批准</a>
                                   <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
                                    <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                {{else}}
                <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                {{/if}}
               </td>
             </tr>
   {{/for}}

  </script>
  <script>
  $(function($){
      $(document)
        .ajaxStart(function () {
            NProgress.start()
        })
        .ajaxStop(function () {
        NProgress.done()
       })

   function loadPageData(page){
     //$('tbody').fadeOut();
     $('.lds-default').fadeIn();
      $.get('api/comments.php',{page:page},function(res){
              $('.pagination').twbsPagination({
                     first:'&laquo;',
                     last:'&raquo;',
                     prev:'&lt;',
                     next:'&gt;',
                      totalPages:res.total_pages,
                      visablePages:5,
                      initiateStartPageClick:false,
                      onPageClick:function(e,page){
                     loadPageData(page);
                      }
                   })
             let html=$('#comments_tmpl').render({comments:res.comments});
              $('.lds-default').fadeOut();
             $('tbody').html(html)//.fadeIn();
         })

   }
   loadPageData(1);
   })
  </script>
  <script>NProgress.done()</script>
</body>
</html>
