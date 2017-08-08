<?php

/**
 *
 *
 * @version $Id$
 * @copyright 2009
 */
require_once('../../common/configs/config.inc.php');
$CFG['html']['header'] = 'admin/html_header.php';
$CFG['html']['footer'] = 'admin/html_footer.php';
$CFG['mods']['is_include_only']['html_header'] = false;
$CFG['html']['is_use_header'] = false;
$CFG['site']['is_module_page'] = 'photo';
require_once($CFG['site']['project_path'].'common/application_top.inc.php');

$url = 'http' . ((!empty($_SERVER['HTTPS'])) ? 's' : '') . '://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$url = explode('?',$url);
$url = str_replace('admin/photo/flashLicense.php','',$url[0]);

$host = $err_msg = '';
$page_block_show_stat_arr = array();
$page_blocks_arr= array('message_block', 'license_form_block');
$CFG['api_url_site'] =  'http://mugshot.Uzdc.com';
$CFG['api_url_port'] = 80;
$CFG['api_url_license'] = '/flashLicenseApi.php';

function sanitizeFormInputs($request_arr)
	{
			global $san_arr;
			foreach($request_arr as $key=>$val)
				$san_arr[$key] = htmlspecialchars(trim($request_arr[$key]));
	}
function getFormField($key)
	{
		global $san_arr;
		return (isset($san_arr[$key])) ? $san_arr[$key] : '';
	}

function chkIsNotEmpty($field_value, $err_tip='')
	{
				global $san_arr, $err_msg;
				$is_ok = (is_string($field_value)) ?
								($field_value!='') : (!empty($field_value));
				if (!$is_ok)
					$err_msg .= "Enter the value for license key";
				return $is_ok;
	}
function chkIsForThisProduct($field_value, $prod_id)
	{
			global $err_msg;
			$key_parts = explode('-', $field_value);
			$is_ok = true;
			$prod_id_arr = explode(',', $prod_id);
			$licensed_prod_id = (isset($key_parts[2])) ? $key_parts[2] : 0;
			if (!in_array($licensed_prod_id, $prod_id_arr))
				{
					$is_ok = false; // 'wrong_product';
				}
			if (!$is_ok)
				 $err_msg .= "The license key is not for this product";
			return $is_ok;
	}

function setPageBlockNames($block_names_arr=array())
	{
		global $page_block_show_stat_arr;
		//also reset stat
		foreach($block_names_arr as $block_name)
			$page_block_show_stat_arr[$block_name] = false;	//hide all. reset.
	}

function setPageBlockShow($block_name)
	{
		global $page_block_show_stat_arr;
		$page_block_show_stat_arr[$block_name] = true; //show
	}

function setPageBlockHide($block_name)
	{
		$page_block_show_stat_arr[$block_name] = false; //hide
	}

function setAllPageBlocksShow()
	{
		global $page_block_show_stat_arr;
		foreach($page_block_show_stat_arr as $block_name=>$is_show)
			$page_block_show_stat_arr[$block_name] = true; //show
	}

function setAllPageBlocksHide()
	{
		global $page_block_show_stat_arr;
		foreach($page_block_show_stat_arr as $block_name=>$is_show)
			$page_block_show_stat_arr[$block_name] = false; //hide
	}

function isShowPageBlock($block_name)
	{
		global $page_block_show_stat_arr;
		return $page_block_show_stat_arr[$block_name];
	}
function writeLicenseKey($result_arr)
	{
		global $err_msg;
		$license_key = (isset($result_arr[0]) and $result_arr[0]) ? $result_arr[0] : 'License Key';
		$str = (isset($result_arr[1]) and $result_arr[1]) ? $result_arr[1] : 'Enc key';
		$validdata = (isset($result_arr[2]) and $result_arr[2]) ? $result_arr[2] : 'Valid data';
		$verified_date = (isset($result_arr[3]) and $result_arr[3]) ? $result_arr[3] : 'Verified_date';

$str = <<<CONT
<?xml version ="1.0"  encoding ="UTF-8"?>
<xml>
<license_details>
	<license Name='license_key' value='{$license_key}' />
	<license Name='valid_license' value='{$str}' />
	<license Name='validdata' value='{$validdata}' />
	<license Name='verifieddate' value='{$verified_date}' />
</license_details>
</xml>
CONT;
		if ($handle = fopen('./license.xml', 'w'))
		 	{
		 		fwrite($handle, $str);
		 		fclose($handle);
		 		return true;
		 	}
		 $err_msg .= 'Failed: Installer is not able to write the license data file. Check if the folder has write permission or the license.xml has write permission';
		 return false;
	}
function returnErrXML($result_arr)
	{
		global $err_msg;
		$err_msg .= 'Failed: Error returned'.$result_arr[5];
	}

