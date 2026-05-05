<?php
error_reporting(0);
define('_IN_JOHNCMS', 1);
require_once('../incfiles/core.php');
$textl = 'Hộp Quà May Mắn';
require('../incfiles/head.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');
if (!$user_id) {
echo functions::display_error($lng['access_guest_forbidden']);
require('../incfiles/end.php');
exit;
}else{
$ktip = mysql_result(mysql_query("SELECT COUNT(`ip`) FROM `users` WHERE `ip`='" . core::$ip . "' and `lastdate` >'".(time()-300)."'"), 0);
echo '<div class="mainblok"><div class="phdr"><b>Nhận Quà</b></div><div class="menu">';
$times = date("H");
if($times < 21){
echo '<center>Chưa đến giờ mở quà !<center>';
}elseif($times == 21){
if($datauser['qua'] == 1){
echo '<center>Bạn đã mở quà !<center>';
}elseif($ktip > 1){
@mysql_query("UPDATE users SET `qua` = '1' WHERE `id` = '{$user_id}'");
$time = time();
$bot = ' @'.$login.' lập nick ảo hoặc dùng nick ảo trá hình nên sẻ không đc nhận balans trong tối nay , xin chia buồn ! Đừng tái phạm nữa nhé :-x)';
mysql_query("INSERT INTO `guest` SET `adm` = '0', `time` = '$time', `user_id` = '2', `name` = 'BOT', `text` = '" . mysql_real_escape_string($bot) . "', `ip` = '0000', `browser` = 'IPHONE'");
echo '<center>Bạn không đc mở quà ! Vì trá hình lập nick ảo nhận quà !<center>';
}else{
$rand = rand(1,10);
$thuong = ($rand == 1 ? '100':NULL).($rand == 2 ? '500':NULL).($rand == 3 ? '10000':NULL).($rand == 4 ? '500':NULL).($rand == 5 ? '1000':NULL).($rand == 6 ? '200':NULL).($rand == 7 ? '5':NULL).($rand == 8 ? '50':NULL).($rand == 9 ? '1000':NULL).($rand == 10 ? '5000':NULL);
@mysql_query("UPDATE users SET `balans` = `balans`+'{$thuong}', `qua` = '1' WHERE `id` = '{$user_id}'");
$time = time();
$bot = ' @'.$login.' Vừa mở hộp quà được thưởng [b]'.$thuong.' Xu[/b] xin chúc mừng :O';
mysql_query("INSERT INTO `guest` SET
`adm` = '0',
`time` = '$time',
`user_id` = '2',
`name` = 'BOT',
`text` = '" . mysql_real_escape_string($bot) . "',
`ip` = '0000',
`browser` = 'IPHONE'
");
echo '<center>Bạn đã mở quà !<br>Chúc mừng bạn đc thương '.$thuong.' Xu!<center>';
} }else{
echo '<center>Đã hết giờ mở quà !<center>';
}
echo '</div></div>';
}
$n = 'Dead';
$nl = 'dead';
///@mysql_query("UPDATE users SET `luong` = `luong`+'140', `mathuong` = `14025' WHERE `id` = '903'");
require('../incfiles/end.php');
?>
