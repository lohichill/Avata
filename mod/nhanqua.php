<?php
error_reporting(0);
date_default_timezone_set('Asia/Ho_Chi_Minh');
$times = date("H");
if($times == 19 || $times == 20 || $times == 21){
echo '<div class="omenu"><center><b><font color="0000ff">Sự Kiện Mở Hộp Quà Nhận Quà Liền Tay!</font></b><br>
<img src="/mod/hopqua.jpg"><br>';

if($times == 21){
if($datauser['qua'] == 0){
echo '<b><a href="/mod/hopqua.php">Nhận Quà Ngay</a></b>'; }
}else{
echo 'Sự kiện bắt đầu lúc 21h00<br>Giải thương từ 5 xu đến 10.000 xu';
@mysql_query("UPDATE users SET `qua` = '0' WHERE `id` != '0'");
}
echo '</center></div>';
}

?>
