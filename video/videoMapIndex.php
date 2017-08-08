<?php

/**
 *
 *
 * @version $Id$
 * @copyright Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 */

require_once('../common/configs/config.inc.php');
require_once('../common/configs/config_video.inc.php');
require_once('../common/configs/config_video_player.inc.php');
$CFG['mods']['include_files'][] = 'common/classes/class_FormHandler.lib.php';
$CFG['db']['is_use_db'] = true;
//compulsory
$CFG['auth']['is_authenticate'] = false;
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page']='video';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

class googleSitemapIndex extends FormHandler
{


public function generateSitemapIndex()
{
		$sql='SELECT count(video_id) as count FROM '.
		$this->CFG['db']['tbl']['video'].' WHERE video_status=\'Ok\' AND flagged_status!=\'Yes\' AND video_access_type=\'Public\'';
		$stmt = $this->dbObj->Prepare($sql);
		$rs = $this->dbObj->Execute($stmt, array());
		if (!$rs)
			trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
		$row = $rs->FetchRow();
		$count=$row['count'];
		$totalpage=ceil($count/$this->CFG['admin']['videos']['google_sitemap_videocount']);
		$modified=date('c');
		echo '<?php xml version="1.0" encoding="UTF-8"?>';
?><sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
   <?php for($i=0;$i<$totalpage;$i++)
   {
   	$googleSitemapUrl=$this->CFG['site']['video_url'].'videoMap.php?pg='.$i;
   ?>
   <sitemap>
      <loc><?php echo $googleSitemapUrl;?></loc>
      <lastmod><?php echo $modified;?></lastmod>
   </sitemap>
	<?php }?>
   </sitemapindex>
<?php
}
}$sitemap= new googleSitemapIndex();
$sitemap->setDBObject($db);
$sitemap->generateSitemapIndex();
?>