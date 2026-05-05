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
        $stmt = $conn->prepare("SELECT * FROM `guest` WHERE `user_id` = ? ORDER BY `time` DESC");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $res = $result->fetch_array();
        if ($res['text'] == $msg) {
            exit;
        }
    }
    if (!$error) {
        include '/guestbook/thayphan.php';
        include '/guestbook/botavatar.php';
        include '/guestbook/showinfo.php';
        include '/guestbook/admin.php';

        $stmt = $conn->prepare("INSERT INTO `guest` SET
             `adm` = ?,
             `time` = ?,
             `user_id` = ?,
             `name` = ?,
             `text` = ?,
             `ip` = ?,
             `browser` = ?
        ");
        $time = time();
        $stmt->bind_param("isisisss", $admset, $time, $user_id, $from, $msg, core::$ip, $agn);
        $stmt->execute();
        
        if ($user_id) {
            $postguest = $datauser['postguest'] + 1;
            $time = time();
            $stmt = $conn->prepare("UPDATE `users` SET `postguest` = ?, `lastpost` = ? WHERE `id` = ?");
            $stmt->bind_param("iii", $postguest, $time, $user_id);
            $stmt->execute();
        }
    }
}

$stmt = $conn->prepare("SELECT COUNT(*) FROM `guest` WHERE `adm`='0'");
$stmt->execute();
$result = $stmt->get_result();
$total = $result->fetch_row()[0];

if ($total) {
    $limit = !$is_mobile ? 6 : 6;
    $stmt = $conn->prepare("SELECT `guest`.*, `guest`.`id` AS `gid`, `users`.`lastdate`, `users`.`id`, `users`.`rights`, `users`.`name`
                FROM `guest` LEFT JOIN `users` ON `guest`.`user_id` = `users`.`id`
                WHERE `guest`.`adm`='0' ORDER BY `time` DESC LIMIT ?");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $req = $stmt->get_result();
    
    echo '<div class="forumtext">';
    $i = 0;
    while ($gres = $req->fetch_assoc()) {
        $post = $gres['text'];
        $post = functions::checkout($gres['text'], 1, 1);
        if ($set_user['smileys'])
            $post = functions::smileys($post, $gres['rights'] ? 1 : 0);

        echo'<table cellpadding="0" cellspacing="0" width="100%" border="0" style="table-layout:fixed;word-wrap: break-word;">
<tr><td width="50px;" class="blog-avatar">';
        if (file_exists(($rootpath.'files/users/avatar/'.$gres['id'].'.gif'))) {
            echo '<img src="../avatar/'.$gres['id'].'.gif" width="45" height="43" alt="'.$gres['name'].'"/>';
        }
        else {
            echo '<img src="../avatar/'.$gres['id'].'.png" width="45" height="43" alt="'.$gres['name'].'"/>';
        }

        $user_rights = array(
            0 => '<span style="color:black"> (Thành Viên) </span>',
            2 => '<span style="color:green"> (Trial Mod) </span>',
            3 => '<span style="color:green"> (Moder) </span>',
            4 => '<span style="color:blue"> (Police) </span>',
            5 => '<span style="color:blue"> (Trial Smod) </span>',
            6 => '<span style="color:blue"> (SModer) </span>',
            7 => '<span style="color:red"> (Administrator) </span>',
            9 => '<span style="color:red"> (Sáng lập Viên) </span>'
        );
        
        echo'</td><td style="vertical-align: bottom;"><table cellpadding="0" cellspacing="0" style="margin-bottom:5px"><tbody>
<tr><td class="current-blog" rowspan="2" style=""><div class="blog-bg-left">';
        echo'<img src="/theme/HoangThuan/images/left-blog.png"></div>';

        // Get clan info with prepared statement
        $stmt = $conn->prepare("SELECT COUNT(*) FROM `nhom_user` WHERE `duyet`='1' AND `user_id`=?");
        $stmt->bind_param("i", $gres['id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $cclan = $result->fetch_row()[0];
        
        $clan = '';
        if ($cclan) {
            $stmt = $conn->prepare("SELECT * FROM `nhom_user` WHERE `user_id`=?");
            $stmt->bind_param("i", $gres['id']);
            $stmt->execute();
            $ss = $stmt->get_result()->fetch_array();
            
            $stmt = $conn->prepare("SELECT * FROM `nhom` WHERE `id`=?");
            $stmt->bind_param("i", $ss['id']);
            $stmt->execute();
            $nhom = $stmt->get_result()->fetch_array();
            if ($nhom) {
                $clan = '<img src="/images/clan/'.$nhom['icon'].'.png">';
            }
        }

        $online_status = (time() > ($gres['lastdate'] ?? 0) + 300) 
            ? ' <img style="vertical-align:middle;" title="' . htmlspecialchars($gres['name']) . ' is offline" src="/images/offline.png" alt="offline"/> ' 
            : '<img style="vertical-align:middle;" title="' . htmlspecialchars($gres['name']) . ' is online" src="/images/online.png" alt="online"/> ';
        
        echo $online_status . 
             '<a href="/users/'.$gres['id'].'.html"><b><span style="color:003366">'.nick($gres['id']).'</span></b></a><b style="font-size:12px">'.$user_rights[$gres['rights']].'</b>';
        echo'<div class="text">';
        echo ''.$post.'<br/><br/>';
        echo'</div></td></tr></tbody></table></td></tr></table>';

        ++$i;
    }
    echo $outputhtml;
    echo '</div>';
}

?>