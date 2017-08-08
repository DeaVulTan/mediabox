<?php
require_once('../common/configs/config.inc.php');
$CFG['html']['is_use_header'] = false;
$CFG['auth']['is_authenticate'] = false;
require_once($CFG['site']['project_path'].'common/configs/config_video_player.inc.php');
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
require_once($CFG['site']['project_path'].'video/general/embedUrl.php');

?>