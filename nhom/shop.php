<?php
define('_IN_JOHNCMS',1);     
include('../incfiles/core.php'); 
$textl='Shop Bang hội'; 
include('../incfiles/head.php'); 
echo'<div class="phdr">Shop Bang Hội ';
if($datauser['rights']>=9 or $user_id==4)
    echo' ||<a href="../panel/clan.php?act=set">Vật phẩm chưa đặt giá</a>||<a href="/panel/themitemclanmxhsieuzuiv.php">Thêm Item Clan</a>'; 
echo'</div>'; 
$sql=mysql_query("select * from `nhom` where `user_id`='".$user_id."' limit 1")or die( mysql_error());
if(!mysql_num_rows($sql)){ 
    echo functions::display_error('Bạn không phải là bang chủ của bất cứ bang nào');
    include('../incfiles/end.php'); 
    include($_SERVER['DOCUMENT_ROOT'].'logfile.php');
exit;
} 
$clan=mysql_fetch_array($sql); 
switch($_GET['act']){ 
    case 'buy': 
        if(!$_POST['submit']){ 
            echo'<div class="menu"><p>Bạn chắc chắn muốn mua vật phẩm này không?</p><p align="center"><form method="post"><input type="submit" value="Xác nhận" name="submit"></form></div>'; 
            include('../incfiles/end.php'); 
            include($_SERVER['DOCUMENT_ROOT'].'logfile.php');
exit;
} 
        $id=intval($_GET['id']); 
        $sql1=mysql_query("select * from `shop_clan` where `id`='$id' limit 1")or die( mysql_error());
        if(!mysql_num_rows($sql1)){ 
            echo functions::display_error('Không tìm thấy vật phẩm này!');
            include('../incfiles/end.php'); 
            include($_SERVER['DOCUMENT_ROOT'].'logfile.php');
exit;
} 
        $vp=mysql_fetch_array($sql1); 
        if(($clan['balans']<$vp['balans']) or ($clan['luong']<$vp['luong'])){ 
            echo functions::display_error('Bang hội không đủ quỹ để mua vật phẩm này');
            include('../incfiles/end.php'); 
            include($_SERVER['DOCUMENT_ROOT'].'logfile.php');
exit;
} 
        $balans=$clan['balans']-$vp['balans']; 
        $luong=$clan['luong']-$vp['luong'];
        mysql_query("update `nhom` set `balans`='$balans',`luong`='$luong' where `id` = '$id'  limit 1")or die(mysql_error());
        mysql_query("insert into `clan_kho` set `clan`='".$clan['id']."',`vp`='".$id."'")or die( mysql_error());
        echo'<div class="label-success">Mua Thành công!!</div>'; 
    break; 
    default: 
        $tong=mysql_num_rows(mysql_query("select `id` from `shop_clan` where `balans`!='0' or `luong`!='0'"));
        if(!$tong){ 
            echo functions::display_error('Shop Bang hội hiện không có vật phẩm nào');
            include('../incfiles/end.php'); 
            include($_SERVER['DOCUMENT_ROOT'].'logfile.php');
exit;
} 
        $sql2=mysql_query("select * from `shop_clan` where `balans`!='0' or `luong`!='0' limit $start,$kmess")or die( mysql_error());
        while($a=mysql_fetch_array($sql2)){ 
            echo'<div class="list1">'; 
            echo'<p><img src="'.$home.'/images/'.$a['loai'].'/'.$a['vp'].'.png"> '.$a['name'].'</p>';
            echo'<p>Giá: '.$a['balans'].' balans và '.$a['luong'].' lượng</p>'; 
            echo'<p><a href="shop.php?act=buy&id='.$a['id'].'"><button>Mua ngay</button></a>'; 
            echo'</div>'; 
        } 
        if($tong>$kmess) 
            echo '<div class="menu">'.functions::display_pagination('shop.php?page=',$tong,$start,$kmess).'</div>'; 
    break; 
} 
include('../incfiles/end.php'); 
?>
<?php 
include($_SERVER['DOCUMENT_ROOT'].'/logfile.php');
////// Vipgun98s2 - writed
?>