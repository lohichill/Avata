<?php
define('_IN_JOHNCMS',1);
require('../incfiles/core.php');
$textl='Bảng xếp hạng';
require('../incfiles/head.php');
echo '<div class="mainblok">';
echo '<div class="phdr">Bảng xếp hạng Xu</div>';
$reqbalans=mysql_query("SELECT * FROM `users` WHERE `rights` < 3 ORDER BY `balans` DESC LIMIT 0,5");
while ($resbalans = mysql_fetch_array($reqbalans)) {
echo '<div class="menu list-bottom"><img src="'.$home.'/avatar/'.$resbalans['id'].'.png" alt="'. $user['name'] . '" class="avatar_vina"/>
<a href="/users/'.$resbalans['id'].'.html"><b>'.nick($resbalans['id']).'</b></a><br/>
Tài Sản: '.$resbalans['balans'].' Xu</div>';
}
echo '<div class="phdr">Bảng xếp hạng Lượng</div>';
$reqluong=mysql_query("SELECT * FROM `users` WHERE `rights` < 3 ORDER BY `luong` DESC LIMIT 0,5");
while ($resluong = mysql_fetch_array($reqluong)) {
echo '<div class="menu list-bottom"><img src="'.$home.'/avatar/'.$resluong['id'].'.png" alt="'. $user['name'] . '" class="avatar_vina"/>
<a href="/users/'.$resluong['id'].'.html"><b>'.nick($resluong['id']).'</b></a><br/>
Tài Sản: '.$resluong['luong'].' Lượng</div>';
}

echo '<div class="phdr">Bảng xếp hạng Sức Mạnh</div>';
$reqluong=mysql_query("SELECT * FROM `users` WHERE `rights` < 3 ORDER BY `sucmanh` DESC LIMIT 0,5");
while ($resluong = mysql_fetch_array($reqluong)) {
echo '<div class="menu list-bottom"><img src="'.$home.'/avatar/'.$resluong['id'].'.png" alt="'. $user['name'] . '" class="avatar_vina"/>
<a href="/users/'.$resluong['id'].'.html"><b>'.nick($resluong['id']).'</b></a><br/>
Lực Chiến: '.$resluong['sucmanh'].' Sức Mạnh</div>';
}

echo '<div class="phdr">Bảng xếp hạng Cống Hiến</div>';
$reqforum=mysql_query("SELECT * FROM `users` WHERE `postforum`>=50 ORDER BY `postforum` DESC LIMIT 0,5");
while ($resforum = mysql_fetch_array($reqforum)) {
echo '<div class="menu list-bottom"><img src="'.$home.'/avatar/'.$resforum['id'].'.png" alt="'. $user['name'] . '" class="avatar_vina"/>
<a href="/users/'.$resforum['id'].'.html"><b>'.nick($resforum['id']).'</b></a><br/>
Cống Hiến: '.$resforum['sucmanh'].' Điểm</div>';
}


echo '</div>';
require('../incfiles/end.php');
?>