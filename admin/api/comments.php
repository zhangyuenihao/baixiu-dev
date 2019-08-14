<?php
require_once '../../functions.php';
//获取页码
$size=20;
$comments_count=bx_fetch_one('select count(1) as count
from comments
inner join posts on comments.post_id=posts.id
')['count'];
$total_pages=ceil($comments_count/$size);
$page=empty($_GET['page'])?1:(int)($_GET['page']);
$page=$page<0?1:$page;
$page=$page>$total_pages?$total_pages:$page;
$offset=($page-1)*$size;
$comments=bx_fetch_all("select
 comments.*,posts.title as post_title
 from comments
 inner join posts on comments.post_id=posts.id
 order by comments.created desc
 limit {$offset} ,{$size}
 ");


//因为网络直接传输的只能是字符串
//我们先将数据转为字符串('系列化')
$json=json_encode(array(
   "comments"=>$comments,
   "total_pages"=>$total_pages
));
header('Content-Type:application/json');
echo $json;
