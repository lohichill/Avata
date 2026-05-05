<?php
define('_IN_JOHNCMS', 1);
require_once('../incfiles/core.php');
$textl = 'Đổi quà bằng mã gift';
require_once('../incfiles/head.php');
if (!$user_id) {
echo functions::display_error($lng['access_guest_forbidden']);
require('../incfiles/end.php');
exit;
}
echo '<div class="mainblok">';
switch($act) {
default:
echo '<div class="phdr"><b>Nhận quà từ mã gift</b></div>';
$ma = functions::checkout($_POST['ma']);
$req = mysql_query("SELECT * FROM `magift` WHERE `ma`='".$ma."'");
$dem = mysql_num_rows($req);
$res = mysql_fetch_array($req);
echo '<div class="list1">';

if(isset($_POST['submit'])) {
if(empty($ma)) {
echo '<center><font color="red"><b>Bạn chưa nhập mã vào ô!</b></font></center>';
} else if($dem == 0) {
echo '<center><font color="red"><b>Mã gift không tồn tại hoặc đã được sử dụng!</b></font></center>';
} else {
if($res['balans'] != 0) {
mysql_query("UPDATE `users` SET `balans`=`balans` + '".$res['balans']."' WHERE `id`='".$user_id."'");
}
if($res['luong'] != 0) {
mysql_query("UPDATE `users` SET `luong`=`luong`+'".$res['luong']."' WHERE `id`='".$user_id."'");
}
echo '<div class="rmenu"><b>Nhận thưởng thành công công!</b><br>' . 'Với mã gift này bạn sẽ nhận được'.($res['balans'] != 0 ? '<b> '.$res['balans'].' Xu</b>':'').' '.($res['balans'] != 0 && $res['luong'] != 0 ? '<b>và </b>':'').''.($res['luong'] != 0 ? '<b>'.$res['luong'].' luong </b>':'').'cộng vào tài khoản!</div>';

mysql_query("DELETE FROM `magift` WHERE `ma`='".$ma."'");
}
}
echo '<form action="magift.php" method="post">Nhập mã vào ô:<br><input type="text" name="ma" value="'.$_POST['ma'].'" maxlength="8"/><br><input type="submit" name="submit" value="Nhận quà"/></form>';
echo 'Mã gift gồm 8 kí tự, có thể là chữ hoặc số, không phân biệt hoa thường.<br>';
echo '- Mã gift sẽ được share ở trên diễn đàn, quà tặng của event, người chiến thắng trong wap hay chỉ đơn giản là trả lương cho bạn.' . '<br>Mã có đủ mọi giá trị, ít cũng có mà nhiều cũng có. Phần thưởng bạn có thể nhận là luong hoặc Xu. Để có mã gift hãy tích cực tham gia các hoạt động trên diễn đàn nhé!';
echo '</div>';
if($datauser['rights'] == 9) {
echo '<div class="phdr"><b>Quản lí</b></div><div class="gmenu"><a href="magift.php?act=add">Thêm mã gift</a><br><a href="magift.php?act=panel">Quản lí mã gift</a></div>';
}
break;
case 'add':
echo '<div class="phdr"><b>Thêm mã gift</b></div>';
if($datauser['rights'] < 9) {
echo '<div class="rmenu"><center>Bạn không đủ thẩm quyền!</center></div>';
require('../incfiles/end.php');
exit;
}
//random ma gift
function rand_string($length) {
$chars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$size = strlen($char);
for($i = 0; $i<$length; $i++) {
$str .= $chars[rand(0, $size -1)];
$str=substr(str_shuffle($chars), 0, $length);
}
return$str;
}
$random = rand_string(8);
////
$ktm = mysql_result(mysql_query("SELECT COUNT(`ma`) FROM `magift` WHERE `ma`='".$random."'"), 0);
echo '<div class="list1">';
$balans = (int)$_POST['balans'];
$luong = (int)$_POST['luong'];
if(isset($_POST['submit'])) {
if(empty($balans) && empty($luong)) {
echo '<center><font color="red"><b>Bạn đã để trống cả 2 ô!</b></font></center>';
} else if($ktm != 0) {
echo '<div class="rmenu"><b>Dường như mã gift đã tồn tại vì hệ thống đã random trùng. Tỉ lệ này rất hiếm. Vui lòng làm lại!</b></div>';
} else {
mysql_query("INSERT INTO `magift` SET `user`='".$user_id."', `ma`='".$random."',
`time`='".time()."', `balans`='".$balans."', `luong`='".$luong."'");
echo '<div class="rmenu"><b>Tạo mã gift thành công!</b><br>Mã:<b> '.$random.'</b><br>Bạn có thể quản lí<a href="magift.php?act=panel"> ở đây</a>!</div>';
}
}
echo '<form action="magift.php?act=add" method="post">Giá trị phần quà (Xu):<br><input type="text" name="balans" value="'.$_POST['balans'].'"/><br>Giá trị phần quà (Lượng):<br><input type="text" name="luong" value="'.$_POST['luong'].'"/><br><input type="submit" name="submit" value="Lưu"/></form>';
echo '<font color="red">Lưu ý:</font>Giá trị phần quà có thể là Xu hoặc Lượng hay cả 2. Đối với phần quà có giá trị là Lượng hoặc Xu thì ô còn lại hãy điền số 0 hoặc để trống.<br>-Mã gift sẽ được hệ thống random 8 kí tự ngẫu nhiên với giá trị mà bạn đã đặt và bạn hãy copy để sử dụng hay quản lí tại phần quản lí. Việc cuối cùng là sử dụng đúng mục đích!';
echo '</div>';
break;
case'panel':
echo '<div class="phdr"><b>Quản lí</b></div>';
if($datauser['rights'] < 9) {
echo '<div class="rmenu"><center>Bạn không đủ thẩm quyền!</center></div>';
require('../incfiles/end.php');
exit;
}
$tong = mysql_result(mysql_query("SELECT COUNT(*) FROM `magift`"), 0);
if($tong) {
$req = mysql_query("SELECT * FROM `magift` ORDER BY `time` ASC
LIMIT $start, $kmess");
$i = 1;
while ($res = mysql_fetch_array($req)) {
$name = mysql_fetch_array(mysql_query("SELECT `name` FROM `users` WHERE `id`='".$res['user']."'"));

echo '<div class="gmenu"><b>#'.$i.'</b> - <a href="/users/profile.php?user='.$res['user'].'"><b>'.$name['name'].'</b></a> ('.functions::display_date($res['time']).')</div>';
echo '<div class="list1">';

echo '<b>Mã: '.$res['ma'].'</b><br>+ Giá trị Xu: '.$res['balans'].'<br>+ Giá trị luong: '.$res['luong'].'';
echo '<br><a href="magift.php?act=edit&id='.$res['id'].'"><font color="red">[Sửa]</font></a> | <a href="magift.php?act=del&id='.$res['id'].'"><font color="red">[Xoá]</font></a>';
echo '</div>';
++$i;
}
if ($tong > $kmess){
echo '<div class="topmenu">' . functions::display_pagination('magift.php?act=panel&', $start, $tong, $kmess) . '</div>';
}
} else {
echo '<div class="rmenu" align="center"><b>Không có dữ liệu!</b></div>';
}
echo '<div class="phdr">Tổng: '.$tong.'</div>';
break;
case'edit':
echo '<div class="phdr"><b>Chỉnh sửa mã gift</b></div>';
if($datauser['rights'] < 9) {
echo '<div class="rmenu"><center>Bạn không đủ thẩm quyền!</center></div>';
require('../incfiles/end.php');
exit;
}
$id = (int)$_GET['id'];
$kt = mysql_num_rows(mysql_query("SELECT `id` FROM `magift` WHERE `id`='".$id."'"));
if($kt==0) {
echo '<div class="rmenu">Dữ liệu mã gift không tồn tại!</div>';
require('../incfiles/end.php');
exit;
}
$bv = mysql_fetch_array(mysql_query("SELECT * FROM `magift` WHERE `id`='".$id."'"));
echo '<div class="list1">';
if(isset($_POST['submit'])) {
$balans = (int)$_POST['balans'];
$luong = (int)$_POST['luong'];
if(empty($balans) && empty($luong)) {
echo '<div class="rmenu">Bạn chưa nhập giá trị!</div>';
} else {
mysql_query("UPDATE `magift` SET `balans`='".$balans."', `luong`='".$luong."' WHERE `id`='".$id."'");
echo '<div class="rmenu">Bạn đã chỉnh sửa thành công!</div>';
}
} else {
echo '<form action="magift.php?act=edit&id='.$id.'" method="post">Giá trị Xu:<br><input name="xu" type="text" value="'.$bv['xu'].'"/><br>Giá trị Xu:<br><input name="pit" type="text" value="'.$bv['pit'].'"/><br><input type="submit" name="submit" value="Lưu"/></form>';
}
echo '</div>';
break;
case'del':
echo '<div class="phdr"><b>Xoá mã gift</b></div>';
if($datauser['rights'] < 9) {
echo '<div class="rmenu"><center>Bạn không đủ thẩm quyền!</center></div>';
require('../incfiles/end.php');
exit;
}

$id = (int)$_GET['id'];
$kt = mysql_num_rows(mysql_query("SELECT `id` FROM `magift` WHERE `id`='".$id."'"));
if($kt==0) {
echo '<div class="rmenu">Dữ liệu mã gift không tồn tại!</div>';
require('../incfiles/end.php');
exit;
}

echo '<div class="list1">';

if(isset($_POST['submit'])) {
mysql_query("DELETE FROM `magift` WHERE `id`='".$id."'");
echo '<div class="rmenu">Bạn đã xoá mã gift thành công!</div>';
} else {
echo 'Bạn có thực sự muốn xoá?<br><form action="magift.php?act=del&id='.$id.'" method="post"><input type="submit" name="submit" value="Xoá"/> - <a href="magift.php?act=panel">Hủy bỏ</a></form>';
}
echo '</div>';
break;
}

echo '</div>';
require('../incfiles/end.php');
?>
