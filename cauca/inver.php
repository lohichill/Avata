<?php
//Việt Hóa : JohnCMSVN.COM
//--JohnCMSVN.COm - JohNCMS Việt Nam ---

define('_IN_JOHNCMS', 1);

$textl = 'Câu Cá :D';
$headmod = "fish";
require_once ('../incfiles/core.php');
require_once ('../incfiles/head.php');

if (!$user_id) {
    echo display_error('Dành cho thành viên nhá !');
    require_once ('../incfiles/end.php');
    exit;
}

$prov = mysql_num_rows(mysql_query("SELECT `id` FROM `fish` WHERE `user_id` = '".$user_id."' LIMIT 1"));
if($prov < 1){
    header('Location: index.php');
    exit;
}

mysql_query("UPDATE `fish` SET `time` = '0', `rand_time` = '0', `status` = '0' WHERE `user_id` = '".$user_id."' LIMIT 1");

$res = mysql_fetch_array(mysql_query("SELECT * FROM `fish_in` WHERE `user_id` = '".$user_id."' LIMIT 1"));
$res1 = mysql_fetch_array(mysql_query("SELECT * FROM `fish_r` WHERE `id` = '".$res["ud"]."' LIMIT 1"));
echo '<div class="phdr"><b>Mồi còn dư lại</b></div>';
echo '<div class="gmenu">Mồi còn dư lại của bạn</div>';

echo '<div class="list1">
<table width="100%"><tbody><tr><td width="5%">
<img src="/cauca/img/moi'.$res['na'].'.png"/>
</td><td width="90%">';
if($res['na'] == 1){
	echo '<b>Mồi cơm</b><br/>
	Dùng để câu: <b>Cá Rô</b><br/>
	';
} 
if($res['na'] == 2){
	echo '<b>Mồi trùng</b><br/>
	Dùng để câu: <b>Lòng thong</b><br/>';
}
if($res['na'] == 3){
	echo '<b>Trứng kiến</b>
	Dùng để câu: <b>Cá mập</b><br/>';
}
echo '
Số lượng còn: '.$res['na_d'].'.<br/>
</td></tr></table></div>';

echo '<div class="gmenu"><a href="index.php">Về Game</a></div>';

require_once ("../incfiles/end.php");

?>