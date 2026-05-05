<?php
define('_IN_JOHNCMS', 1);
$rootpath = '';
require('incfiles/core.php');
if (isset($_POST['msg'])) {
   $msg = isset($_POST['msg']) ? mb_substr(trim($_POST['msg']), 0, 10000) : '';
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
       include '/guestbook/admin.php';

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
                    WHERE `guest`.`adm`='0' ORDER BY `time` DESC LIMIT ".(!$is_mobile ? 6 : 6)."");
echo '<div class="forumtext">';
        while ($gres = mysql_fetch_assoc($req)) {
        $post = $gres['text'];
        $post = functions::checkout($gres['text'], 1, 1);
        if ($set_user['smileys'])
          $post = functions::smileys($post, $gres['rights'] ? 1 : 0);

echo'<table cellpadding="0" cellspacing="0" width="100%" border="0" style="table-layout:fixed;word-wrap: break-word;">
<tr><td width="50px;" class="blog-avatar">';
if (file_exists(($rootpath.'files/users/avatar/'.$gres['id'].'.gif'))) {
echo '<img src="../avatar/'.$gres['id'].'.gif" width="45" height="43" alt="'.$gres['name'].'"/>';
}
else
{
echo '<img src="../avatar/'.$gres['id'].'.png" width="45" height="43" alt="'.$gres['name'].'"/>';
}

$user_rights = array(
0 => '<font color="black"> (Thành Viên) </font>',
2 => '<font color="green"> (Trial Mod) </font>',
3 => '<font color="green"> (Moder) </font>',
4 => '<font color="blue"> (Police) </font>',
5 => '<font color="blue"> (Trial Smod) </font>',
6 => '<font color="blue"> (SModer) </font>',
7 => '<font color="red"> (Administrator) </font>',
9 => '<font color="red"> (Sáng lập Viên) </font>'
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
echo'</div></td></tr></tbody></table></td></tr></table>';

          ++$i;
        }
      echo $outputhtml;
echo '</div>';
  }

?>