<?php
/**
 * This file is to read the database for autocompletion and write in xml the data
 *
 *
 * @category	rayzz
 * @package		Index
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 *
 **/
$called_from_cron = true;
require_once(dirname(dirname(__FILE__)).'/common/configs/config.inc.php');
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
require($CFG['site']['project_path'].'common/application_top.inc.php');
set_time_limit(0);
//$CFG['autocomplete_xml']['general']['userhometown'] = 'files/autocompletexml/user_hometown.xml';
//$CFG['autocomplete_xml']['general']['usercity'] = 'files/autocompletexml/user_city.xml';

class AutoCompleteXmlDataGenarator extends FormHandler
	{
		/**
		 * AutoCompleteXmlDataGenarator::writeDataListForUserHomeTown()
		 * writes the xml data used for auto completion of hometown
		 * xml file: files/autocompletexml/user_hometown.xml
		 * sample xml format:
		 * <xml>
		 * <hometown>
		 * <userhometown>
		 * <name>Tuticorin</name>
		 * <total_count>1</total_count>
		 * </userhometown>
		 * </hometown>
		 * </xml>
		 *
		 * @return
		 */
		public function writeDataListForUserHomeTown()
			{
				$sql = 'SELECT count(hometown) as tot_count, hometown FROM '.
						 $this->CFG['db']['tbl']['users'].
					   ' WHERE usr_status = \'Ok\' AND hometown != \'\' GROUP BY hometown ORDER BY tot_count';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_db_error($this->dbObj);
$str = <<<CONT
<?xml version ="1.0"  encoding ="UTF-8"?>
<xml>
<hometown>

CONT;
				while($row = $rs->FetchRow())
					{
						$hometown_name = $row['hometown'].' ('.$row['tot_count'].')';
$str .= <<<CONT1
<userhometown>
<name>{$row['hometown']}</name>
<total_count>{$row['tot_count']}</total_count>
</userhometown>

CONT1;
					}
$str .= <<<CONT2
</hometown>
</xml>
CONT2;
				if ($handle = fopen('../'.$this->CFG['autocomplete_xml']['general']['userhometown'], 'wb'))
		 			{
		 				fwrite($handle, $str);
		 				fclose($handle);
		 				return true;
		 			}
		 		else
				 	{
				 		echo 'Cannot write to file';
					}
			}
				/**
		 * AutoCompleteXmlDataGenarator::writeDataListForUserHomeTown()
		 * writes the xml data used for auto completion of hometown
		 * xml file: files/autocompletexml/user_hometown.xml
		 * sample xml format:
		 * <xml>
		 * <hometown>
		 * <userhometown>
		 * <name>Tuticorin</name>
		 * <total_count>1</total_count>
		 * </userhometown>
		 * </hometown>
		 * </xml>
		 *
		 * @return
		 */
		public function writeDataListForUserCity()
			{
				$sql = 'SELECT count(city) as tot_count, city FROM '.
						 $this->CFG['db']['tbl']['users'].
					   ' WHERE usr_status = \'Ok\' AND city != \'\' GROUP BY city ORDER BY tot_count';
				$stmt = $this->dbObj->Prepare($sql);
				$rs = $this->dbObj->Execute($stmt, array());
				if (!$rs)
					trigger_error($this->dbObj->ErrorNo().' '.$this->dbObj->ErrorMsg(), E_USER_ERROR);
$str = <<<CONT
<?xml version ="1.0"  encoding ="UTF-8"?>
<xml>
<city>

CONT;
				while($row = $rs->FetchRow())
					{
						$hometown_name = $row['city'].' ('.$row['city'].')';
$str .= <<<CONT1
<usercity>
<name>{$row['city']}</name>
<total_count>{$row['tot_count']}</total_count>
</usercity>

CONT1;
					}
$str .= <<<CONT2
</city>
</xml>
CONT2;
				if ($handle = fopen('../'.$this->CFG['autocomplete_xml']['general']['usercity'], 'wb'))
		 			{
		 				fwrite($handle, $str);
		 				fclose($handle);
		 				return true;
		 			}
		 		else
				 	{
				 		echo 'Cannot write to file';
					}
			}

	}
$xml_gen_cron  = new AutoCompleteXmlDataGenarator();
callMultipleCronCheck();
$xml_gen_cron->writeDataListForUserHomeTown();
$xml_gen_cron->writeDataListForUserCity();
?>