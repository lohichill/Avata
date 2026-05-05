<?php

/**
 * @package     VinaJohnCMSVN 
 * @link        http://vina4u.Pro
 * @copyright   Copyright (C) 2015-2016 VinaJohnCMSVN Community
 * @author      Vina4u Team
 */

//--- Mod thống kê diễn đàn ---//
$gbot = 0;$msn = 0;$baidu = 0;$bing = 0;$mj = 0;$coccoc = 0;$facebook = 0;$yandex = 0;
$users = mysql_result(mysql_query("SELECT COUNT(*) FROM `users` WHERE `lastdate` > '" . (time() - 600) . "'"), 0);
$guests = mysql_result(mysql_query("SELECT COUNT(*) FROM `cms_sessions` WHERE `lastdate` > '" . (time() - 600) . "'"), 0);
$tong = $users + $guests;$onltime = time() - 600;
$spider = mysql_query("SELECT * FROM `cms_sessions` WHERE `lastdate` > '" . (time() - 600) . "' ORDER BY `lastdate` DESC LIMIT 900");
while ($res = mysql_fetch_assoc($spider)) {
if(stristr($res['browser'], 'Google')) {$gbot = $gbot + 1;}
if(stristr($res['browser'], 'msnbot')) {$msn = $msn + 1;}
if(stristr($res['browser'], 'Baidu')) {$baidu = $baidu + 1;}
if(stristr($res['browser'], 'bingbot')) {$bing = $bing + 1;}
if(stristr($res['browser'], 'MJ12')) {$mj = $mj + 1;}
if(stristr($res['browser'], 'coccoc')) {$coccoc = $coccoc + 1;}
if(stristr($res['browser'], 'facebook')) {$facebook = $facebook + 1;}
if(stristr($res['browser'], 'Yandex')) {$yandex = $yandex + 1;}
}
echo '<div class="phdr">Trực tuyến</div>';

echo '<div class="list1"><font color="green">• </font> Có <a href="/users/index.php?act=online"><b>'.$tong.'</b> Người Trực tuyến , '.$users.' thành viên </a> và '.($guests - ($gbot + $msn + $baidu + $bing + $mj + $coccoc + $facebook + $yandex)).' Khách, và '.($gbot + $msn + $baidu + $bing + $mj + $coccoc + $facebook + $yandex).' spider.</div>';
echo '<div class="list1"><font color="green">• <b>Thành Viên Online:</b></font> ';
$req = mysql_query("SELECT `id`, `name` FROM `users` WHERE `preg`='1' and `lastdate` > '$onltime' ORDER BY `name` ASC LIMIT 1000");
while ($res = mysql_fetch_assoc($req)) {
if($user_id)
$user_on[] = '<a href="'.$home.'/users/profile.php?user='.$res['id'].'">'.nick($res['id']).'</a>';
else
$user_on[] = nick($res['id']);
}
echo implode(', ',$user_on).',';

if (($gbot + $msn + $baidu + $bing + $mj + $coccoc + $facebook + $yandex)) {
if ($gbot) echo ' <font color="red"><b>['.$gbot.']Google</b></font>, ';
if ($msn) echo ' <font color="blue"><b>['.$msn.']MSN</b></font>, ';
if ($baidu) echo ' <font color="green"><b>['.$baidu.']Baidu</b></font>, ';
if ($bing) echo ' <font color="red"><b>['.$bing.']Bing</b></font>, ';
if ($mj) echo ' <font color="green"><b>['.$mj.']MJ12</b></font>, ';
if ($coccoc) echo ' <font color="blue"><b>['.$coccoc.']CốcCốc</b></font>, ';
if ($facebook) echo ' <font color="blue"><b>['.$facebook.']Facebook</b></font>, ';
if ($yandex) echo ' <font color="red"><b>['.$yandex.']Yandex</b></font>, ';
}
echo ' ... </div>';
$thanhvienmoi=mysql_fetch_assoc(mysql_query("SELECT * FROM `users` ORDER BY `datereg` DESC LIMIT 1"));
echo '<div class="list1"><font color="green">• </font>Chào mừng thành viên mới: <a href="'.$home.'/users/profile.php?user='.$thanhvienmoi['id'].'">'.nick($thanhvienmoi['id']).'</a>.</div>';

?>