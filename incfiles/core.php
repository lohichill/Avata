<?php
require_once "db.php";
require_once "mysql_compat.php";

error_reporting(0);

/*
 * @package     VinaJohnCMS
 * @link        http://vina4u.pro
 * @copyright   Copyright (C) 2008-2011 VinaJohnCMS Community
 * @author      http://facebook.com/vina4uteam
 */

defined('_IN_JOHNCMS') or die('Error: restricted access');

ini_set('session.use_trans_sid', '0');
ini_set('arg_separator.output', '&amp;');
ini_set('display_errors', 'Off');
date_default_timezone_set('UTC');
mb_internal_encoding('UTF-8');

define('ROOTPATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

spl_autoload_register('autoload');
function autoload($name)
{
    $file = ROOTPATH . 'incfiles/classes/' . $name . '.php';
    if (file_exists($file))
        require_once($file);
}

new core;

$rootpath = ROOTPATH;
$phienban = '5';
$ip = core::$ip; 
$agn = core::$user_agent; 
$set = core::$system_set; 
$lng = core::$lng; 
$is_mobile = core::$is_mobile; 
$home = $set['homeurl']; 

$user_id = core::$user_id; 
$rights = core::$user_rights; 
$datauser = core::$user_data; 
$set_user = core::$user_set; 
$ban = core::$user_ban; 
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

$id = isset($_REQUEST['id']) ? abs(intval($_REQUEST['id'])) : false;
$user = isset($_REQUEST['user']) ? abs(intval($_REQUEST['user'])) : false;
$act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
$mod = isset($_REQUEST['mod']) ? trim($_REQUEST['mod']) : '';
$do = isset($_REQUEST['do']) ? trim($_REQUEST['do']) : false;
$page = isset($_REQUEST['page']) && $_REQUEST['page'] > 0 ? intval($_REQUEST['page']) : 1;
$start = isset($_REQUEST['page']) ? $page * $kmess - $kmess : (isset($_GET['start']) ? abs(intval($_GET['start'])) : 0);
$headmod = isset($headmod) ? $headmod : '';

if ((core::$system_set['site_access'] == 0 || core::$system_set['site_access'] == 1) && $headmod != 'login' && !core::$user_id) {
    header('Location: ' . core::$system_set['homeurl'] . '/closed.php');
}

if ($set['gzip'] && @extension_loaded('zlib')) {
    @ini_set('zlib.output_compression_level', 3);
    ob_start('ob_gzhandler');
} else {
    ob_start();
}

function nick($id, $mod = false){
    global $conn;
    $out = '';
    
    // Check Ban
    $stmt = $conn->prepare("SELECT COUNT(*) FROM `cms_ban_users` WHERE `user_id` = ? AND `ban_time` > ?");
    $stmt->bind_param("is", $id, time());
    $stmt->execute();
    $ban = $stmt->get_result()->fetch_row()[0];

    // User Data
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE `id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if (!$user) return '';

    // Shop Options
    $stmt = $conn->prepare("SELECT COUNT(*) FROM `shop_options` WHERE `vip` = 1 AND `user_id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $vip_shop = $stmt->get_result()->fetch_row()[0];

    $stmt = $conn->prepare("SELECT COUNT(*) FROM `shop_options` WHERE `bold` = 1 AND `user_id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $bold_shop = $stmt->get_result()->fetch_row()[0];

    // Clan
    $stmt = $conn->prepare("SELECT * FROM `nhom_user` WHERE `duyet`='1' AND `user_id` = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res_clan = $stmt->get_result();
    
    $clan = '';
    if ($res_clan->num_rows > 0) {
        $ss = $res_clan->fetch_assoc();
        $stmt = $conn->prepare("SELECT * FROM `nhom` WHERE `id` = ?");
        $stmt->bind_param("i", $ss['id']);
        $stmt->execute();
        $nhom = $stmt->get_result()->fetch_assoc();
        if ($nhom) {
            $clan = '<img src="/images/clan/'.$nhom['icon'].'.png">';
        }
    }

    // TOPs
    $tops = [];
    $queries = [
        'Xu' => "ORDER By `balans` DESC LIMIT 1",
        'Post' => "ORDER By `postforum` DESC LIMIT 1",
        'HoạtĐộng' => "ORDER By `online` DESC LIMIT 1",
        'Lượng' => "ORDER By `luong` DESC LIMIT 1",
        'Nạp' => "ORDER By `napcard` DESC LIMIT 1",
        'QC' => "ORDER By `gioithieu` DESC LIMIT 1"
    ];

    foreach ($queries as $label => $order) {
        $stmt = $conn->prepare("SELECT `id` FROM `users` WHERE `rights` != '9' AND `rights` != '10' $order");
        $stmt->execute();
        $res = $stmt->get_result()->fetch_assoc();
        if ($res && $res['id'] == $user['id']) {
            $tops[] = "[TOP-$label]";
        }
    }
    
    $out .= '<small><span style="color:orange">' . implode(' ', $tops) . '</span></small>';

    if($ban > 0) {
        $out .= '<span style="color:#000000">'.($mod == 1 ? '<small>' : '').'<s>' . $user['name'] . '</s>'.($mod == 1 ? '</small>' : '').'</span>';
    } else {
        $font = '';
        switch($user['rights']) {
            case 100: $font = '<span style="text-shadow: 0px 0px 6px rgb(255, 0, 153), 0px 0px 5px rgb(255, 0, 153), 0px 0px 5px rgb(255, 0, 153); color:#ffffff">'; break;
            case 0: case 1: $font = '<span style="color:#000000">'; break;
            case 2: $font = '<span style="color:#b903f3">'; break;
            case 3: $font = '<span style="color:#008000">'; break;
            case 4: $font = '<span style="color:#D2691E">'; break;
            case 5: $font = '<span style="color:#770000">'; break;
            case 6: $font = '<span style="color:#0000FF">'; break;
            case 7: case 9: $font = '<span style="color:#ff0000">'; break;
            case 10: $font = '<span style="color:red">'; break;
            default: $font = '<span>'; break;
        }

        $icon = '';
        if (isset($user['tom_icon']) && $user['tom_icon'] >= 1 && $user['tom_icon'] <= 11) {
            $ext = ($user['tom_icon'] == 6) ? '.gif' : (($user['tom_icon'] == 7 || $user['tom_icon'] == 8) ? '.jpg' : '.png');
            $icon = ' <img src="/images/item/'.$user['tom_icon'].'$ext" alt=""/> ';
        }

        if($user['dayb'] == date('j') && $user['monthb'] == date('n')) {
            $sn = '<img src="/images/cookie.png">';
        }
        
        $out .= ($vip_shop == 1 ? '<img src="/images/vip.png" alt="VIP"/>'.($user['rights'] == 0 ? '<span style="color:#963360">' : $font) : $font) . ' ' . ($bold_shop == 1 ? '<b>' : '') . $icon . $user['name'] . ' ' . $clan . ($bold_shop == 1 ? '</b>' : '') . '</span>';
    }
    return $out;
}

function Tagf($tag) {
    global $conn;
    if (!isset($tag[1])) return '@' . ($tag[0] ?? 'unknown');
    
    $stmt = $conn->prepare("SELECT COUNT(*) FROM `users` WHERE `name` = ?");
    $stmt->bind_param("s", $tag[1]);
    $stmt->execute();
    $kt = $stmt->get_result()->fetch_row()[0];

    if($kt > 0) {
        $stmt = $conn->prepare("SELECT * FROM `users` WHERE `name` = ?");
        $stmt->bind_param("s", $tag[1]);
        $stmt->execute();
        $t = $stmt->get_result()->fetch_assoc();
        return '<a href="/users/'.$t['id'].'.html"><b>'.nick($t['id']).'</b></a>';
    } else {
        return '@'.$tag[1];
    }
}

function domacsm($datado,$user){
    global $conn;
    $sucmanh = 0;
    $items = ['ao', 'toc', 'quan', 'non', 'mat', 'matna', 'canh', 'thucung', 'docamtay', 'kinh', 'haoquang'];
    
    foreach($items as $item) {
        if (!empty($datado[$item])) {
            $name = $datado[$item];
            $stmt = $conn->prepare("SELECT `sucmanh` FROM `khodo` WHERE `name` = ? AND `id_user` = ? AND `loaisp` = ?");
            $stmt->bind_param("sii", $name, $user, $item);
            $stmt->execute();
            $res = $stmt->get_result()->fetch_assoc();
            if ($res) $sucmanh += $res['sucmanh'];
        }
    }
    
    if($datado['luutrusm'] != $sucmanh){
        $stmt = $conn->prepare("UPDATE `users` SET `luutrusm` = ? WHERE `id` = ?");
        $stmt->bind_param("ii", $sucmanh, $user);
        $stmt->execute();
    }
}

function danhsachdo($datado,$user){
    global $conn;
    $sucmanhrt = [];
    $items = ['ao', 'toc', 'quan', 'non', 'mat', 'matna', 'canh', 'thucung', 'docamtay', 'kinh', 'haoquang'];
    
    foreach($items as $item) {
        if (!empty($datado[$item])) {
            $name = $datado[$item];
            $stmt = $conn->prepare("SELECT * FROM `khodo` WHERE `name` = ? AND `id_user` = ? AND `loaisp` = ?");
            $stmt->bind_param("sii", $name, $user, $item);
            $stmt->execute();
            $sucmanhrt[$item] = $stmt->get_result()->fetch_assoc();
        }
    }
    return $sucmanhrt;
}

function chuc($chuc){
    global $conn;
    $stmt = $conn->prepare("SELECT `rights` from `users` where `id` = ?");
    $stmt->bind_param("i", $chuc);
    $stmt->execute();
    $timkiem = $stmt->get_result()->fetch_assoc();
    
    if(!$timkiem) return '';
    
    $r = $timkiem['rights'];
    $chuc_vi = '';
    if($r == 9) $chuc_vi = '<span style="color: red;"> - Người Sáng Lập</span>';
    elseif($r == 8) $chuc_vi = '<span style="color: green;"> - Admin Cấp Cao</span>';
    elseif($r == 7) $chuc_vi = '<span style="color: red;"> - Administrator</span>';
    elseif($r == 6) $chuc_vi = '<span style="color: #993399;"> - Tổng Quản Lí</span>';
    elseif($r == 5) $chuc_vi = '<span style="color: #ff9000;"> - Trial Smod</span>';
    elseif($r == 4) $chuc_vi = '<span style="color: #ad4105;"> - Trung Gian</span>';
    elseif($r == 3) $chuc_vi = '<span style="color: green;"> - Moder Forum</span>';
    elseif($r == 2) $chuc_vi = '<span style="color: green;"> - Trial Mod</span>';
    elseif($r == 1) $chuc_vi = '<span style="color: green;"> - VIP</span>';
    return $chuc_vi;
}

function expuser($expuser){
    global $conn;
    $stmt = $conn->prepare("SELECT `online` FROM users WHERE id = ?");
    $stmt->bind_param("i", $expuser);
    $stmt->execute();
    $tkexp = $stmt->get_result()->fetch_assoc();
    if (!$tkexp) return 0;
    
    $daon = $tkexp['online'];
    $expgio = (60 * 60) / 10;
    $xuatexp = $daon / $expgio;
    return floor($xuatexp);
}

function lv($lv){
    global $conn;
    $stmt = $conn->prepare("SELECT `online` FROM users WHERE id = ?");
    $stmt->bind_param("i", $lv);
    $stmt->execute();
    $tklv = $stmt->get_result()->fetch_assoc();
    if (!$tklv) return 0;
    
    $daon = $tklv['online'];
    $expgio = (60 * 60) / 10;
    $xuatexp = $daon / $expgio;
    $exp = floor($xuatexp);
    return floor((100 + $exp) / 100);
}

function timeonline($time){
    $ketqua = $time;
    $ngay = floor($ketqua / (60 * 60 * 24));
    $sogio = $ketqua % (60 * 60 * 24);
    $gio = floor($sogio / (60 * 60));
    $sophut = $sogio % (60 * 60);
    $phut = floor($sophut / 60);
    $giay = $sophut % 60;
    
    if($ngay != 0){
        return $ngay.' ngày, '.$gio.' giờ, '.$phut.' phút';
    }elseif($gio != 0){
        return $gio.' gio, '.$phut.' phút, '.$giay.' giây';
    }elseif($phut != 0){
        return $phut.' phút, '.$giay.' giây';
    }else{ 
        return $giay.' giây'; 
    }
}

$congtime = time() - ($datauser['lastdate'] ?? 0);
if($datauser['lastdate'] > (time() - 300)){
    $stmt = $conn->prepare("UPDATE `users` SET `online` = `online` + ? WHERE `id` = ?");
    $stmt->bind_param("ii", $congtime, $user_id);
    $stmt->execute();
}

if(isset($_POST)&&$textl!='ZimCity.US'){
    foreach($_POST as $index => $value){
        if(is_string($value))
            $_POST[$index]=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }
}
if(isset($_GET)&&$textl!='ZimCity.US'){
    foreach($_GET as $index => $value){
        if(is_string($value))
            $_GET[$index]=htmlspecialchars($value,ENT_QUOTES,'UTF-8');
    }
}
?>
