																																										<?php

/*
 * @package     VinaJohnCMS
 * @link        http://vina4u.pro
 * @copyright   Copyright (C) 2008-2011 VinaJohnCMS Community
 * @author      http://facebook.com/vina4uteam
 */

defined('_IN_JOHNCMS') or die('Error: restricted access');
$trangthai ='tat';
$headmod = isset($headmod) ? mysql_real_escape_string($headmod) : '';
$textl = isset($textl) ? $textl : $set['copyright'];
$textl=html_entity_decode($textl,ENT_QUOTES,'UTF-8'); ////fix lỗi font title

echo'<!DOCTYPE html>' .
    "\n" . '<html lang="vn">' . //' . core::$lng_iso . '//
    "\n" . '<head>' .
    "\n" . '<meta charset="utf-8">' .
    "\n" . '<meta http-equiv="X-UA-Compatible" content="IE=edge">' .
    "\n" . '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes">' .
    "\n" . '<meta name="HandheldFriendly" content="true">' .
    "\n" . '<meta name="MobileOptimized" content="width">' .
    "\n" . '<meta content="yes" name="apple-mobile-web-app-capable">' .
    "\n" . '<meta name="Generator" content="Mã Nguồn Mạng Xã hội Version 1.5">' .
	"\n" . '<meta name="author" content="Hoàng Minh Thuận - '.$phienban.'"/>' .
    (!empty($set['meta_key']) ? "\n" . '<meta name="keywords" content="' . $set['meta_key'] . '">' : '') .
    (!empty($set['meta_desc']) ? "\n" . '<meta name="description" content="' . $set['meta_desc'] . '">' : '') .
    "\n" . '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">' .
    "\n" . '<link rel="stylesheet" href="' . $set['homeurl'] . '/bootstrap/css/bootstrap.min.css">' .
    "\n" . '<link rel="stylesheet" href="' . $set['homeurl'] . '/bootstrap/css/bootstrap-theme.min.css">' .
    "\n" . '<script src="' . $set['homeurl'] . '/bootstrap/3.1.1/js/bootstrap.min.js"></script>' .
	
	
    "\n" . '<link rel="stylesheet" href="' . $set['homeurl'] . '/theme/' . $set_user['skin'] . '/style.css">' .
    "\n" . '<link rel="shortcut icon" href="' . $set['homeurl'] . '/favicon.ico">' .
    "\n" . '<link rel="alternate" type="application/rss+xml" title="RSS | ' . $lng['site_news'] . '" href="' . $set['homeurl'] . '/rss/rss.php">' .
    "\n" . '<title>' . $textl . ' - ZimCity</title>' .
    "\n" . '<script type="text/javascript" src="/guestbook/jquery.js"></script><script type="text/javascript" src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>'.
    "\n" . '</head><body>' . core::display_core_errors();

	
	
	
