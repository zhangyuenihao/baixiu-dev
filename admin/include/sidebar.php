<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>侧边栏</title>
</head>
<body>
<div class="aside">
    <div class="profile">
        <img class="avatar" src="/baixiu-dev/static/uploads/avatar.jpg">
        <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
        <li class="active">
            <a href="../index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
        </li>
        <li>
            <a href="#menu-posts" class="collapsed" data-toggle="collapse">
                <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
            </a>
            <ul id="menu-posts" class="collapse">
                <li><a href="/baixiu-dev/admin/posts.php">所有文章</a></li>
                <li><a href="/baixiu-dev/admin/post-add.php">写文章</a></li>
                <li><a href="/baixiu-dev/admin/categories.php">分类目录</a></li>
            </ul>
        </li>
        <li>
            <a href="/baixiu-dev/admin/comments.php"><i class="fa fa-comments"></i>评论</a>
        </li>
        <li>
            <a href="/baixiu-dev/admin/users.php"><i class="fa fa-users"></i>用户</a>
        </li>
        <li>
            <a href="#menu-settings" class="collapsed" data-toggle="collapse">
                <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
            </a>
            <ul id="menu-settings" class="collapse">
                <li><a href="/baixiu-dev/admin/nav-menus.php">导航菜单</a></li>
                <li><a href="/baixiu-dev/admin/slides.php">图片轮播</a></li>
                <li><a href="/baixiu-dev/admin/settings.php">网站设置</a></li>
            </ul>
        </li>
    </ul>
</div>
</body>
</html>