function callCheckValidLicense($license_key, $type)
	{
			//send the licensekey, hostname, type
			global $CFG;
			global $err_msg;
			$host_name = $_SERVER['HTTP_HOST'];
			$host_ip = $_SERVER['SERVER_ADDR'];
			$request = 'license_key='.$license_key.'&action='.$type.'&host='.$host_name.'&host_ip='.$host_ip;
			$request = $CFG['api_url_site'].$CFG['api_url_license'].'?'.$request;
			$ch = curl_init();
			// Set options
			curl_setopt($ch, CURLOPT_URL, $request);
			curl_setopt($ch, CURLOPT_PORT,  $CFG['api_url_port']);
			curl_setopt($ch, CURLOPT_HEADER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_USERAGENT, 'iono (www.olate.co.uk/iono)');
			// Execute
			$content = curl_exec($ch);
			// Close
			curl_close($ch);
			if (!$content)
				{
					$err_msg .= 'Failed: Unable to communicate with Uzdc. Please try again later';
				}

			//$content will be in the form of license_key:enc_key:validdata:verified:is_demo_license:err_no:err_text
			$result_arr = explode('##', $content);
			if($result_arr[4] == 0)
				{
					if(writeLicenseKey($result_arr))
						$err_msg = "";
					setAllPageBlocksHide();
				}
			else
				{
					returnErrXML($result_arr);
				}
	}
function parse_xml()
	{
		global $err_msg;
		//read the xml file
		$xml_path = './license.xml';
		$read_handle = fopen($xml_path, "rb");
		$contents = fread($read_handle, filesize($xml_path));
		fclose($read_handle);
		if(!$sxml=simplexml_load_string($contents))
			{
				$err_msg .= 'Failed in verifying';
				return false;
			}
		else
			{
				$key_name = '';
				foreach($sxml->license_details[0]->children() as $child)
				{
					foreach($child->attributes() as $name => $value)
					{
						if($name == 'Name')
						{
							$key_name = (string)$value;
							$license_arr[$key_name] = '';
						}
						elseif($name == 'value')
						{
							$license_arr[$key_name] = (string)$value;
							$key_name = '';
						}
					}
				}
			}
		return $license_arr['license_key'];
	}
setPageBlockNames($page_blocks_arr);
sanitizeFormInputs($_REQUEST);
setAllPageBlocksHide();
if(isset($_REQUEST['action']))
	{
		if ($san_arr['action'] == 'install')
			{
				//show the form to get the license key
				setPageBlockShow('license_form_block');

			}
		else if($san_arr['action'] == 'verify')
			{
				//parse the xml and get the license key and verify it and again write the xml
				if($license_key = parse_xml()){
						callCheckValidLicense($license_key, 'verify');
					}
				else
					{
						echo $err_msg;
						exit;
					}
			}
	}
if(isset($_POST['submit_lic']) AND ($_POST['submit_lic']))
	{
		//license key is submitted, check if it is not empty and it is for the product it is called from,
		// then call the api with param as install else call as verify
		if (chkIsNotEmpty($san_arr['license_key']) AND chkIsForThisProduct($san_arr['license_key'], $san_arr['prod_id']))
			{
				callCheckValidLicense($san_arr['license_key'], 'verify');
			}
	}
$flashInstaler = new FormHandler();
$flashInstaler->left_navigation_div = 'photoSetting';
$flashInstaler->includeHeader();
?>
<div class="clsContainer">
<h2>Snapshot Component</h2>
<?php
if($err_msg == '' and !isShowPageBlock('license_form_block'))
	{

    ?>
	<div id="selMsgSuccess">
    <?php
		ECHO '<p>SUCCESS</p>';
		$key_parts = explode('-', $_POST['license_key']);
		$demo_lite = '145';
		$full_lite = '143';
		$lite_product_license_id = array(substr(md5($demo_lite), 0, 8),substr(md5($full_lite), 0, 8));

		$demo_pro = '144';
		$full_pro = '142';
		$pro_product_license_id = array(substr(md5($demo_pro), 0, 8),substr(md5($full_pro), 0, 8));

		$version = '';
		if (in_array($key_parts[4], $lite_product_license_id)){
			$version = 'mugshot_lite';
		}elseif(in_array($key_parts[4], $pro_product_license_id)){
			$version = 'mugshot_pro';
		}
?>
		<!--script language="javascript" type="text/javascript">
			window.location = "<?php echo $CFG['site']['url'].'install_MugshotAvatar.php?msg=1&version='.$version; ?>";
        </script-->
	</div>
<?php
		exit;
	}
if($err_msg != '')
	echo '<p>'.$err_msg.'</p>';
if(isShowPageBlock('license_form_block'))
	{
?>
<form method="post" name="license_submit_form" id="license_submit_form" action="<?php echo $_SERVER['PHP_SELF']; ?>" autocomplete="off" >
	<table>
    	<tr>
        	<td colspan="2">
        	<div id="selMsgError">
			 <p>License key for Mugshot lite demo version: 20-3243-114-1251816076-2b24d495</p>
			 <p>License key for Mugshot pro demo version: 20-3244-114-1251816706-0a09c884</p>

             <p>Please note that the above license keys are for demo version only. Please contact Uzdc support to purchase the full version and provide the license key here.</p>
             </div>
             </td>
        </tr>
		<tr>
			<td><label for="license_key">Enter your License Key here</label></td>
			<td><input type="text" name="license_key" class="clsTextBox"  id="license_key" value="" tabIndex="10" /> </td>
		</tr>
		<tr><td></td>
			<td><input type="submit" class="clsSubmitButton" name="submit_lic" id="submit_lic" value="Submit"/></td>
		</tr>
	</table>
	<input type="hidden" name="action" id="action" value="<?php echo $san_arr['action']?>" />
	<input type="hidden" name="prod_id" id="prod_id" value="<?php echo $san_arr['prod_id']?>" />
</form>
</div>
<?php
	}
$flashInstaler->includeFooter();
?>
