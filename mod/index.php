<?php
define('_IN_JOHNCMS', 1);
$headmod = 'mod';
$bhead = 2;
require('../incfiles/core.php');
if(!$user_id){
require('../incfiles/head.php');
echo functions::display_error($lng['access_guest_forbidden']);
require('../incfiles/end.php');
exit;
}
$textl = 'Khu giải trí';
require('../incfiles/head.php');
echo '<div class="homeforum"><div class="icon-home"><div class="home">Khu Giải Trí</div></div></div>';
echo'<div class="phdr">Sự Kiện Hàng Ngày</div>';
include 'nhanqua.php';
echo'<div class="phdr">Danh mục Tiện ích</div>';

echo'<div class="omenu"><a href="/chotroi"><b><font color="003366">Khu Chợ Trời</font></b></a><br/>';
echo'Bạn Có Đồ Trong kho Có Giá trị? Muốn Bán lại cho người khác kiếm thu nhập? Rao bán đồ ngay nào!</div>';

echo'<div class="omenu"><a href="/users/profile.php?act=password"><b><font color="003366">Đổi Mật Khẩu</font></b></a><br/>';
echo'Bạn Cảm Thấy Tài Khoản bảo mật chưa cao? Kẻ xấu có thể lợi dụng dò mật khẩu . Đổi mật khẩu ngay.!</div>';

echo'<div class="omenu"><a href="/mod/kethon.php"><b><font color="003366">Khu Đám Cưới</font></b></a><br/>';
echo'Phí dịch vụ 15.000 Xu cho một lần gửi.Chi phí tổ chức đám cưới là 300.000 nếu nửa kia đồng ý.!</div>';

echo'<div class="omenu"><a href="/shop/nangcap/"><b><font color="003366">Khu Nâng Cấp</font></b></a><br/>';
echo'Bạn có những món đồ tầm thường muốn nâng cấp cho nó được đặc sắc và đẹp đẽ hơn hãy vào đây nhé !!</div>';

echo'<div class="omenu"><a href="/giaitri/quayso/"><b><font color="003366">Quay số </font></b></a><br/>';
echo'Nơi bạn có thể sở hữu những vật phẩm có 1 không 2 và không có trong shop</div>';

echo'<div class="phdr">Giải Trí</div>';

echo'<div class="omenu"><a href="/mod/magift.php"><b><font color="003366">Nhận quà GiftCode</font></b></a><br/>';
echo'GiftCode Được Phát Tại Diễn Đàn , Sự Kiện Do Ban Quản Trị Trao Thưởng cho Bạn Tham Gia.!</div>';

echo'<div class="omenu"><a href="/mod/xephang.php"><b><font color="003366">Bảng Xếp Hạng</font></b></a><br/>';
echo'Thống Kê Thể loại TOP Cao thủ , TOP Đại Gia , TOP Cống Hiện Của các bạn dành cho Mạng Xã Hội!</div>';






require('../incfiles/end.php');
?>