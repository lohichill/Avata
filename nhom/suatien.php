<?php
define('_IN_JOHNCMS', 1);
require('../incfiles/core.php');
$textl= 'Chỉnh sửa tiền nhóm';
require('../incfiles/head.php');
include_once('func.php');
$id= intval(abs($_GET['id']));
$dem = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom` WHERE `id`='$id'"),0);
if(!isset($id) || $dem == 0) {
echo '<br/><div class="menu">Nhóm không tồn tại hoặc đã bị xoá!</div>';
require('../incfiles/end.php');
include($_SERVER['DOCUMENT_ROOT'].'logfile.php');
exit;
}
$nhom = nhom($id);
if($datauser['rights']!=10){
echo '<br/><div class="menu">Bạn không đủ quyền!</div>';
require('../incfiles/end.php');
include($_SERVER['DOCUMENT_ROOT'].'logfile.php');
exit;
}else
echo '<div class="mainblok"><div class="phdr"><b>Chỉnh sửa nhóm</b></div>';
$balans = $_POST['balans'];
$luong = $_POST['luong'];
$dem = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom` WHERE `name`='$ten'"),0);

$kt = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom_user` WHERE `id`='".$id."'AND `user_id`='".$user_id."' AND `duyet`='1'") ,0);
if(isset($_POST['sub'])) {
if(empty($balans)) {
echo '<div class="menu">Bạn phải nhập balans nhóm!</div>';
} else if(strlen($balans) > 50) {
echo '<div class="tb">Xu nhóm quá dài!</div>';
} else if($dem==1 && $nhom['balans']!=$balans) {
echo '<div class="menu">Xu nhóm quá dài!</div>';
} else if(empty($luong)) {
echo '<div class="tb">Bạn phải nhập lượng của nhóm!</div>';
} else {
mysql_query("UPDATE `nhom` SET `balans`='$balans', `luong`='$luong' WHERE `id`='$id'");
echo '<div class="menu">Sửa thành công! <a href="page.php?id='.$id.'">Về nhóm >></a></div>';
}
}
echo'<div class="lucifer">';
echo '<form method="post"><div class="menu">balans nhóm: <br/><input type="text" balans="balans" value="'.$nhom['balans'].'" /></div><div class="menu">Lượng nhóm: <br/><input type="text" luong="luong" value="'.$nhom['luong'].'" /></div><div class="menu"><input type="submit" balans="sub" value="Chỉnh sửa" /></div></form></div>';
echo '</div>';
echo'<div class="phdr">Lucifer Đẹp Zai - SieuZui.Net :3</div>';
require('../incfiles/end.php');
?>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/logfile.php');
////// Vipgun98s2 - writed
?>