<?php
require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video_player.inc.php');
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = false;
$CFG['site']['is_module_page']='video';
require_once($CFG['site']['project_path'].'common/classes/class_YoutubeGrabHandler.lib.php');
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'video/general/embedPlayer.php');

?>