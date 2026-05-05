<?php

define('_IN_JOHNCMS', 1);
require('../incfiles/core.php');
$textl = 'Bảng Xếp Hạng Nhóm';
require('../incfiles/head.php');
include_once('func.php');
echo '<div class="box_forums">';


echo '<div class="phdr"><b>Bảng Xếp Hạng Nhóm Đóng Góp Xu</b></div>';

$dem = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom`"),0);
if($dem) {
$req = mysql_query("SELECT * FROM `nhom` ORDER BY `xu` DESC LIMIT 5");
$i = 1;
while($res=mysql_fetch_array($req)) {
$nhom = nhom($res['id']);
$xx=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`='".$nhom[user_id]."'"));
$chunhom = user_nick($nhom['user_id']);
echo'<table cellpadding="0" cellspacing="0" width="99%" border="0" style="table-layout:fixed;word-wrap: break-word;">
<tbody><tr><td style="vertical-align: bottom;"><table cellpadding="0" cellspacing="0"><tbody>
<tr><td class="current-blog" rowspan="2" style=""><a href="/member/'.$nhom[user_id].'.html"><a href="page.php?id='.$nhom[id].'"><b><font color="2c5170"><img src="/images/clan/'.$nhom[icon].'.png" alt="icon nhóm"> - Tên Nhóm: '.$nhom[name].'</font></b></a><br/>Xếp Hạng: '.$i.'<br>Số Xu Của Nhóm: '.$nhom[xu].' Xu<br><td></tr></tbody></table></td></tr></tbody></table>';
++$i;
}
}
echo '</div>';
echo '<div class="phdr"><b>Bảng Xếp Hạng Nhóm Đóng Góp Lượng</b></div>';

$dem = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom`"),0);
if($dem) {
$req = mysql_query("SELECT * FROM `nhom` ORDER BY `luong` DESC LIMIT 5");
$i = 1;
while($res=mysql_fetch_array($req)) {
$nhom = nhom($res['id']);
$xx=mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id`='".$nhom[user_id]."'"));
$chunhom = user_nick($nhom['user_id']);
echo'<table cellpadding="0" cellspacing="0" width="99%" border="0" style="table-layout:fixed;word-wrap: break-word;">
<tbody><tr><td style="vertical-align: bottom;"><table cellpadding="0" cellspacing="0"><tbody>
<tr><td class="current-blog" rowspan="2" style=""><a href="/member/'.$nhom[user_id].'.html"><a href="page.php?id='.$nhom[id].'"><b><font color="2c5170"><img src="/images/clan/'.$nhom[icon].'.png" alt="icon nhóm"> - Tên Nhóm: '.$nhom[name].'</font></b></a><br/>Xếp Hạng: '.$i.'<br>Số Lượng Của Nhóm: '.$nhom[luong].' Lượng<br><td></tr></tbody></table></td></tr></tbody></table>';
++$i;
}
}

require('../incfiles/end.php');
?>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/logfile.php');
////// Vipgun98s2 - writed
?>