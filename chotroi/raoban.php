<?php
define('_IN_JOHNCMS', 1);
require('../incfiles/core.php');
if (!$user_id) {
require('../incfiles/head.php');
header("Location: $home");
require('../incfiles/end.php');
exit;
}
//--Mod Rao Bán Bởi TOMDZ - OLAVN.MOBI--//
$textl = 'Rao bán - Chợ Trời OLAVN.MOBI';
require('../incfiles/head.php');
echo'<div class="danhmuc">Rao bán đồ</div>';
//$res = mysql_query("select * from `khodo` WHERE `id_user` = '$user_id' "); 



$tong = mysql_result(mysql_query("SELECT COUNT(*) FROM `khodo` WHERE `id_user` = '$user_id' AND `loaisp` != ''"), 0);
$res = mysql_query("select * from `khodo` WHERE `id_user` = '$user_id' AND `loaisp` != '' LIMIT $start, $kmess;");
echo '<div class="menu">Bạn đang có '.$tong.' món đồ !</div>';

echo'<div class="mo">';
echo'<form action="" method="post">';
echo '<div class="list1">Chọn đồ cần Rao bán: <br/><select name="do">';
while ($post = mysql_fetch_array($res)){ 

$kiemtrado = mysql_fetch_array(mysql_query("SELECT * FROM `shop` WHERE `name` = '".$post["name"]."' AND `loaisp` = '".$post["loaisp"]."'"));

if($post['tenvatpham'] != "" && $kiemtrado['tenvatpham'] == ""){
echo "<option value='".$post['name']."'>".$post['tenvatpham']."</option>";
}
if($kiemtrado['tenvatpham'] != ""){
echo "<option value='".$kiemtrado['name']."'>".$kiemtrado['tenvatpham']."</option>";
}


}


echo'</select></div>';
echo'<div class="list1">Thông tin:<br/><textarea type="text" name="thongtin"></textarea></div>';
echo'<div class="list1">Giá Xu:<br/><input type="text" name="balans"/></div>';
echo'<div class="list1">Giá Lượng:<br/><input type="text" name="luong"/></div>';
echo'<div class="list1"><input type="submit" name="raoban" value="Rao bán" /></div>';
echo'</form>';
echo'</div>';




if(isset($_POST['raoban']))
{
    $do = $_POST['do'];
    $thongtin = htmlspecialchars($_POST['thongtin']);
    $balans = intval($_POST['balans']);
    $luong = intval($_POST['luong']);
    if($balans < 0 OR $luong < 0)    {
        echo'<div class="list1">Lỗi! bạn phải nhập số tiền > 0</div>';
    }    else    {
    $laythongtin = mysql_fetch_array(mysql_query("select * from `khodo` WHERE `name` = '$do' AND `id_user` = '$user_id' "));

    $nguoiban = mysql_fetch_array(mysql_query("select * from `tenthat` WHERE `user_id` = '$user_id' "));
    if(empty($nguoiban['ten']))
    {
    $tennguoiban = $datauser['name'];
    }
    else
    {
        $tennguoiban = $nguoiban['ten'];
    }

    $id_loai = $laythongtin['name'];
    $loai = $laythongtin['loaisp'];
    $tenvatpham = $laythongtin['tenvatpham'];
    $type = $laythongtin['type'];
    $tangsucmanh = $laythongtin['sucmanh'];
    $tanghp = $laythongtin['tanghp'];
    $soluong = $laythongtin['soluong'];

 if($datauser[$loai] == $id_loai)
    echo'<div class="list1">Lỗi! Bạn cần phải tháo đồ trước khi bán</div>';
	else
	{
	$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `chotroi` WHERE `loai` = '$loai' AND `id_loai` = '$id_loai' AND `user_id` = '$user_id'"), 0);
if($total == 0)
{
                mysql_query("INSERT INTO `chotroi` SET 
               `user_id`='$user_id',
               `id_loai`='$id_loai',
               `loai`='$loai',
               `type`='$type',
               `tenvatpham`='$tenvatpham',
               `soluong` = '$soluong',
               `tangsucmanh`='$tangsucmanh',
               `hp`='$tanghp',
               `balans` = '$balans',
               `luong` = '$luong',
               `nguoiban`='" . $tennguoiban . "',
               `thongtin`='" . $thongtin . "'
               ");

               echo'<style>.mo {display:none;}</style>';
               echo'<div class="list1">Rao bán thành công!</div>';
    }
else
{
echo'<div class="list1">Bạn chỉ có thể rao bán 1 lần mà thôi</div>';
}
}
    }
}
//--Mod Rao Bán Bởi Hoàng Minh Thuận - OLAVN.MOBI--//
require_once('../incfiles/end.php');
?>
