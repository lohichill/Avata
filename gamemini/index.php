<?php
define('_IN_JOHNCMS', 1);

require_once('../incfiles/core.php');
$textl = 'Game Mini';
require('../incfiles/head.php');
echo '<div class="phdr">Game Mini</div>';
if(!$user_id){
echo '<div class="list1">Truy Cập Dành Cho Thành Viên OlaVN</div>';
require('../incfiles/end.php');
exit;
}
echo '<div class="list1">Chức Năng Đang Được Tiến Hành Xây Dựng!</div>';

require('../incfiles/end.php');
?>