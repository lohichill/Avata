<?php

/*
 * @package     VinaJohnCMS
 * @link        http://vina4u.pro
 * @copyright   Copyright (C) 2008-2011 VinaJohnCMS Community
 * @author      http://facebook.com/vina4uteam
 */

defined('_IN_JOHNCMS') or die('Error: restricted access');

$mp = new mainpage();



/*
-----------------------------------------------------------------
Блок общения
-----------------------------------------------------------------
*/
echo '<div class="homeforum"><div class="icon-home"><div class="home">Diễn Đàn Giải Trí ZimCity</div></div></div>';

if(!$user_id){

echo '<div class="phdr" style="text-align:center;">CHÀO MỪNG BẠN ĐẾN VỚI THIÊN ĐƯỜNG GIẢI TRÍ ZimCity</div>
<div class="tmn">
<center><b><img src="/images/sv.gif"> Cùng tham gia để có những giây phút giải trí thú vị nhé </b><img src="/images/sv.gif"></center>
<br><img src="/images/sv.gif"><b><font color="green"> ZimCity.US </font> với nhiều chức năng hấp dẫn:</b>
<br>- Hệ thống forum, chatbox, tin nhắn, kết hôn, kết bạn. Giúp bạn kết nối với thành viên khác dễ dàng
<br>- Hệ thống game mini đa dạng, phong phú: Nông Trại Online, Quay Số, Nâng Cấp, Đấu Boss,...
<br>- Hệ thống đồ họa phong phú, liên tục cập nhật item, vật phẩm mới lạ. Giúp bạn thỏa sức làm đẹp cho nhân vật của mình
<br>
<br>
<b><center>Còn chờ gì nữa. Hãy <a href="dangnhap.html">Đăng Nhập</a> hoặc <a href="/dangki.html">Đăng Kí</a> ngay để cùng trải nghiệm đầy đủ chức năng của mạng xã hội nhé :)</center></b>
</div>';

$rantoken =rand(000000,999999);
$_SESSION[token] = $rantoken;
echo '<div class="phdr">Đăng Nhập Tài Khoản</div>';
echo '<div class="gioithieu" align="center"><form action="/login.php" method="post">
<marquee behavior="scroll" direction="left" scrollamount="5" style="margin-top: 5px"><img src="/images/may1.png"></marquee>
<marquee behavior="scroll" direction="left" scrollamount="7" style="margin-top: 10px"><img src="/images/may2.png"></marquee>
Tài Khoản : 
<br/>
<input
type="text" name="n"
value="" maxlength="28"
size="25" class="name">
<br/>
Mật Khẩu : 
<br/>
<input type="password"
name="p" maxlength="25"
size="25" class="pass">
<br/>
<input
type="hidden" name="mem"
value="1"
checked="checked"><input type="hidden" name="next" value="'.$url.'" />
<input type="hidden" name="token" value="'.$_SESSION[token].'"/>
<font style="font-size="11px"><a href="/users/skl.php?continue" title="Quên mật khẩu">Bạn Quên Mật Khẩu?</a></font><br/>
<input type="submit" value="&#160;Đăng nhập&#160;"/>
<a href="/registration.php" id="submit" style="padding:4px 15px" title="Đăng kí làm thành viên"><b>Đăng kí nhanh</b></a>
</form></div>';

echo '<div class="tmn">
<b> Mạng Xã Hội ZimCity Hỗ Trợ Đa Nền Tảng Điện Thoại. </b>
<br><i class="fa fa-bullhorn"></i> Các Máy Yếu Vẫn Có Thể Chơi Game Mượt Mà Khi Chuyển Sang Giao Diện JaVa 
<br><i class="fa fa-bullhorn"></i> Tuy Nhiên , Các Bạn Dùng SmartPhone Cũng Có Thể Chuyển Sang Giao Diện SmartPhone 
<br><i class="fa fa-bullhorn"></i> Tham Gia vào Mạng xã hội Để Trải Nghiệm Tối Đa Hiệu Ứng Tuyệt Đẹp của Chúng tôi.
</div>';
}



