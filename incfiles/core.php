<?php
error_reporting(0);

/*
 * @package     VinaJohnCMS
 * @link        http://vina4u.pro
 * @copyright   Copyright (C) 2008-2011 VinaJohnCMS Community
 * @author      http://facebook.com/vina4uteam
 */


defined('_IN_JOHNCMS') or die('Error: restricted access');
//Error_Reporting(E_ALL & ~E_NOTICE);
ini_set('session.use_trans_sid', '0');
ini_set('arg_separator.output', '&amp;');
ini_set('display_errors', 'Off');
date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

// Корневая папка
define('ROOTPATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

/*
-----------------------------------------------------------------
Автозагрузка Классов
-----------------------------------------------------------------
*/
spl_autoload_register('autoload');
function autoload($name)
{
    $file = ROOTPATH . 'incfiles/classes/' . $name . '.php';
    if (file_exists($file))
        require_once($file);
}

/*
-----------------------------------------------------------------
Инициализируем Ядро системы
-----------------------------------------------------------------
*/
new core;

/*
-----------------------------------------------------------------
Получаем системные переменные для совместимости со старыми модулями
-----------------------------------------------------------------
*/
$rootpath = ROOTPATH;
$phienban = '5';
$ip = core::$ip; // Адрес IP
$agn = core::$user_agent; // User Agent
$set = core::$system_set; // Системные настройки
$lng = core::$lng; // Фразы языка
$is_mobile = core::$is_mobile; // Определение мобильного браузера
$home = $set['homeurl']; // Домашняя страница

/*
-----------------------------------------------------------------
Получаем пользовательские переменные
-----------------------------------------------------------------
*/
$user_id = core::$user_id; // Идентификатор пользователя
$rights = core::$user_rights; // Права доступа
$datauser = core::$user_data; // Все данные пользователя
$set_user = core::$user_set; // Пользовательские настройки
$ban = core::$user_ban; // Бан
$login = isset($datauser['name']) ? $datauser['name'] : false;
$kmess = $set_user['kmess'] > 4 && $set_user['kmess'] < 10 ? $set_user['kmess'] : 10;
$noionline = isset($noionline) ? $noionline : '';


function validate_referer()
{
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
    if (@!empty($_SERVER['HTTP_REFERER'])) {
        $ref = parse_url(@$_SERVER['HTTP_REFERER']);
        if ($_SERVER['HTTP_HOST'] === $ref['host']) return;
    }
    die('Invalid request');
}

if ($rights) {
    validate_referer();
}

/*
-----------------------------------------------------------------
Получаем и фильтруем основные переменные для системы
-----------------------------------------------------------------
*/
$id = isset($_REQUEST['id']) ? abs(intval($_REQUEST['id'])) : false;
$user = isset($_REQUEST['user']) ? abs(intval($_REQUEST['user'])) : false;
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
$mod = isset($_REQUEST['mod']) ? trim($_REQUEST['mod']) : '';
$do = isset($_REQUEST['do']) ? trim($_REQUEST['do']) : false;
$page = isset($_REQUEST['page']) && $_REQUEST['page'] > 0 ? intval($_REQUEST['page']) : 1;
$start = isset($_REQUEST['page']) ? $page * $kmess - $kmess : (isset($_GET['start']) ? abs(intval($_GET['start'])) : 0);
$headmod = isset($headmod) ? $headmod : '';

/*
-----------------------------------------------------------------
Закрытие сайта / редирект гостей на страницу ожидания
-----------------------------------------------------------------
*/
if ((core::$system_set['site_access'] == 0 || core::$system_set['site_access'] == 1) && $headmod != 'login' && !core::$user_id) {
    header('Location: ' . core::$system_set['homeurl'] . '/closed.php');
}

/*
-----------------------------------------------------------------
Буфферизация вывода
-----------------------------------------------------------------
*/
if ($set['gzip'] && @extension_loaded('zlib')) {
    @ini_set('zlib.output_compression_level', 3);
    ob_start('ob_gzhandler');
} else {
    ob_start();
}

function nick($id, $mod = false){
$ban = mysql_result(mysql_query("SELECT COUNT(*) FROM `cms_ban_users` WHERE `user_id` = '" . $id . "' AND `ban_time` > '" . time() . "'"), 0);
$user = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `id` = '" . $id . "'"));
if ($id) $vip_shop = mysql_result(mysql_query("SELECT COUNT(*) FROM `shop_options` WHERE `vip` = 1 AND `user_id` = $id"), 0);
if ($id) $bold_shop = mysql_result(mysql_query("SELECT COUNT(*) FROM `shop_options` WHERE `bold` = 1 AND `user_id` = $id"), 0);

$cclan=mysql_num_rows(mysql_query("SELECT * FROM `nhom_user` WHERE `duyet`='1' AND `user_id`='".$user[id]."'"));
if ($cclan) {
$ss=mysql_fetch_array(mysql_query("SELECT * FROM `nhom_user` WHERE `user_id`='".$user[id]."'"));
$nhom=mysql_fetch_array(mysql_query("SELECT * FROM `nhom` WHERE `id`='".$ss[id]."'"));
$clan='<img src="/images/clan/'.$nhom[icon].'.png">';
} else {
$clan='';
}
$xu = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `rights` != '9' AND `rights` != '10' ORDER By `balans` DESC LIMIT 1"));
$luong = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `rights` != '9' AND `rights` != '10' ORDER By `luong` DESC LIMIT 1"));
$postforum = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `rights` != '9' AND `rights` != '10' ORDER By `postforum` DESC LIMIT 1"));
$online = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `rights` != '9' AND `rights` != '10' ORDER By `online` DESC LIMIT 1"));
$napcard = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `rights` != '9' AND `rights` != '10' ORDER By `napcard` DESC LIMIT 1"));
$gt = mysql_fetch_assoc(mysql_query("SELECT * FROM `users` WHERE `rights` != '9' AND `rights` != '10' ORDER By `gioithieu` DESC LIMIT 1"));

$out .= '<small>';
if($user['id'] == $xu['id']) { $out .= '<font color="orange"> [TOP-Xu]</font>'; }
if($user['id'] == $postform['id']) { $out .= '<font color="orange"> [TOP-Post]</font>'; }
if($user['id'] == $online['id']) { $out .= '<font color="orange"> [TOP-HoạtĐộng]</font>'; }
if($user['id'] == $luong['id']) { $out .= '<font color="orange"> [TOP-Lượng]</font>'; }
if($user['id'] == $napcard['id']) { $out .= '<font color="orange"> [TOP-Nạp]</font>'; }
if($user['id'] == $gt['id']) { $out .= '<font color="orange"> [TOP-QC]</font>'; }
$out .= '</small>';


if($ban > 0) {
$out .= '<span style="color:#000000">'.($mod == 1 ? '<small>' : '').'<s>' . $user['name'] . '</s>'.($mod == 1 ? '</small>' : '').'</span>';
} else {
if($user['rights'] == 100) {$font = '<span style="text-shadow: 0px 0px 6px rgb(255, 0, 153), 0px 0px 5px rgb(255, 0, 153), 0px 0px 5px rgb(255, 0, 153);" color="#ffffff">';}
if($user['rights'] == 0) {$font = '<span style="color:#000000">';}
if($user['rights'] == 1) {$font = '<span style="color:#000000">';}
if($user['rights'] == 2) {$font = '<span style="color:#b903f3">';}
if($user['rights'] == 3) {$font = '<span style="color:#008000">';}
if($user['rights'] == 4) {$font = '<span style="color:#D2691E">';}
if($user['rights'] == 5) {$font = '<span style="color:#770000">';}
if($user['rights'] == 6) {$font = '<span style="color:#0000FF">';}
if($user['rights'] == 7) {$font = '<span style="color:#ff0000">';}
if($user['rights'] == 9) {$font = '<span style="color:#ff0000">';}
if($user['rights'] == 10) {$font = '<span style="color:#red">';}


if($user['tom_icon'] == 1) {$icon .= ' <img src="/images/item/1.png" alt=""/> ';}
if($user['tom_icon'] == 2) {$icon .= ' <img src="/images/item/2.png" alt=""/> ';}
if($user['tom_icon'] == 3) {$icon .= ' <img src="/images/item/3.png" alt=""/> ';}
if($user['tom_icon'] == 4) {$icon .= ' <img src="/images/item/4.png" alt=""/> ';}
if($user['tom_icon'] == 5) {$icon  .= ' <img src="/images/item/5.png" alt=""/> ';}
if($user['tom_icon'] == 6) {$icon .= ' <img src="/images/item/6.gif" alt=""/> ';}
if($user['tom_icon'] == 7) {$icon .= ' <img src="/images/item/7.jpg" alt=""/> ';}
if($user['tom_icon'] == 8) {$icon .= ' <img src="/images/item/8.jpg" alt=""/> ';}
if($user['tom_icon'] == 9) {$icon .= ' <img src="/images/item/9.gif" alt=""/> ';}
if($user['tom_icon'] == 10) {$icon .= ' <img src="/images/item/10.gif" alt=""/> ';}
if($user['tom_icon'] == 11) {$icon .= ' <img src="/images/item/11.jpg" alt=""/> ';}


if($user['dayb'] == date('j', time()) && $user['monthb'] == date('n', time())) {$sn = '<img src="/images/cookie.png">';}
$out .= ($vip_shop == 1 ? '<img src="/images/vip.png" alt="VIP"/>'.($user['rights'] == 0 ? '<span style="color:#963360">' : $font).'' : $font).' '.($bold_shop == 1 ? '<b>' : '').''.$icon.'' . $user['name'] . ' '.$clan.''.($bold_shop == 1 ? '</b>' : '').'</span>';
}
return $out;
}

//mod tag thành viên TOMDZ
function Tagf($tag) {
$kt = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `name`='{$tag[1]}'"), 0);
$t = mysql_fetch_array(mysql_query("SELECT * FROM `users` WHERE `name`='{$tag[1]}'"));
if($kt > 0) {
//$out = '<a href="/users/'.$t['id'].'.html">'.$t['name'].'</a>';
$out = '<a href="/users/'.$t['id'].'.html"><b>'.nick($t['id']).'</b></a>';
return $out;
} else {
$out = '@'.$tag[1].'';
return $out;
}
}



function domacsm($datado,$user){
	$ao = $datado['ao'];
	$toc = $datado['toc'];
	$quan = $datado['quan'];
	$non = $datado['non'];
	$mat = $datado['mat'];
	$matna = $datado['matna'];
	$canh = $datado['canh'];
	$thucung = $datado['thucung'];
	$docamtay = $datado['docamtay'];
	$kinh = $datado['kinh'];
	$haoquang = $datado['haoquang'];
	$sucmanhht = $datado['luutrusm'];
	$sucmanh = 0;
	if($ao != ''){
		$loaisp = 'ao';
		$name = $ao;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($toc != ''){
		$loaisp = 'toc';
		$name = $toc;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($quan != ''){
		$loaisp = 'quan';
		$name = $quan;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($non != ''){
		$loaisp = 'non';
		$name = $non;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($mat != ''){
		$loaisp = 'mat';
		$name = $mat;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($matna != ''){
		$loaisp = 'matna';
		$name = $matna;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($canh != ''){
		$loaisp = 'canh';
		$name = $canh;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($thucung != ''){
		$loaisp = 'thucung';
		$name = $thucung;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($docamtay != ''){
		$loaisp = 'docamtay';
		$name = $docamtay;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($kinh != ''){
		$loaisp = 'kinh';
		$name = $kinh;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($haoquang != ''){
		$loaisp = 'haoquang';
		$name = $haoquang;
		$nameq = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanh += $nameq['sucmanh'];
	}
	if($sucmanhht != $sucmanh){
		mysql_query("UPDATE `users` SET `luutrusm` = '{$sucmanh}' WHERE `id` = '{$user}'");
	}
}
function danhsachdo($datado,$user){
	$ao = $datado['ao'];
	$toc = $datado['toc'];
	$quan = $datado['quan'];
	$non = $datado['non'];
	$mat = $datado['mat'];
	$matna = $datado['matna'];
	$canh = $datado['canh'];
	$thucung = $datado['thucung'];
	$docamtay = $datado['docamtay'];
	$kinh = $datado['kinh'];
	$haoquang = $datado['haoquang'];
	$sucmanhht = $datado['luutrusm'];
	if($ao != ''){
		$loaisp = 'ao';
		$name = $ao;
		$nameq_ao = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['ao'] = $nameq_ao;
	}
	if($toc != ''){
		$loaisp = 'toc';
		$name = $toc;
		$nameq_toc = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['toc'] = $nameq_toc;
	}
	if($quan != ''){
		$loaisp = 'quan';
		$name = $quan;
		$nameqquan = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['quan'] = $nameqquan;
	}
	if($non != ''){
		$loaisp = 'non';
		$name = $non;
		$nameqnon = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['non'] = $nameqnon;
	}
	if($mat != ''){
		$loaisp = 'mat';
		$name = $mat;
		$nameqmat = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['mat'] = $nameqmat;
	}
	if($matna != ''){
		$loaisp = 'matna';
		$name = $matna;
		$nameqmat = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['matna'] = $nameqmat;
	}
	if($canh != ''){
		$loaisp = 'canh';
		$name = $canh;
		$nameqcanh = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['canh'] = $nameqcanh;
	}
	if($thucung != ''){
		$loaisp = 'thucung';
		$name = $thucung;
		$nameqthucung = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['thucung'] = $nameqthucung;
	}
	if($docamtay != ''){
		$loaisp = 'docamtay';
		$name = $docamtay;
		$nameqdocamtay = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['docamtay'] = $nameqdocamtay;
	}
	if($kinh != ''){
		$loaisp = 'kinh';
		$name = $kinh;
		$nameqkinh = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['kinh'] = $nameqkinh;
	}
	if($haoquang != ''){
		$loaisp = 'haoquang';
		$name = $haoquang;
		$nameq_hqhaoquang = mysql_fetch_assoc(mysql_query("SELECT * FROM `khodo` WHERE `name` = '{$name}' AND `id_user` = '{$user}' AND `loaisp` = '{$loaisp}'"));
		$sucmanhrt['haoquang'] = $nameq_hqhaoquang;
	}
	return $sucmanhrt;
}

function chuc($chuc){
$timkiem = mysql_fetch_array(mysql_query("SELECT `rights` from `users` where `id` = '$chuc'"));
if($timkiem[rights] == 9) $chuc_vi = '<span style="color: red;"> - Người Sáng Lập</span>';
if($timkiem[rights] == 8) $chuc_vi = '<span style="color: green;"> - Admin Cấp Cao</span>';
if($timkiem[rights] == 7) $chuc_vi = '<span style="color: red;"> - Administrator</span>';
if($timkiem[rights] == 6) $chuc_vi = '<span style="color: #993399;"> - Tổng Quản Lí</span>';
if($timkiem[rights] == 5) $chuc_vi = '<span style="color: #ff9000;"> - Trial Smod</span>';
if($timkiem[rights] == 4) $chuc_vi = '<span style="color: #ad4105;"> - Trung Gian</span>';
if($timkiem[rights] == 3) $chuc_vi = '<span style="color: green;"> - Moder Forum</span>';
if($timkiem[rights] == 2) $chuc_vi = '<span style="color: green;"> - Trial Mod</span>';
if($timkiem[rights] == 1) $chuc_vi = '<span style="color: green;"> - VIP</span>';
return $chuc_vi;
}

function exp_chinhc($exp_chinh){
		$lerver = '0';
		if($exp_chinh >= 20 && $exp_chinh < 100){
			$lerver = '1';
		}else if($exp_chinh >= 100 && $exp_chinh < 200){
			$lerver = '2';
		}else if($exp_chinh >= 200 && $exp_chinh < 350){
			$lerver = '3';
		}else if($exp_chinh >= 350 && $exp_chinh < 600){
			$lerver = '4';
		}else if($exp_chinh >= 600 && $exp_chinh < 850){
			$lerver = '5';
		}else if($exp_chinh >= 850 && $exp_chinh < 1500){
			$lerver = '6';
		}else if($exp_chinh >= 1500 && $exp_chinh < 3000){
			$lerver = '7';
		}else if($exp_chinh >= 3000 && $exp_chinh < 6000){
			$lerver = '8';
		}else if($exp_chinh >= 6000 && $exp_chinh < 10000){
			$lerver = '9';
		}else if($exp_chinh >= 10000){
			$lerver = '10';
		}
		return $lerver;
}

function fixam($so){
	$so=intval($so);
	if($so>0) return $so;
	else return -$so;
}

function expuser($expuser){
$tkexp = @mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='{$expuser}'"));
$daon = $tkexp['online'];
$gio = 60 * 60;
$expgio = $gio / 10;
$xuatexp = $daon / $expgio;
$subexp = explode('.', $xuatexp);
$expuser = $subexp[0];
return $expuser; }
function lv($lv){
$tklv = @mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id='{$lv}'"));
$daon = $tklv['online'];
$gio = 60 * 60;
$expgio = $gio / 10;
$xuatexp = $daon / $expgio;
$subexp = explode('.', $xuatexp);
$exp = $subexp[0];
$xuatlv = (100 + $exp) /100;
$sublv = explode('.', $xuatlv);
$lv= $sublv[0];
return $lv; }
function timeonline($time){
$ketqua = $time;
$chiangay = ($ketqua / 60 / 60 / 24);
$xuatngay = explode('.', $chiangay);
$ngay = $xuatngay[0]; //so ngay
$sogio = ($ketqua - ($ngay * 60 * 60 * 24)); //con lai so gio(tinh theo giay)
$chiagio = ($sogio / 60 / 60);
$xuatgio = explode('.', $chiagio);
$gio = $xuatgio[0]; //so gio
$sophut = ($sogio - ($gio * 60 * 60)); //con lai so phut (tinh theo giay)
$chiaphut = ($sophut / 60);
$xuatphut = explode('.', $chiaphut);
$phut = $xuatphut[0];
$giay = ($sophut - ($phut * 60));
if($ngay != 0){
$time = $ngay.' ngày, '.$gio.' giờ, '.$phut.' phút';
}elseif($gio != 0){
$time = $gio.' gio, '.$phut.' phút, '.$giay.'  giây';
}elseif($phut != 0){
$time = $phut.' phút, '.$giay.' giây';
}else{ $time = $giay.' giây'; }
return $time; }
$congtime = time() - $datauser['lastdate'];
if($datauser['lastdate'] > (time() - 300)){
mysql_query("UPDATE `users` SET `online` = `online`+'$congtime' WHERE `id` = '$user_id'"); }


if(isset($_POST)&&$textl!='ZimCity.US'){
foreach($_POST as $index => $value){
if(is_string($_POST[$index]))
$_POST[$index]=htmlspecialchars($_POST[$index],ENT_QUOTES,'UTF-8');
}
}
if(isset($_GET)&&$textl!='ZimCity.US'){
foreach($_GET as $index => $value){
if(is_string($_GET[$index]))
$_GET[$index]=htmlspecialchars($_GET[$index],ENT_QUOTES,'UTF-8');
}
}