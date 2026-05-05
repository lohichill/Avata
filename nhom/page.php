<?php
define('_IN_JOHNCMS', 1);
require('../incfiles/core.php');
$id= intval(abs($_GET['id']));
$nhom = mysql_fetch_array(mysql_query("SELECT * FROM `nhom` WHERE `id`='".$id."'"));
$textl= $nhom['name'];
require('../incfiles/head.php');
include_once('func.php');
echo '<div class="menunhom">';
$dem = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom` WHERE `id`='$id'"),0);
if(!isset($id) || $dem == 0) {
echo '<br/><div class="omenu">Nhóm không tồn tại hoặc đã bị xoá!</div></div>';
require('../incfiles/end.php');
include($_SERVER['DOCUMENT_ROOT'].'logfile.php');
exit;
}
echo '<div class="phdr">Tranh Chính Của Nhóm</div>';
echo head_nhom($id,$user_id);

$thanhvien = mysql_result( mysql_query("SELECT COUNT(*) FROM `nhom_user` WHERE `user_id`='$user_id'"),0);
if(isset($_GET['thamgia'])) {
if($thanhvien == 0) {
mysql_query("INSERT INTO `nhom_user` SET `user_id`='$user_id', `id`='$id', `time`='$time', `rights`='0', `duyet`='0'");
header('Location: page.php?id='.$id.'');
}else{
	echo functions::display_error('Bạn đã vào 1 nhóm trước đó rồi');
	echo'</div>';
	require('../incfiles/end.php');
	include($_SERVER['DOCUMENT_ROOT'].'logfile.php');
exit;
}
}
if(isset($_GET['rutkhoi'])) {
if($thanhvien >= 1 && $nhom['user_id']!=$user_id) {
mysql_query("DELETE FROM `nhom_user` WHERE `user_id`='$user_id' AND `id`='$id'");
header('Location: page.php?id='.$id.'');
}
}
echo'<div class="omenu" style="font-size: 11px;font-weight: bold;">
<table style="width:100%" border="0" cellspacing="0">
  <tr>
    <td style="text-align:center"><a style="color: #7a9127;" href="more.php?act=mem&id='.$id.'"><img src="/icon/hot/thanhvienclan.png" width="36" height="36" alt="icon" width="34px"/><br/>Thành viên</a></td> 
    <td style="text-align: center;"><a style="color: #7a9127;" href="album.php?id='.$id.'"><img src="/icon/hot/album.png" alt="icon" width="36" height="36"/><br/>Album ảnh</a></td>
      </tr></table></div>';
//duyet don
$duyet =mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom_user` WHERE `id`='$id' AND `duyet`='0'"),0);
if($nhom['user_id'] == $user_id) {
echo '<div class="omenu"><a href="duyet.php?id='.$id.'"><b>Đơn xin gia nhập ('.$duyet.')</b></a></div>';
}
//Ô đăng bài
$ktviet = mysql_result( mysql_query("SELECT COUNT(*) FROM `nhom_user` WHERE `user_id`='$user_id' AND `id`='$id' AND `duyet`='1'"),0);
if($ktviet != 0) {
echo '<div class="phdr">Kênh Chát</div><div class="omenu">';
$text = functions::checkin($_POST['text']);
if(isset($_POST['submit'])) {
if(empty($text)) {
echo '<div class="omenu">Chưa nhập nội dung!</div>';
} else if(strlen($text) > 5000) {
echo '<div class="omenu">Nội dung quá dài. Chỉ tối đa 5000 kí tự!</div>';
} else {
@mysql_query("INSERT INTO `nhom_bd` SET `sid`='".$id."', `user_id`='".$user_id."', `time`='".$time."', `stime`='".$time."',  `text`='".mysql_real_escape_string($text)."', `type`='0'");
echo '<div class="omenu">Đăng bài thành công!</div>';
}
}
echo '<form method="post"><textarea name="text" cows="3"></textarea><br/ ><input type="submit" name="submit" value="Đăng" class="nut"/><div style="float:right; padding-top:4px;"><img src="noavatar.png" width="15" height="15"/> <a href="img.php?id='.$id.'"><b><font color="003366">Chia sẻ ảnh</font></b></a></div></form></div><div class="omenu"></div>';
}
//Bài đăng khác
if($nhom['set'] == 0 || $ktviet != 0 && $nhom['set'] == 1 || $ktviet != 0 &&$nhom['set'] == 2) {
$dem = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom_bd` WHERE `sid`='$id' AND `type`!='1'"),0);
if($dem) {
$req = mysql_query("SELECT * FROM `nhom_bd` WHERE `sid`='$id' AND `type`!='1' ORDER BY `stime` DESC LIMIT $start,$kmess");
while($res=mysql_fetch_array($req)) {
echo '<div class="omenu">';
echo'<img class="avatar_aev" src="/avatar/'.$res['user_id'].'.png" alt="" />';
if($res['type']==2) {
echo '<div class="nhom_img" align="center"><a href="cmt.php?id='.$res['id'].'"><img src="files/anh_'.$res['time'].'.jpg" alt="image" /></a></div>';
}
echo ''.functions::smileys($res['text']) . '';
//Phan menu bai dang
$like = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom_like` WHERE `id`='".$res['id']."' AND `type`!='1'"),0);
$klike = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom_like` WHERE `id`='".$res['id']."' AND `user_id`='".$user_id."' AND `type`!='1'"),0);
$bl = mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom_bd` WHERE `cid`='".$res['id']."' AND `type`='1'"),0);
$xoa = mysql_fetch_array(mysql_query("SELECT `rights` FROM `nhom_user` WHERE `id`='".$id."' AND `user_id`='".$res['user_id']."'"));
$xoa2 = mysql_fetch_array(mysql_query("SELECT * FROM `nhom_user` WHERE `id`='".$id."' AND `user_id`='".$user_id."'"));
echo '<br>'.($like > 0 ? '<a href="more.php?act=like&id='.$res['id'].'"><img src="l.png" alt="l" /> '.$like.'</a> · ':'').''.($klike == 0 ? '<a href="action.php?act=like&id='.$res['id'].'">Thích</a>':'<a href="action.php?act=dislike&id='.$res['id'].'">Bỏ thích</a>').' · <a href="cmt.php?id='.$res['id'].'">Bình luận ('.$bl.')</a>'.($xoa2['rights'] > $xoa['rights'] || $res['user_id'] == $user_id || $rights == 9 ? ' · <a href="action.php?act=del&id='.$res['id'].'">Xoá</a>':'').'';
echo '</div>';
}
} else {
echo '<div class="omenu" align="center">Chưa có bài đăng!</div>';
}
if ($dem > $kmess){
echo '<div class="omenu" align="center">' . functions::display_pagination('page.php?id='.$id.'&page=', $start, $dem, $kmess) . '</div>';
}
//Trinh don nhom
$tv =mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom_user` WHERE `id`='".$id."' AND `duyet`='1'") ,0);
$anh =mysql_result(mysql_query("SELECT COUNT(*) FROM `nhom_bd` WHERE `sid`='$id' AND `type`='2'"),0);

$dv = mysql_fetch_array(mysql_query("SELECT * FROM `nhom` WHERE `id`='$id'"));
//echo '<div class="omenu"><a href="/nhom/shop.php"><b>Shop Vật Phẩm Nhóm</b></div></a>';
echo '<div class="phdr">Quản lí nhóm</div><div class="omenu"><a href="thongtin.php?id='.$id.'"><b>Thông tin</b></a></div>'.($nhom['user_id'] == $user_id ? '<div class="omenu"><a href="edit.php?id='.$id.'"><b>Chỉnh sửa nhóm</b></a></div>':'').'';
echo '<div class="omenu"><font color="2c5170"><b>Quỹ xu : '.$dv['xu'].'</font></b></div>';
echo '<div class="omenu"><font color="2c5170"><b>Quỹ lượng : '.$dv['luong'].'</font></b></div>';
echo '<div class="omenu"><b><font color="2c5170">Cấp độ : '.$dv['lv'].'</font></b></div>';
//echo '<div class="omenu"><font color="red"><b><a href="/nhom/kho.php">Kho Vật Phẩm Nhóm</a></font></b></div>';
}
if ($datauser['rights'] >= 10) { 
echo'<div class="omenu"><a href="action.php?act=xoanhom&id='.$id.'" style="color:red;"><b>Xóa nhóm</b></a></div>';
echo'<div class="omenu"><a href="suatien.php?id='.$id.'" style="color:red;"><b>Sửa Tiền Nhóm <3 </b></a></div>';
}
echo'</div>';
echo'</td></tr></tbody></table></td></tr></tbody></table>';
require('../incfiles/end.php');
?>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/logfile.php');
////// Vipgun98s2 - writed
?>