//--- Mod Chatbox v3 ---//
echo "<script>
$(document).ready(function(){
$(\"#datachat\").load(\"chemgio.php\");
var refreshId = setInterval(function() {
$(\"#datachat\").load('$home/chemgio.php');
$(\"#datachat\").slideDown(\"slow\");
}, 60000);
$(\"#shoutbox\").validate({
debug: false,
submitHandler: function(form) {
$.post('$home/chemgio.php', $(\"#shoutbox\").serialize(),function(chatoutput) {
$(\"#datachat\").html(chatoutput);
});
$(\"#msg\").val(\"\");
}
});
});
</script>";	
	
?>
<script type="text/javascript">
function showLoading(){
document.getElementById('btnSubmit1').style.display='none';
document.getElementById('btnSubmit2').style.display='inline-block';
document.getElementById('loading').style.display='block';
return true;
}
</script>

<?php
$msg = isset($_POST['msg']) ? functions::fixlink($_POST['msg']) : '';
/*
-----------------------------------------------------------------
Bố Cục Mod by VinaJohnCMS
-----------------------------------------------------------------
*/
$cms_ads = array();
if (!isset($_GET['err']) && $act != '404' && $headmod != 'admin') {
    $view = $user_id ? 2 : 1;
    $layout = ($headmod == 'mainpage' && !$act) ? 1 : 2;
    $req = mysql_query("SELECT * FROM `cms_ads` WHERE `to` = '0' AND (`layout` = '$layout' or `layout` = '0') AND (`view` = '$view' or `view` = '0') ORDER BY  `mesto` ASC");
    if (mysql_num_rows($req)) {
        while (($res = mysql_fetch_assoc($req)) !== FALSE) {
            $name = explode("|", $res['name']);
            $name = htmlentities($name[mt_rand(0, (count($name) - 1))], ENT_QUOTES, 'UTF-8');
            if (!empty($res['color'])) $name = '<span style="color:#' . $res['color'] . '">' . $name . '</span>';
            // Если было задано начертание шрифта, то применяем
            $font = $res['bold'] ? 'font-weight: bold;' : FALSE;
            $font .= $res['italic'] ? ' font-style:italic;' : FALSE;
            $font .= $res['underline'] ? ' text-decoration:underline;' : FALSE;
            if ($font) $name = '<span style="' . $font . '">' . $name . '</span>';
            @$cms_ads[$res['type']] .= '<a href="' . ($res['show'] ? functions::checkout($res['link']) : $set['homeurl'] . '/go.php?id=' . $res['id']) . '">' . $name . '</a><br/>';
            if (($res['day'] != 0 && time() >= ($res['time'] + $res['day'] * 3600 * 24)) || ($res['count_link'] != 0 && $res['count'] >= $res['count_link']))
                mysql_query("UPDATE `cms_ads` SET `to` = '1'  WHERE `id` = '" . $res['id'] . "'");
        }
    }
}


/*
-----------------------------------------------------------------
Bố Cục Mod by VinaJohnCMS
-----------------------------------------------------------------
*/
if (isset($cms_ads[0])) echo $cms_ads[0];

/*
-----------------------------------------------------------------
Bố Cục Mod by VinaJohnCMS
-----------------------------------------------------------------
*/

echo'<div class="body_body">';
echo'<div class="left_top"></div><div class="bg_top"><div class="right_top"></div></div>';
echo'<div class="body-content">';
echo'<div class="a" align="center">';
echo'<a href="' . $set['homeurl'] . '"><img src="http://i.imgur.com/DqYUN1E.png" alt="Coder by TOMDZ™" width="250" height="80" style="margin-bottom:5px"></a>';
echo'</div>';
echo'<div class="link-more">';

if ($user_id) {
echo'<table width="100%" border="0" cellspacing="0">
<tr class="menu"><td width="25%">';
echo'<a href="' . $set['homeurl'] . '/mod">Tiện ích</a>';
echo'</td><td width="25%">';
echo'<a href="' . $set['homeurl'] . '/nhom">Hội Nhóm</a>';
echo'</td><td width="25%">';
$thongbao=mysql_result(mysql_query("select count(*) from `thongbao` where `id_to`='{$user_id}' and `type`='f'"),0);
echo'<a href="' . $set['homeurl'] . '/users/thongbao.php">Thông Báo '.($thongbao > 0 ? '<font color="red">'.$thongbao.'</font>' : '').'</a>';
echo'</td><td width="25%">';
echo'<a href="' . $set['homeurl'] . '/users/profile.php">Cá Nhân</a>';
echo'</td></tr></table>';
echo'<div class="body"><div class="mainvina">';
}

if (!$user_id) {
echo'<table width="100%" border="0" cellspacing="0"><tr class="menu"><td width="32%">';
echo'<a href="' . $set['homeurl'] . '/dangnhap.html">Đăng nhập</a>';
echo'</td><td width="32%">';
echo'<a href="' . $set['homeurl'] . '/dangki.html">Đăng kí</a>';
echo'</td><td width="35%">';
echo'<a href="' . $set['homeurl'] . '/forum/">Diễn đàn</a>';
echo'</td></tr></table>';
echo'<div class="body"><div class="mainvina">';
}



/*

if (!$user_id) {
echo '<font style="float:right;padding-top:5px"><a id="submit" href="/"> <i class="fa fa-home"></i> Trang Chủ </a> <a id="submit" href="/login.php"><i class="fa fa-user"></i> Đăng Nhập </a></font> ';
} else { 
echo '<font style="float:right;padding-top:5px"><a id="submit" href="/users/profile.php?act=office"><i class="fa fa-user"></i> Cá Nhân </a> <a id="submit" href="/nhom"><i class="fa fa-group"></i> Hội Nhóm </a></font> ';
}


-----------------------------------------------------------------
Bố Cục Mod by VinaJohnCMS
-----------------------------------------------------------------
*/


//echo '<div class="thongbao"><marquee style="margin-top:5px"><font color="red">Diễn Đàn <b>ZimCity.US</b> hoạt động Thử Nghiệm Phiên Bản TEAMOBI Beta Vào ngày <b>16/06/2016</b>! Cùng Tham Gia Ngay!</font></marquee></div>';




if ($user_id) {

//mysql_query("UPDATE `users` SET `sucmanh` = '5000' WHERE `id` = '".$datauser["id"]."'");




echo '<div class="tmn">';

echo '<img src="/avatar/'.$datauser['id'].'.png" width="40" height="40" alt="'.$datauser['id'].'" class="avatar_head"/>';

echo '<b><font style="font-size:12px">Xin Chào</font> '.nick($datauser['id']).'</b>';
$user_rights = array(
0 => 'Thành Viên',
2 => 'Trial Mod',
3 => 'Mod',
4 => 'Police',
5 => 'Trial Smod',
6 => 'Smod',
7 => 'Admin',
9 => 'Sáng lập'
);
echo ' (<span style="color:#' . $colornick['colornick'] . '">'.$user_rights[$datauser['rights']].'!</span>) ';

echo '  <br/><span style="color:green;font-size: 11px;"><i class="fa fa-money"></i> Xu : '.$datauser['balans'].' - <i class="fa fa-money"></i> Lượng: '.$datauser['luong'].' </span>';

echo '<br/><span style="color:green;font-size: 11px;"> <i class="fa fa-fire"></i> <b>'.$datauser['sucmanh'].'</b> Sức Mạnh - <i class="fa fa-money"></i> <b>'.$datauser['vnd'].'</b> VNĐ - <i class="fa fa-heart"></i> <b>'.$datauser['hp'].'</b> HP</span>';
echo '<br/><span style="color:green;font-size: 11px;"> <i class="fa fa-archive" style="font-size:10px"></i> <a href="/ruong/">Rương Đồ</a> - <i class="fa fa-sign-out" style="font-size:10px"></i> <span style="color:green;font-size: 11px;"> <a href="/exit.php">Đăng Xuất</a></span>';
if ($rights >= 3){
echo ' - <span style="color:red;font-size: 11px;"> <i class="fa fa-cogs" style="font-size:10px"></i> <a href="/panel"><font color="red">Admin Panel</font></a></span>';
}

if (!empty($datauser['status'])){
echo '<br/><i class="fa fa-refresh fa-spin" style="font-size:10px"></i> <span class="status">Status : '.$datauser['status'].' </span>';
}
echo '<br/></div>';



} else {

echo '<div class="gmenu" style="font-size:12px"> ' . $lng['hi'] . ', ' . ($user_id ? '<b>' . $login . '</b>!' : $lng['guest'] . '!') . ' </div>';


}








/*
-----------------------------------------------------------------
Bố Cục Mod by VinaJohnCMS
-----------------------------------------------------------------
*/





if ($user_id) {



$check = mysql_fetch_array(mysql_query("SELECT `user_id`,`user_vs`,`id` FROM `ranking`"));
if(($check['user_id'] == $user_id OR $check['user_vs'] == $user_id) AND $noionline != 'Ranking'){
echo '<div class="bmenu_hero"><b><font color=red>Bạn đang trong một <a href="/ranking/tranxephang.php?id='.$check[id].'">TRẬN XẾP HẠNG</a>!</b></font></div>';
}



//--Hộp Quà -- //
if(time() > $datauser['tgiannhanqua'] + 3600 * 24){
	echo '<div class="list1"><img src="/images/hopqua.png" alt="Nhận quà"/> <a href="/tangqua/"><b>Bạn nhận được quà tặng từ hệ thống</a></b></div>';
}
$timenhanquatess = time() - $datauser['lastdate'];
if($datauser['lastdate'] > (time() - 300)){
mysql_query("UPDATE `users` SET `thoigianon` = `thoigianon`+'$timenhanquatess' WHERE `id` = '$user_id'"); 
}
if($datauser['thoigianon'] >= 3600){
	echo '<div class="list1"><img src="/images/hopqua.png" alt="Nhận quà"/> <a href="/tangqua/nhanon.php"><b>Bạn nhận được quà online hàng giờ</b></a></div>';
}

//Mod cap dat nong trai//
if($datauser['phongthu'] == 1){
	mysql_query("INSERT INTO `fermer_gr` (`semen`, `id_user`) VALUES  ( '0', '".$datauser["id"]."') ");
	mysql_query("INSERT INTO `fermer_gr` (`semen`, `id_user`) VALUES  ( '0', '".$datauser["id"]."') ");
	mysql_query("INSERT INTO `fermer_gr` (`semen`, `id_user`) VALUES  ( '0', '".$datauser["id"]."') ");
	mysql_query("INSERT INTO `fermer_gr` (`semen`, `id_user`) VALUES  ( '0', '".$datauser["id"]."') ");
	mysql_query("INSERT INTO `fermer_gr` (`semen`, `id_user`) VALUES  ( '0', '".$datauser["id"]."') ");
	mysql_query("INSERT INTO `fermer_gr` (`semen`, `id_user`) VALUES  ( '0', '".$datauser["id"]."') ");
	mysql_query("UPDATE `users` SET `phongthu`= 0 WHERE `id`='".$datauser["id"]."'");
}
if($datauser['farm_vatnuoi'] == 0){
	mysql_query("UPDATE `users` SET `farm_vatnuoi`= '3' WHERE `id`='".$datauser["id"]."'");
}
// Mod luu tru suc manh

if($datauser['hp'] <= 0) {
mysql_query("UPDATE `users` SET `hp` = '500' WHERE `id`='{$user_id}'");
echo '<div class="list1"><img src="/images/dongho.png"> Chỉ Số HP của bạn đã được phục hồi 500 HP!</div>';
}
if (time()>$datauser['timenhanhp']+60*15) {
mysql_query("UPDATE `users` SET `hp` = `hp` + '200', `timenhanhp`= '".time()."' WHERE `id`='{$user_id}'");
echo '<div class="list1"><img src="/images/dongho.png"> Bạn Đã Online 15 Phút và Nhận Được 200 HP! Chắm Chỉ Online Sẽ Nhận Được HP nha...</div>';
}


if($datauser[sucmanh] < $datauser[luutrusm]){

	$timehientai = time();
	$tinhtime = $datauser[luutrusmtime]+1600;
	if($timehientai >= $tinhtime){
		mysql_query("UPDATE `users` SET `luutrusmtime` = '".time()."' WHERE `id`='{$user_id}'");
		mysql_query("UPDATE `users` SET `sucmanh` = $datauser[luutrusm] WHERE `id`='{$user_id}'");
		echo '<div class="list1"><img src="/images/dongho.png"> Sức mạnh của bạn đã được phục hồi!</div>';
	}else{
		$timeht = time();
		$tinhtime2 = $tinhtime - $timeht;
		$tinhphut2 = $tinhtime2 / 60;
		$tinhphut = (int)$tinhphut2;
		echo '<div class="list1"><img src="/images/dongho.png"> Sức mạnh của bạn sẽ phục hồi trong vòng '.$tinhphut.' phút nữa!</div>';
	}
}else{
mysql_query("UPDATE `users` SET `sucmanh` = $datauser[luutrusm] WHERE `id`='{$user_id}'");
}


if($datauser[sucmanh2] < $datauser[luutrusm]){
	$kiemtrachuphong = mysql_result(mysql_query("SELECT COUNT(*) FROM `gamemini_boss_phong` WHERE `chuphong` = '$user_id'"), 0);
	$kiemnguoichoi1 = mysql_result(mysql_query("SELECT COUNT(*) FROM `gamemini_boss_phong` WHERE `nguoichoi1` = '$user_id'"), 0);
	$kiemnguoichoi2 = mysql_result(mysql_query("SELECT COUNT(*) FROM `gamemini_boss_phong` WHERE `nguoichoi2` = '$user_id'"), 0);
	$kiemnguoichoi3 = mysql_result(mysql_query("SELECT COUNT(*) FROM `gamemini_boss_phong` WHERE `nguoichoi3` = '$user_id'"), 0);
	if($kiemtrachuphong == 0 && $kiemnguoichoi1 == 0 && $kiemnguoichoi2 == 0 && $kiemnguoichoi3 == 0){
	$timehientai = time();
	$tinhtime = $datauser[luutrusmtime2]+1600;
	if($timehientai >= $tinhtime){
		mysql_query("UPDATE `users` SET `luutrusmtime2` = '".time()."' WHERE `id`='{$user_id}'");
		mysql_query("UPDATE `users` SET `sucmanh2` = $datauser[luutrusm] WHERE `id`='{$user_id}'");
		echo '<div class="list1"><img src="/images/dongho.png"> Sức mạnh chiến đấu của bạn đã được phục hồi!</div>';
	}else{
		$timeht = time();
		$tinhtime2 = $tinhtime - $timeht;
		$tinhphut2 = $tinhtime2 / 60;
		$tinhphut = (int)$tinhphut2;
		echo '<div class="list1"><img src="/images/dongho.png"> Sức mạnh chiến đấu của bạn sẽ phục hồi trong vòng '.$tinhphut.' phút nữa!</div>';
	}
	}
}else{
mysql_query("UPDATE `users` SET `sucmanh2` = $datauser[luutrusm] WHERE `id`='{$user_id}'");
}









	if ($datauser['password_2'] == NULL) {
	echo '<div class="phdr"> Cập Nhật Pass 2 </div>';
	echo '<div class="tmn">Xin mời các bạn vào thiết lập <a href="/users/password_2.php"><b style="color:red">Mật khẩu cấp 2 trước khi bị khóa do IP bị đổi.</b></a></div>';
	}

	$result_user_shop = mysql_result(mysql_query("SELECT COUNT(*) FROM shop_options WHERE user_id = $user_id"), 0);
	if ($result_user_shop == 0) {
		mysql_query("INSERT INTO shop_options SET user_id = $user_id");
		header("location: /");
	} else {

		$query_shop_option = mysql_fetch_array(mysql_query("SELECT * FROM shop_options WHERE user_id = $user_id"));
		mysql_query("UPDATE shop_options SET rename = 1 WHERE user_id = 1");

		// set in dam ve 0 khi het time
		if ($query_shop_option['bold'] == 1 && ($query_shop_option['time_bold']+259200)<time()) {
			mysql_query("UPDATE shop_options SET bold = 0, time_bold = '0' WHERE user_id = $user_id");
		}

		// set RENAME ve 0 neu het time
		if ($query_shop_option['rename'] == 1 && ($query_shop_option['time_rename']+2592000)<time()) {
			mysql_query("UPDATE shop_options SET rename = 0, time_rename = '0' WHERE user_id = $user_id");
		}

		// set VIP ve 0 neu het time
		if ($query_shop_option['vip'] == 1 && ($query_shop_option['time_vip']+2592000)<time()) {
			mysql_query("UPDATE shop_options SET vip = 0, time_vip = '0' WHERE user_id = $user_id");
		}

			// set DANH HIEU ve 0 neu het time
		if ($query_shop_option['danhhieu'] == 1 && ($query_shop_option['time_danhhieu']+2592000)<time()) {
			mysql_query("UPDATE shop_options SET danhhieu = 0, time_danhhieu = '0' WHERE user_id = $user_id");
		}
	}

}










/*
-----------------------------------------------------------------
Bố Cục Mod by VinaJohnCMS
-----------------------------------------------------------------
*/
if (!empty($cms_ads[1])) echo '<div class="gmenu">' . $cms_ads[1] . '</div>';

/*
-----------------------------------------------------------------
Bố Cục Mod by VinaJohnCMS
-----------------------------------------------------------------
*/
$sql = '';
$set_karma = unserialize($set['karma']);
if ($user_id) {
    // Фиксируем местоположение авторизованных
    if (!$datauser['karma_off'] && $set_karma['on'] && $datauser['karma_time'] <= (time() - 86400)) {
        $sql .= " `karma_time` = '" . time() . "', ";
    }
    $movings = $datauser['movings'];
    if ($datauser['lastdate'] < (time() - 300)) {
        $movings = 0;
        $sql .= " `sestime` = '" . time() . "', ";
    }
    if ($datauser['place'] != $headmod) {
        ++$movings;
        $sql .= " `place` = '" . mysql_real_escape_string($headmod) . "', ";
    }
    if ($datauser['browser'] != $agn)
        $sql .= " `browser` = '" . mysql_real_escape_string($agn) . "', ";
    $totalonsite = $datauser['total_on_site'];
    if ($datauser['lastdate'] > (time() - 300))
        $totalonsite = $totalonsite + time() - $datauser['lastdate'];
    mysql_query("UPDATE `users` SET $sql
        `movings` = '$movings',
        `total_on_site` = '$totalonsite',
        `lastdate` = '" . time() . "'
        WHERE `id` = '$user_id'
    ");
} else {
    // Bố Cục Mod by VinaJohnCMS
    $movings = 0;
    $session = md5(core::$ip . core::$ip_via_proxy . core::$user_agent);
    $req = mysql_query("SELECT * FROM `cms_sessions` WHERE `session_id` = '$session' LIMIT 1");
    if (mysql_num_rows($req)) {
        // Если есть в базе, то обновляем данные
        $res = mysql_fetch_assoc($req);
        $movings = ++$res['movings'];
        if ($res['sestime'] < (time() - 300)) {
            $movings = 1;
            $sql .= " `sestime` = '" . time() . "', ";
        }
        if ($res['place'] != $headmod) {
            $sql .= " `place` = '" . mysql_real_escape_string($headmod) . "', ";
        }
        mysql_query("UPDATE `cms_sessions` SET $sql
            `movings` = '$movings',
            `lastdate` = '" . time() . "'
            WHERE `session_id` = '$session'
        ");
    } else {
        // Если еще небыло в базе, то добавляем запись
        mysql_query("INSERT INTO `cms_sessions` SET
            `session_id` = '" . $session . "',
            `ip` = '" . core::$ip . "',
            `ip_via_proxy` = '" . core::$ip_via_proxy . "',
            `browser` = '" . mysql_real_escape_string($agn) . "',
            `lastdate` = '" . time() . "',
            `sestime` = '" . time() . "',
            `place` = '" . mysql_real_escape_string($headmod) . "'
        ");
    }
}

/*
-----------------------------------------------------------------
Bố Cục Mod by VinaJohnCMS
-----------------------------------------------------------------
*/
if (!empty($ban)) echo '<div class="alarm">' . $lng['ban'] . '&#160;<a href="' . $set['homeurl'] . '/users/profile.php?act=ban">' . $lng['in_detail'] . '</a></div>';

if (!empty($ban)) {
$a = mysql_query("SELECT * FROM `cms_ban_users` WHERE `user_id` =' " . $datauser['id'] . " ' ");
$b = mysql_fetch_assoc($a);
echo'<div class="phdr"><b>VI PHẠM CỦA BẠN</b></div>';
echo '<div class="list1"><b>Tài khoản của bạn đã bị khóa</b>';
echo'<a href="' . $set['homeurl'] . '/users/profile.php?act=ban">[Chi tiết]</a>';

echo'<br><font color="red">Người khóa:</font> <b>'.$b['ban_who'].'</b>
<font color="red">Lý do</font>: <b>'.$b['ban_reason'].'</b>
</div>';
include'end.php';
exit;
}
if(!$datauser['ip_cu'])
{
mysql_query("UPDATE `users` SET   `ip_cu` = '" . $_SERVER['REMOTE_ADDR'] . "'
            WHERE `id` = '".$user_id."'
        ");
}
else
{
if($trangthai == 'bat')
{
if($datauser['ip_cu'] != $_SERVER['REMOTE_ADDR'])	
{	

echo'<div class="phdr"><b>TÀI KHOẢN ĐANG BỊ TẠM KHÓA</b></div>';
echo '<div class="list1"><b>Tài khoản của bạn đã tạm khóa</b>';
echo'<br><font color="red">Lý do:</font> <b>Đăng nhập từ IP khác.</b><br> IP Hiện Tại: '.$_SERVER['REMOTE_ADDR'].'.<br>IP Cũ: '.$datauser['ip_cu'].'.
</div>';
echo '<div class="list1">';
if ($_POST['password_2'] && $_POST['token']) 
{
		$password = mysql_fetch_assoc(mysql_query("SELECT password_2 FROM users WHERE id = $user_id"));
		$password_2 = md5(md5($_POST['password_2']));
		$puaru_token = $_POST['token'];
		if ($password['password_2'] != $password_2) {
			echo '<div class="list1" style="color:red"><b>Mật khẩu cấp 2 không đúng !</b></div>'; 
		} else {
mysql_query("UPDATE `users` SET   `ip_cu` = '" . $_SERVER['REMOTE_ADDR'] . "'
            WHERE `id` = '".$user_id."'
        ");
		echo '<div class="list1"><p><b style="color:green">Bạn Đã Thay Đổi IP Thành Công Sang ' . $_SERVER['REMOTE_ADDR'] . '.</p><p><a href="/">Trở về trang chủ</a></p></div>';
			echo '</div>';
			require_once ('end.php');
			exit;		
		
		}
	}
echo '<form method="POST">';
echo '<p>Mật khẩu cấp 2 của bạn</p>';
echo '<p><input name="password_2" type="password"></p>';
$rantoken =rand(000000,999999);
$_SESSION[token] = $rantoken;
echo'<input type="hidden" name="token" value="'.$_SESSION[token].'"/>';
echo '<p><input name="submit" type="submit" value="Thay Đổi IP Mới"></p>';
echo '</form>';
echo '</div>'; 
include'end.php';
exit;

}
}
}


/*
-----------------------------------------------------------------
Bố Cục Mod by VinaJohnCMS
-----------------------------------------------------------------
*/
if ($user_id) {
    $list = array();
    $new_sys_mail = mysql_result(mysql_query("SELECT COUNT(*) FROM `cms_mail` WHERE `from_id`='$user_id' AND `read`='0' AND `sys`='1' AND `delete`!='$user_id';"), 0);
	if ($new_sys_mail) $list[] = '<a href="' . $home . '/mail/index.php?act=systems">Hệ thống</a> (+' . $new_sys_mail . ')';
	$new_mail = mysql_result(mysql_query("SELECT COUNT(*) FROM `cms_mail` LEFT JOIN `cms_contact` ON `cms_mail`.`user_id`=`cms_contact`.`from_id` AND `cms_contact`.`user_id`='$user_id' WHERE `cms_mail`.`from_id`='$user_id' AND `cms_mail`.`sys`='0' AND `cms_mail`.`read`='0' AND `cms_mail`.`delete`!='$user_id' AND `cms_contact`.`ban`!='1' AND `cms_mail`.`spam`='0'"), 0);
	if ($new_mail) $list[] = '<a href="' . $home . '/mail/index.php?act=new">' . $lng['mail'] . '</a> (+' . $new_mail . ')';
    if ($datauser['comm_count'] > $datauser['comm_old']) $list[] = '<a href="' . core::$system_set['homeurl'] . '/users/profile.php?act=guestbook&amp;user=' . $user_id . '">' . $lng['guestbook'] . '</a> (' . ($datauser['comm_count'] - $datauser['comm_old']) . ')';
    $new_album_comm = mysql_result(mysql_query("SELECT COUNT(*) FROM `cms_album_files` WHERE `user_id` = '" . core::$user_id . "' AND `unread_comments` = 1"), 0);
    if ($new_album_comm) $list[] = '<a href="' . core::$system_set['homeurl'] . '/users/album.php?act=top&amp;mod=my_new_comm">' . $lng['albums_comments'] . '</a>';

    if (!empty($list)) echo '<div class="rmenu">' . $lng['unread'] . ': ' . functions::display_menu($list, ', ') . '</div>';
}