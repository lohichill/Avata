<?php

/*
 * @package     VinaJohnCMS
 * @link        http://vina4u.pro
 * @copyright   Copyright (C) 2008-2011 VinaJohnCMS Community
 * @author      http://facebook.com/vina4uteam
 */


defined('_IN_JOHNCMS') or die('Error: restricted access');

echo '<br/></div></div></div><div class="maintxt">';


// Рекламный блок сайта
if (!empty($cms_ads[2])) {
    echo '<div class="gmenu">' . $cms_ads[2] . '</div>';
}

echo '</div>';
if (isset($_GET['err']) || $headmod != "mainpage" || ($headmod == 'mainpage' && $act)) {
//echo '<div class="phdr" style="margin-top: 15px;"><a href=\'' . $set['homeurl'] . '\'>' . functions::image('menu_home.png') . $lng['homepage'] . '</a></div>';
}
echo 
    '</div>' .
    '<div class="footer"><div style="text-align:left;padding:5px;">' .
    '<center><p><b><font color="red">' . $set['copyright'] . '</font></b></p>';

// Счетчики каталогов
functions::display_counters();

// Рекламный блок сайта
if (!empty($cms_ads[3])) {
    echo '<br />' . $cms_ads[3];
}

/*
-----------------------------------------------------------------
ВНИМАНИЕ!!!
Данный копирайт нельзя убирать в течение 90 дней с момента установки скриптов
-----------------------------------------------------------------
ATTENTION!!!
The copyright could not be removed within 90 days of installation scripts
-----------------------------------------------------------------
*/
echo '<small>Bản Quyền : <font color="red"><b>ZimCity Team</b></font> - powered by  : <font color="blue"><b>Vina4u</font> <a href="/pages/faq.php?act=forum">(Điều Khoản Sử dụng)
<br/><b>&copy; Phát Triển bởi <a href="/">Tất Cả Thành Viên ZimCity</a></b></small><br><a href="http://duatop.vina4u.biz//counter/domain.php?id=222"><img src="http://duatop.vina4u.biz//img.php?222"/></a></center></div>' .
    '</div></body></html>';