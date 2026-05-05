<?php
error_reporting(0);
define('_IN_JOHNCMS', 1);
require_once('../incfiles/core.php');
$textl = 'Hồi Phục SM - Nữ Y Tá';
require('../incfiles/head.php');
date_default_timezone_set('Asia/Ho_Chi_Minh');
if (!$user_id) {
echo functions::display_error($lng['access_guest_forbidden']);
require('../incfiles/end.php');
exit;
}else{
echo '<div class="phdr">Hồi Phục SM</div>';
echo '<div class="list1"> Hồi SM Cấp Tốc 10K / Phát Nện Nữ Y Tá <br>';
?>
<a href="nuyta.php?chich=renla"><input type="submit" name="submit" value="Bơm Sức Mạnh" onclick='this.style.visibility = "hidden";'/></a></div>
<?php
if($_GET[chich] == 'renla')
{
if($datauser['balans'] >= 10000)
{
if($datauser['sucmanh'] >= $datauser['luutrusm'])
{
echo '<div class="list1"> Sức Mạnh Còn Nguyên Mà </div>';
require('../incfiles/end.php');
exit;

}
mysql_query("UPDATE `users` SET `sucmanh` = '".$datauser['luutrusm']."' WHERE `id` = '".$user_id."'");
mysql_query("UPDATE `users` SET `balans` = `balans` - '10000' WHERE `id` = '".$user_id."'");
echo '<div class="list1"> Nện Thành Công Sức Mạnh Đã Hồi Phục </div>';
}
else
{
echo '<div class="list1"> Hết Tiền Mà Đòi Hít LOL Thơm. </div>';

}
}
}
require('../incfiles/end.php');
?>
