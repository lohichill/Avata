<?
define('_IN_JOHNCMS', 1);
$noionline = 'shop';
require_once ('../incfiles/core.php');
$textl = 'Chợ Trời';
require_once ('../incfiles/head.php');
if ($user_id){
    //---Mod Chợ Trời Bởi TOMDZ - OLAVN.MOBI---//
    //---Bắt đầu---//
echo'<div class="danhmuc">Chợ Trời OLAVN.MOBI</div>';
echo'
<div class="list1"><img src="http://upnhanh.mobi//thumbs/59d3563e6808c16fd05a246bf7dac78686638754.jpg" alt="vào"/> <a href="raoban.php" titl="Rao bán">Rao bán</a></div>
';
echo'<div class="mo">';
echo'<div class="danhmuc">Gian hàng</div>';
$dem2 = mysql_query("SELECT COUNT(*) FROM `chotroi`");
$dem = mysql_result($dem2);
$req = mysql_query("SELECT * FROM `chotroi`");
while($mondo = mysql_fetch_array($req))
{
echo'<div class="list1">';
if(!empty($mondo['balans']) && empty($mondo['luong']))
{
$gia = '<b>'.$mondo['balans'].'</b> Xu';
}
elseif(!empty($mondo['luong']) && empty($mondo['balans']))
{
$gia = '<b>'.$mondo['luong'].'</b> Lượng';
}
else
{
$gia = '<b>'.$mondo['balans'].'</b> xu và <b>'.$mondo['luong'].'</b> Lượng';
}
echo'
<table cellpadding="0" cellspacing="0" width="100%">
<tbody><tr><td width="50">
<img src="/images/'.$mondo['loai'].'/'.$mondo['id_loai'].'.png" alt="'.$mondo['tenvatpham'].'"/>
</td><td width="auto" valign="top"><b>[ <span style="color: green">'.$mondo['tenvatpham'].'</span> ]</b><br/>
Giá: '.$gia.'<br/>
Thông tin: '.$mondo['thongtin'].'<br/>
Người bán: <font color="#1E5B7E">'.$mondo['nguoiban'].'</font><br/><form action="/chotroi/index.php?id='.$mondo['id'].'" method="post">
<input type="submit" name="mua" value="Mua"></form>
</td></tr></tbody></table>
';
               echo'</div> ';
} 

echo'</div>';
if(isset($_POST['mua']))
{
    

    $id = intval($_GET['id']);
    $lay1 = mysql_query("SELECT * FROM `chotroi` WHERE `id` = '$id'");
$lay = mysql_fetch_array($lay1);
$balans = $lay['balans'];
$luong = $lay['luong'];
  if($datauser['balans'] >= $balans && $datauser['luong'] >= $luong)
    {
        if($user_id == $lay['user_id'])
    {
        echo'<div class="list1">Lỗi! Bạn không thể mua của chính bạn!</div>';
    }
        else
        {
    $id_loai = $lay['id_loai'];
    $loai = $lay['loai'];
    $tenvatpham = $lay['tenvatpham'];
    $type = $lay['type'];
    $tangsucmanh = $lay['tangsucmanh'];
    $tanghp = $lay['hp'];
    $soluong = $lay['soluong'];
    $iduser = $lay['user_id'];
    $balans = $lay['balans'];
    $luong = $lay['luong'];
    
//mysql_query("INSERT INTO `khodo` SET `name`='".$id_loai."',`loaisp`='".$loai."',`id_user`='".$user_id."',`giamua`='".$balans."',`giaban`='0',`sucmanh`='".$tangsucmanh."'");
	
mysql_query("INSERT INTO `khodo` (`name` , `loaisp`, `id_user`, `sucmanh`, `giaban`) VALUES  
('$lay[id_loai]', '$lay[loai]', '".$user_id."' , '$lay[tangsucmanh]','$lay[giaban]') ");	
	
/* mysql_query("INSERT INTO `khodo` (
`name` , 
`loaisp`, 
`id_user`, 
`giamua`, 
`giaban`, 
`sucmanh`)

 VALUES  (
'".$id_loai."', 
'".$loai."', 
'".$user_id."', 
'".$balans."',
'0',
'".$tangsucmanh."') "); */


mysql_query("UPDATE `users` SET `balans` = `balans` - $balans WHERE `id` = '$user_id'");
mysql_query("UPDATE `users` SET `luong` = `luong` - $luong WHERE `id` = '$user_id'");
mysql_query("UPDATE `users` SET `balans` = `balans` + $balans WHERE `id` = '$iduser'");
mysql_query("UPDATE `users` SET `luong` = `luong` + $luong WHERE `id` = '$iduser'");

if($loai == canh)
{ mysql_query("UPDATE `users` SET `canh` = '0' WHERE `id` = '$iduser'");}
if($loai == thucung)
{ mysql_query("UPDATE `users` SET `thucung` = '0' WHERE `id` = '$iduser'");}
if($loai == toc)
{ mysql_query("UPDATE `users` SET `toc` = '0' WHERE `id` = '$iduser'");}
if($loai == ao)
{ mysql_query("UPDATE `users` SET `ao` = '0' WHERE `id` = '$iduser'");}
if($loai == quan)
{ mysql_query("UPDATE `users` SET `quan` = '0' WHERE `id` = '$iduser'");}
if($loai == non)
{ mysql_query("UPDATE `users` SET `non` = '0' WHERE `id` = '$iduser'");}
if($loai == mat)
{ mysql_query("UPDATE `users` SET `mat` = '0' WHERE `id` = '$iduser'");}
if($loai == matna)
{ mysql_query("UPDATE `users` SET `matna` = '0' WHERE `id` = '$iduser'");}
if($loai == kinh)
{ mysql_query("UPDATE `users` SET `kinh` = '0' WHERE `id` = '$iduser'");}
if($loai == khuonmat)
{ mysql_query("UPDATE `users` SET `khuonmat` = '0' WHERE `id` = '$iduser'");}
if($loai == haoquang)
{ mysql_query("UPDATE `users` SET `haoquang` = '0' WHERE `id` = '$iduser'");}
if($loai == docamtay)
{ mysql_query("UPDATE `users` SET `docamtay` = '0' WHERE `id` = '$iduser'");}



mysql_query("DELETE FROM `khodo` WHERE `loaisp` = '$loai' AND `name` = '$id_loai' AND `id_user` = '$iduser'");



mysql_query("DELETE FROM `chotroi` WHERE `id` = '$id'");

echo'<style>.mo{display:none}</style>';
echo'<div class="list1">Mua thành công!</div>';
}
}
else
{
    echo'<style>.mo {display:none;}</style>';
    echo'<div class="list1">Bạn không đủ tiền để mua món đồ này</div><div class="list1"><a href="/chotroi" title="Trợ chời OLAVN">Quay Lại</div>';
}

}
//---Kết thúc---//

}

require_once ("../incfiles/end.php");


?>