if($user_id){

echo '<div class="menuvi"><i class="fa fa-home"></i> Trung Tâm Thành Phố </div>';

echo '<div class="trungtam"><center>
<div style="height: 210px; text-align: center; margin: auto;">
<span style="width:30%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/shop/"><img src="/images/khumuasam.png" width="30px" alt="icon"/><br><b>Khu Mua Sắm</b></a>
</span>
<span style="width:40%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/sanbay"><img src="/images/sanbay.png" width="30px" alt="icon"/><br><b>Sân Bay</b></a>
</span>
<span style="width:30%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/nongtrai"><img src="/images/nongtrai.png" width="30px" alt="icon"/><br><b>Nông Trại</b></a><br/>
</span>


<span style="width:30%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/cauca"><img src="/images/khu-sinh-thai-1.png" width="30px" alt="icon"/><br><b>Khu Sinh Thái</b></a>
</span>
<span style="width:40%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/dautruong/dautruong.php"><img src="/images/dautruong.png" width="30px" alt="icon"/><br><b>Đấu Trường</b></a>
</span>
<span style="width:30%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/giaitri"><img src="/images/giaitri.png" width="30px" alt="icon"/><br><b>Khu Giải Trí</b></a>
</span>

<span style="width:30%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/dautruong/boss/"><img src="/images/boss.png" width="30px" alt="icon"/><br><b>Đánh BOSS</b></a>
</span>
<span style="width:40%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/napthe"><img src="/images/atm.png" width="30px" alt="icon"/><br><b>Trạm ATM</b></a>
</span>
<span style="width:30%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/rongthieng"><img src="/images/rongthan.png" width="30px" alt="icon"/><br><b>Rồng Thiêng</b></a>
</span>


<span style="width:30%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/ranking/rank.php"><img src="/images/rank.png" width="30px" alt="icon"/><br><b>Đấu Ranks</b></a>
</span>
<span style="width:40%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/duathu"><img src="/images/duathu.png" width="30px" alt="icon"/><br><b>Đua Thú</b></a>
</span>
<span style="width:30%;text-align:center;padding:4px; float: left; font-size: 10px;">
<a href="/share"><img src="/images/gt.png" width="30px" alt="icon"/><br><b>Mời Bạn Bè</b></a>
</span>



</div></center></div>';


echo '<div class="menuvi"><i class="fa fa-home"></i> Chia Sẻ Bạn Bè </div>';
echo '<div class="next"><i class="fa fa-cart-plus"></i> <a href="/store"> Cửa Hàng Mua Sắm Store Chức Năng </a></div>';
echo '<div class="next"><i class="fa fa-pencil"></i> <a href="/mod/olaicon.php"> Cửa Hàng Mua iCon Trước NickName </a></div>';



echo '<div class="phdr"><a href="/news">Tin Tức - ADS</a></div>';
echo $mp->news;

/// Modules Phong Chat ///


//--Phòng Chát--//
echo '<div class="phdr">• <a href="/guestbook/index.php"><b>Trò Chuyện</b></a> • <a href="/guestbook/index.php?
act=clean">[Dọn dẹp]</a></div>';
if($user_id){
$refer = base64_encode($_SERVER['REQUEST_URI']);
$token = mt_rand(1000, 100000);
$_SESSION['token'] = $token;
echo '<div class="list2"><form name="shoutbox" id="shoutbox" action="/guestbook/index.php?act=say" method="post">'.bbcode::auto_bb('shoutbox', 'msg').'<textarea placeholder="Vui lòng viết tiếng việt có dấu để tôn trọng người đọc" id="msg" name="msg"></textarea><input type="hidden" name="ref" value="'.$refer.'"/><input type="hidden" name="token" value="'.$token.'"><br /><input type="submit" name="submit" value="' . $lng['sent'] . '"></form></div>';
} else {
echo '<div class="rmenu">Bạn Cần <a href="/dang-nhap.html"> Đăng nhập </a> để chém gió nhé</div>';
}
echo '<div id="datachat"></div>';

//--Kết thúc Phòng Chát//

/* 
echo '<div class="phdr">• <a href="/guestbook/index.php"><b>Trò Chuyện</b></a> • <a href="/guestbook/index.php?
act=clean">[Dọn dẹp]</a></div>';
if($user_id){
$refer = base64_encode($_SERVER['REQUEST_URI']);
$token = mt_rand(1000, 10000);
$_SESSION['token'] = $token;
echo '<div class="list2"><form name="shoutbox" id="shoutbox" action="/guestbook/index.php?act=say" method="post">'.bbcode::auto_bb('shoutbox', 'msg').'
<textarea rows="3" placeholder="Vui lòng viết tiếng việt có dấu để Tôn trọng người đọc!" id="msg" name="msg">
</textarea><input type="hidden" name="ref" value="'.$refer.'"/>
<input type="hidden" name="token" value="'.$token.'"><br />
<input type="submit" name="submit" value="Bình Luận"><a id="submit" style="padding:5px 10px" href="/">Tải Lại</a></form>
 
</div>
';
} else {
echo '<div class="gmenu">Bạn Cần <a href="/login.php"> Đăng nhập </a> để chém gió. Còn chưa có thì hãy <a href="/registration.php"> Đăng kí </a> để gia nhập OLA nhé!</div>';
}

if (isset($_POST['msg'])) {
   $msg = isset($_POST['msg']) ? mb_substr(trim($_POST['msg']), 0, 5000) : '';
   $flood = functions::antiflood();
   if ($ban['1'] || $ban['13'])
       $error[] = $lng['access_forbidden'];
   if ($flood)
       $error = $lng['error_flood'] . ' ' . $flood . '&#160;' . $lng['seconds'];
   if (!$error) {
       $req = mysql_query("SELECT * FROM `guest` WHERE `user_id` = '$user_id' ORDER BY `time` DESC");
       $res = mysql_fetch_array($req);
       if ($res['text'] == $msg) {
           exit;
       }
   }
   if (!$error) {

       include '/guestbook/thayphan.php';
       include '/guestbook/botavatar.php';
       include '/guestbook/showinfo.php';

       mysql_query("INSERT INTO `guest` SET
            `adm` = '$admset',
            `time` = '" . time() . "',
            `user_id` = '$user_id',
            `name` = '$from',
            `text` = '" . mysql_real_escape_string($msg) . "',
            `ip` = '" . core::$ip . "',
            `browser` = '" . mysql_real_escape_string($agn) . "'
       ");
       if ($user_id) {
          $postguest = $datauser['postguest'] + 1;
          mysql_query("UPDATE `users` SET `postguest` = '$postguest', `lastpost` = '" . time() . "' WHERE `id` = '$user_id'");
       }
   }
}
$total = mysql_result(mysql_query("SELECT COUNT(*) FROM `guest` WHERE `adm`='0'"), 0);
  if ($total) {
        $req = mysql_query("SELECT `guest`.*, `guest`.`id` AS `gid`, `users`.`lastdate`, `users`.`id`, `users`.`rights`, `users`.`name`
                    FROM `guest` LEFT JOIN `users` ON `guest`.`user_id` = `users`.`id`
                    WHERE `guest`.`adm`='0' ORDER BY `time` DESC LIMIT ".(!$is_mobile ? 10 : 10)."");
echo '<div class="forumtext">';
        while ($gres = mysql_fetch_assoc($req)) {
        $post = $gres['text'];
        $post = functions::checkout($gres['text'], 1, 1);
        if ($set_user['smileys'])
          $post = functions::smileys($post, $gres['rights'] ? 1 : 0);

echo'<table cellpadding="0" cellspacing="0" width="99%" border="0" style="table-layout:fixed;word-wrap: break-word;">
<tr><td width="50px;" class="blog-avatar">';
if (file_exists(($rootpath.'files/users/avatar/'.$gres['id'].'.gif'))) {
echo '<img src="../avatar/'.$gres['id'].'.gif" width="45" height="45" alt="'.$gres['name'].'"/>';
}
else
{
echo '<img src="../avatar/'.$gres['id'].'.png" width="45" height="45" alt="'.$gres['name'].'"/>';
}

$user_rights = array(
0 => '<font color="black"> (Thành Viên) </font>',
2 => '<font color="green"> (Trial Mod) </font>',
3 => '<font color="green"> (Moder) </font>',
4 => '<font color="blue"> (Police) </font>',
5 => '<font color="blue"> (Trial Smod) </font>',
6 => '<font color="blue"> (SModer) </font>',
7 => '<font color="red"> (Administrator) </font>',
9 => '<font color="red"> (Sáng lập Viên!) </font>'
);
echo'</td><td style="vertical-align: bottom;"><table cellpadding="0" cellspacing="0" style="margin-bottom:5px"><tbody>
<tr><td class="current-blog" rowspan="2" style=""><div class="blog-bg-left">';
echo'<img src="/theme/HoangThuan/images/left-blog.png"></div>';


$cclan=mysql_num_rows(mysql_query("SELECT * FROM `nhom_user` WHERE `duyet`='1' AND `user_id`='".$gres[id]."'"));
if ($cclan) {
$ss=mysql_fetch_array(mysql_query("SELECT * FROM `nhom_user` WHERE `user_id`='".$gres[id]."'"));
$nhom=mysql_fetch_array(mysql_query("SELECT * FROM `nhom` WHERE `id`='".$ss[id]."'"));
$clan='<img src="/images/clan/'.$nhom[icon].'.png">';
} else {
$clan='';
}

echo(time() > $gres['lastdate'] + 300 ? ' <img style="vertical-align:middle;" title="' . $res['from'] . 
' is offline" src="/images/offline.png" alt="offline"/> ' : '<img style="vertical-align:middle;" title="' . $res['from'] . 
' is online" src="/images/online.png" alt="online"/> ') . 
'<a href="/users/'.$gres['id'].'.html"><b><font color="003366">'.nick($gres['id']).'</font></b></a><b style="font-size:12px">'.$user_rights[$gres['rights']].'</b>';
echo'<div class="text">';
echo ''.$post.'<br/><br/>';
//echo '<span style="font-size:11px;color:#777;"> (' . functions::thoigian($gres['time']) . ')</span>'; 
echo'</div></td></tr></tbody></table></td></tr></table>';

          ++$i;
        }
      echo $outputhtml;
echo '</div>';
  }
*/



////////// Mod TOP 10 Topic //////
echo '<div class="menuvi"><i class="fa fa-book"></i> <b>TOP 10 Chủ Đề Mới </b></div>';
$tong = mysql_result(mysql_query("SELECT COUNT(*) FROM `forum` WHERE `type` = 't' and kedit='0' AND `close`!='1'"), 0);
$req = mysql_query("SELECT * FROM `forum` WHERE `type` = 't' and kedit='0' AND `close`!='1' ORDER BY `time` DESC LIMIT $start, $kmess");
while ($arr = mysql_fetch_array($req)) {
$q3 = mysql_query("select `id`, `refid`, `text` from `forum` where type='r' and id='" .$arr['refid'] . "'");
$razd = mysql_fetch_array($q3);
$q4 = mysql_query("select `id`, `refid`, `text` from `forum` where type='f' and id='" .$razd['refid'] . "'");
$frm = mysql_fetch_array($q4);

$trang4 = mysql_query("SELECT * FROM `forum_thank` WHERE `topic` = '" . ($arr['id'] + 1) . "'");
$trang5 = mysql_num_rows($trang4);

$nikuser = mysql_query("SELECT `from`,`id`, `time` FROM `forum` WHERE `type` = 'm' AND `close` != '1' AND `refid` = '" . $arr['id'] . "'ORDER BY time DESC");
$colmes1 = mysql_num_rows($nikuser);
$cpg = ceil($colmes1 / $kmess);
$nam = mysql_fetch_array($nikuser);

echo is_integer($i / 2) ? '<div class="baiviet1">' : '<div class="baiviet2">';

echo '<img src="/avatar/' . $arr['user_id'] . '.png" width="40" height="40" class="avatar_topic"  alt="' . $res['from'] . '" border="1" />';

echo ' <img src="images/' . ($arr['edit'] == 1 ? 'tz' : 'np') . '.gif" alt=""/> ';
if ($arr['vip'] == 1) echo '<b>';
if ($arr['realid'] == 1)
echo ' <img src="images/rate.gif" alt=""/> ';

echo ' <a href="'.$home.'/forum/' . functions::vinarw($arr['text']) . '_' . $arr['id'] . '.html">' . functions::smileys($arr['text']) . '</a>';
if ($cpg > 1)
echo ' <a href="'.$home.'/forum/' . functions::vinarw($arr['text']) . '_' . $arr['id'] . (!$set_forum['upfp'] && $set_forum['postclip'] ? '_clip_' : '') . ($set_forum['upfp'] ? '' : '_p' . $cpg) . '.html">*>></a>';
if ($trang5 !== 0) echo '<font color="red"> [♥' . $trang5. ']</font>';
if ($arr['vip'] == 1) echo '</b> <img src="/images/hot.gif"/>';
if (!empty ($nam['from'])) {
echo ' <br/><font style="font-size:11px"> Bình luận mới : <b>' . $nam['from']. '</b> - Tổng : ' . $colmes1 . ' Bình Luận';
echo ' </font>';
}
echo '</div>';

$i++;
}
if ($tong > $kmess){echo '<div class="menu">' . functions::display_pagination('index.php?', $start, $tong, $kmess) . '</div>';
}
////////////END//////////////




//-- Chuyên Mục --------//
/*
			
 $req = mysql_query("SELECT * FROM `forum` WHERE `type`='f' ORDER BY `realid`");
        $i = 0;
        while (($res = mysql_fetch_array($req)) !== false) {
echo '<div class="phdr"><i class="fa fa-send"></i> ';
            echo '<a alt="' . $res['text'] . '" title="' . $res['soft'] . '" href="/forum/'.functions::vinarw($res['text']).'_' . $res['id'] . '.html">' . $res['text'] . '</a>';
echo '</div>';
$req1 = mysql_query("SELECT * FROM `forum` WHERE `type`='r' and `refid`='" . $res['id'] . "' ORDER BY `realid`");
        while (($ress = mysql_fetch_array($req1))) {

echo $i % 2 ? '<div class="menuvj">' : '<div class="menuvj">';

echo '
<i class="fa fa-arrow-circle-right" style="color:#3c763d"></i> <a alt="' . $ress['text'] . '" title="' . $ress['text'] . '" href="/forum/'.functions::vinarw($ress['text']).'_' . $ress['id'] . '.html">'.$ress['text'].'</a>';
  if (!empty($ress['soft']))
                echo '<br/><i class="fa fa-hand-o-right" style="color:#3c763d"></i> <span class="gray">' . $ress['soft'] . '</span>';
            echo '</div>';	
}
            ++$i;
        }
	*/	
		
$chuyenmucme=mysql_query("SELECT * FROM `forum` WHERE `type` = 'f'");
while($chuyenmuccon=mysql_fetch_array($chuyenmucme)){
echo'<div class="phdr"><i class="fa fa-cubes"></i> <b>'.$chuyenmuccon['text'].'</font></b></div>';
$goicmc= mysql_query("SELECT * FROM `forum` WHERE `type` = 'r' AND `refid`='".$chuyenmuccon['id']."'");
while($cmc=mysql_fetch_array($goicmc)){
echo $i % 2 ? '<div class="menuvj">' : '<div class="menuvj">';
echo'<i class="fa fa-arrow-circle-right" style="color:#3c763d"></i> <a alt="' . $cmc['text'] . '" title="' . $cmc['text'] . '" href="/forum/'.functions::vinarw($cmc['text']).'_' . $cmc['id'] . '.html"><b>'.$cmc['text'].'</b></a>';
  if (!empty($cmc['soft']))
echo '<br/><i class="fa fa-hand-o-right" style="color:#3c763d"></i> <span class="gray">' . $cmc['soft'] . '</span>';
echo '<div class="sub"></div>';				
        $req=mysql_query("SELECT * FROM `forum` WHERE `type` = 't' and kedit='0' AND `close`!='1' AND `refid`='".$cmc['id']."' ORDER BY `time` DESC LIMIT 3");
        while ($arr = mysql_fetch_array($req)) {
echo'<i class="fa fa-comments"  style="color:#3c763d"></i>';
echo '<a href="'.$home.'/forum/index.php?id='.$arr['id'].'"> '.bbcode::tags($arr['text']). '</a> ';
if(7200 > (time()-$arr['time'])) echo '<img src="/images/new.gif" alt="New" />';
echo '<br/>';
        $i++;
        }
            echo '</div>';
        }
}


}

echo'<div class="phdr"><i class="fa fa-bar-chart"></i> Thống kê Trực Tuyến </div>';
echo'<div class="list2"> Thành viên: <b>' . mysql_result(mysql_query("SELECT COUNT(*) FROM `users`"), 0) . '</b> ,  
Chủ đề: <b>' . mysql_result(mysql_query("SELECT COUNT(*) FROM `forum` WHERE `type` = 't' AND `close` != '1'"), 0) . '</b> , 
Bài viết: <b>' . mysql_result(mysql_query("SELECT COUNT(*) FROM `forum` WHERE `type` = 'm' AND `close` != '1'"), 0) . '</b>
</div>';


////Mod Online////
include('online.php');




?>