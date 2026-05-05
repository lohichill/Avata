<?php
define('_IN_JOHNCMS', 1);
require_once('../incfiles/core.php');
$textl = 'Đổi quà bằng mã gift';
require_once('../incfiles/head.php');
function rand_string($length) {
$chars ="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
$size = strlen($char);
for($i = 0; $i<$length; $i++) {
$str .= $chars[rand(0, $size -1)];
$str=substr(str_shuffle($chars), 0, $length);
}
return$str;
}
$random = rand_string(8);
$balans = rand(00000,99999);
$luong = rand(00,10);
mysql_query("INSERT INTO `magift` SET `user`='1', `ma`='".$random."',
`time`='".time()."', `balans`='".$balans."', `luong`='".$luong."'");
$bot= 'Mã: '.$random.'
+ Giá trị Xu: '.$balans.'
+ Giá trị luong: '.$luong.'';
mysql_query("INSERT INTO `guest` SET
                `adm` = '0',
                `time` = '".time()."',
                `user_id` = '1',
                `name` = 'BOT',
                `text` = '" . mysql_real_escape_string($bot) . "',
                `ip` = '60543201',
                `browser` = 'BOT 1.0'
            ");
require('../incfiles/end.php');
?>