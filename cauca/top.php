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

echo '<div class="phdr"><b>Bảng Xếp Hạng Câu Cá</b></div><div class="gmenu">';

$req = mysql_query("SELECT `user_id`, `name`, `lvl`, `vsego` FROM `fish` WHERE `vsego` > '0' ORDER BY `vsego` DESC LIMIT 10");
$count = mysql_num_rows($req);
if($count > 0){
while($res = mysql_fetch_array($req)){
    echo $i % 2 ? '<div class="list2">' : '<div class="list1">';
    echo '<table><tr><td><img src="/avatar/'.$res['user_id'].'.png"> </td><td><b>'.$res['name'].'</b><br/>Mức độ: <b>'.$res['lvl'].'</b>
	<br/>Đã đánh bắt: <b>'.$res['vsego'].' KG Cá</b>
	';
	
    echo '<div class="sub"><a href="/cauca/chitiet/'.$res['user_id'].'">Xem chi tiết ...</a></td></tr></table></div>';
    ++$i;
}
}else{
    echo '<div class="list1">Hiện chưa ai có thể đứng top ở bảng xếp hạng này cả ! <img src="/images/smileys/user/Yahoo/4.gif" alt="Cười nhăn răng"></div>';
}

echo '</div><div class="list3"><a href="/cauca/">Ra khỏi Bảng Xếp Hạng</a></div>';

require_once ("../incfiles/end.php");

?>