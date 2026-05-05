<?php
define('_IN_JOHNCMS', 1);
$headmod = 'mod';
require('../incfiles/core.php');
require('../incfiles/head.php');
$textl = "Mua Item tên Nick";
echo '<div class="mainblok"><div class="phdr"><b>'.$textl.'</b></div>';
$act = $_GET['act'];
switch ($act)
{
default:
if(!$user_id)
{
echo '<div class="rmenu">Chỉ dành cho thành viên</div>';
require('../incfiles/end.php');
exit;
}
else
{
$req = mysql_query("SELECT `luong`, `postforum` FROM `users` WHERE `id` = '".$user_id."'");
$res = mysql_fetch_array($req);
echo '<div class="list1">Số dư tài khoản: <b>'.$res['luong'].' Lượng</b></div>';
echo '<div class="list1">Chức năng chỉ là thử nghiệm, chức năng này không có tác dụng với những thành viên trong ban điều hành Diễn Đàn... nếu có nhu cầu PM riêng cho admin , đang cập nhật thêm hệ thống item...</div>';
echo '</div>';

echo '<div class="mainblok"><div class="phdr"><b>Mua Hình Trước Nick</b></div>';

if ($res['luong'] <3000)
echo '<div class="rmenu">Hệ Thống Bắt Buộc Bạn Phải Có Trên 3000 luong Để Mua Vật Phẩm Này?</div>';
else
{

echo '<div class="menu">
<form action="olaicon.php?act=thanhcong" method="post">
<input type="radio" name="tom_icon" value="0" /> <font color="red"><b>Khôi phục hệ thống</b></font><br/>
<input type="radio" name="tom_icon" value="1" /> <img src="/images/item/1.png" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="2" /> <img src="/images/item/2.png" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="3" /> <img src="/images/item/3.png" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="4" /> <img src="/images/item/4.png" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="5" /> <img src="/images/item/5.png" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="6" /> <img src="/images/item/6.gif" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="7" /> <img src="/images/item/7.jpg" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="8" /> <img src="/images/item/8.jpg" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="9" /> <img src="/images/item/9.gif" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="10" /> <img src="/images/item/10.gif" alt=""/> (3000 Lượng)<br/>
<input type="radio" name="tom_icon" value="11" /> <img src="/images/item/11.jpg" alt=""/> (3000 Lượng)<br/>
<input type="submit" name="submit" value="Xác nhận Mua" /></form></div></div>';

}
}
break;
case 'thanhcong':
if (isset($_POST['submit']))
{

if ($_POST['tom_icon'] == NULL)
echo '<div class="menu">Bạn chưa chọn danh hiệu nào???<br/><a href="/mod/tom_icon.php">Quay lại</a></div>';
if ($_POST['tom_icon'] == '0')
{
echo '<div class="menu"><font color="red"><b>Khôi phục hệ thống Thành Công</b></font></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '0', `luong`= `luong`-0 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '1')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/1.png" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '1', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '2')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/2.png" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '2', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '3')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/3.png" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '3', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '4')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/4.png" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '4', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '5')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/5.png" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '5', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '6')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/6.gif" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '6', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '7')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/7.jpg" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '7', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '8')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/8.jpg" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '8', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '9')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/9.gif" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '9', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '10')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/10.gif" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '10', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}
if ($_POST['tom_icon'] == '11')
{
echo '<div class="menu">Bạn đã mua thành công Item <img src="/images/item/11.jpg" alt=""/></div></div>';
mysql_query("UPDATE `users` SET `tom_icon` = '11', `luong`= `luong`-3000 WHERE `id`='".$user_id."'");
}


}
else echo'<div class="menu">Có lỗi xảy ra<br/><a href="/mod/tom_icon.php">Quay lại</a></div>';

break;
}
require_once('../incfiles/end.php');
?>