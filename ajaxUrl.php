<?php
//Called when session expired informing to login ..
require_once('./common/configs/config.inc.php');
require_once($CFG['site']['project_path'].'languages/'.$CFG['lang']['default'].'/common/common.inc.php');
echo '<span style="border:1px solid #f00;font-weight:bold;display:block;padding:10px;line-height:25px !important;">
      '.$LANG['common_session_expired_msg'].'. <a href="'.$CFG['site']['url'].'login.php" target="_blank">'.$LANG['common_login_msg'].'</a></span>';
?>