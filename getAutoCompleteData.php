<?php
/**
 * This file is to read the xml data for autocompletion and return the data
 *
 *
 * @category	rayzz
 * @package		Index
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 *
 **/
require_once('./common/configs/config.inc.php');
$CFG['mods']['is_include_only']['non_html_header_files'] = true;
require_once($CFG['site']['project_path'].'common/application_top.inc.php');
//$CFG['autocomplete_xml']['general']['userhometown'] = 'files/autocompletexml/user_hometown.xml';
//$CFG['autocomplete_xml']['general']['usercity'] = 'files/autocompletexml/user_city.xml';
class AutoCompleteXmlDataReader extends FormHandler
	{
		/**
		 * AutoCompleteXmlDataReader::readData()
		 *
		 * @param string $autocomplete_field fieldname,need to add function in the same name as
		 *  'getDataListFor'.$autocomplete_field
		 *
		 *
		 * @return void
		 */
		public function readData($autocomplete_field)
			{
				$xml_file_name =  $this->CFG['autocomplete_xml']['general'][$autocomplete_field];
				$tag_name = $autocomplete_field;
				$objDOM = new DOMDocument();
				$objDOM->load($xml_file_name); //make sure path is correct
				$xml_data = $objDOM->getElementsByTagName($autocomplete_field);
				$function_name = 'getDataListFor'.$autocomplete_field;
				$this->$function_name($xml_data);
			}

		/**
		 * AutoCompleteXmlDataReader::getDataListForUserHomeTown()
		 * parses and returns the json encoded format of home town for autosuggestion
		 *
		 *  xml file: files/autocompletexml/user_hometown.xml
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
		 * @param mixed $xml_data
		 * @return void
		 */
		public function getDataListForUserHomeTown($xml_data)
			{
				$data  = array();
				foreach($xml_data as $value)
					{
						$hometown = $value->getElementsByTagName("name");
				    	$name  = $hometown->item(0)->nodeValue;
						$details = $value->getElementsByTagName("total_count");
					    $total  = $details->item(0)->nodeValue;
						$data[] = array('name' => $name,
										'total_count' => $total
									    );
					}
				header("Content-type: application/json");
				echo json_encode($data);
			}

		/**
		 * AutoCompleteXmlDataReader::getDataListForUserCity()
		 * parses and returns the json encoded format of home town for autosuggestion
		 *
		 *  xml file: files/autocompletexml/user_hometown.xml
		 * sample xml format:
		 * <xml>
		 * <city>
		 * <usercity>
		 * <name>Chennai</name>
		 * <total_count>5</total_count>
		 * </usercity>
		 * </city>
		 * </xml>
	 	 *
		 * @param mixed $xml_data
		 * @return void
		 */
		public function getDataListForUserCity($xml_data)
			{
				$data  = array();
				foreach($xml_data as $value)
					{
						$hometown = $value->getElementsByTagName("name");
				    	$name  = $hometown->item(0)->nodeValue;
						$details = $value->getElementsByTagName("total_count");
					    $total  = $details->item(0)->nodeValue;
						$data[] = array('name' => $name,
										'total_count' => $total
									    );
					}
				header("Content-type: application/json");
				echo json_encode($data);
			}
}

$xml_read  = new AutoCompleteXmlDataReader();
$xml_read->setFormField('field', '');
$xml_read->sanitizeFormInputs($_REQUEST);
if($xml_read->getFormField('field'))
	{
		$xml_read->readData($xml_read->getFormField('field'));
	}
?>