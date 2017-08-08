<?php
/**
 * Class file to parse the contents passed
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author 		vasanthi_27ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: class_Parser.lib.php 170 2008-04-02 09:49:23Z vidhya_29ag04 $
 * @since 		2006-01-19
 */
//------------------- Class Parser begins ------------------->>>>>//
/**
 * Class to handle the parsing of doc block to get the tags
 *
 * <b>Class overview</b>
 *
 * This class extracts the documentation blocks for the variables, and extracts
 * the tags in that block and the corresponding variable name and value.
 *
 * <b>Methods overview
 *
 * getPhpdocParagraphs - this is the main method that parses the entire content
 * and returns all the variables parsed in an array in the form of
 * array('name', 'value', 'doc', 'tags') for each section
 *
 * <b>How to use this class</b>
 *
 * Create an object and pass the contents to be parsed to the getPhpdocParagraphs method.
 *
 * <b>Sample code to use the class</b>
 *
 * <pre>
 * parser_obj = new Parser();
 * $config_content = '';
 * $config_content  = file_get_contents('../common/configuration.php');
 * $ret_array = $parser_obj->getPhpdocParagraphs($config_content);
 * </pre>
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author 		vasanthi_27ag04
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-01-19
 */
class Parser
	{
		/**
		 * @var 	array regular expressions to be used for matching the key
		 */
		private $PHP_BASE = array(
									"space"					=> "\s+",
									"space_optional"		=> "\s*",
									"break"					=> "[\n\r]",
									"php_open_long"			=> "<\?php\s", // zend_scanner.l use {WHITESPACE} (space in our case) eighter. Might be slightly faster.
									"php_open_short"		=> "<\?",
									"php_open_asp"			=> "<%",
									"php_open_short_print" 	=> "<\?=",
									"php_open_asp_print"	=> "<%=",
									// do not change the single quotes to double ones
									"label"					=> '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\xzf-\xff]*',
									"use"					=> "(include_once|include|require_once|require)",
									"assignment"			=> "\s*([,=])\s*",
									"boolean"				=> "(true|false)",
									"string"				=> "[^\s]+",
									"string_enclosed"		=> "(['\"])(?:\\\\\\1|[^\\1])*?\\1",
									"int_oct"				=> "[+-]?\s*0[0-7]+",
									"int_hex"				=> "[+-]?\s*0[xX][0-9A-Fa-f]+",
									"float"					=> "[+-]?\s*\d*\.\d+",
									"float_exponent"		=> "[+-]?\s*\d*(?:\.\d+)*[eE][+-]?\d+",
									"number"				=> "[+-]?\s*\d+",
									"array"					=> "array\s*\(",
									"empty_array"			=> "array\s*\(\s*\)\s*"
								);
		/**
		 * @var 	array array of tags used for the variables documentation and their format
		 */
		private $PHPDOC_TAGS = array(
									"@var" => '@var 	(object objectname|type) [$varname]',
									"@todo"	=> '@todo description',
									"@cfg_label"  => '@cfg_label label',
									"@cfg_key" => '@cfg_key label',
									"@cfg_arr_type" => '@cfg_arr_type label',
									"@cfg_arr_key" => '@cfg_arr_key label',
									"@cfg_arr_value" => '@cfg_arr_value label',
									"@cfg_coding" => '@cfg_coding label',
									"@cfg_is_password" => '@cfg_is_password boolean',
									"@cfg_sub_head" => '@cfg_sub_head label',
									"@cfg_sec_name" => '@cfg_sec_name label',
									"@cfg_section"	=> '@cfg_section label'
									);

		/**
		 * To get the array of name, value, doc, tags for the variables under each section
		 *
		 * @param		string $phpcode contents to parse
		 * @return 		array array of name, value, doc, tags for the variables under each section
		 * @access		public
		 */
		public function getPhpdocParagraphs($phpcode)
			{
				$start = 0;
				//Variable to store the previous config section
				//It is used when the config_section tag is not present in doc block
				$prev_config_section = '';
				$paragraphs	= array("variables"	=> array());
				while (true)
					{
						$start = strpos($phpcode, "/**", $start);
						if (0==(int)$start && "integer" != gettype($start) )
							break;
					    $end = strpos($phpcode, "*/", $start);
				  		$remaining = trim(substr($phpcode, $end+2));
						$var_name = '';
						$var_value = '';
						$var_name = trim(substr($remaining, strpos($remaining, '$CFG'), strpos($remaining, '=')));
						$var_value = trim(substr($remaining, strpos($remaining, '=')+1, (strpos($remaining, ';') - strpos($remaining, '='))-1 ));
						$doc = $this->extractPhpdoc(substr($phpcode, $start+3, ($end-$start)-2));
						$tags = $this->getTags($doc);
						$prev_config_section = (isset($tags['@cfg_section'])) ? $tags['@cfg_section'] : $prev_config_section;
						//Checking whether the @cfg_section tag is set or not
						if (isset($tags['@cfg_section']))
							{
								$paragraphs['variables'][$tags['@cfg_section']][] = array('name' => $var_name,
																						  'value'=> $var_value,
																						  'doc'	 => $doc,
																						  'tags' =>$tags);
							}
							else if (isset($tags['@cfg_key']) and isset($tags['@cfg_label']))
								{
									$paragraphs['variables'][$prev_config_section][] = array('name' => $var_name,
																							  'value'=> $var_value,
																							  'doc'	 => $doc,
																							  'tags' =>$tags);

								}
						$start++;
					}
				return $paragraphs['variables'];
			}

		/**
		 * Function to extract the document lines trimming the spaces and the comment symbol from the doc block
		 *
		 * @param		string $paragraph doc documentation block content
		 * @return 		string the document code
		 * @access		public
		 */
		public function extractPhpdoc($paragraph)
			{
				$lines  = split($this->PHP_BASE["break"], $paragraph);
				$phpdoc = "";
				reset($lines);
				while(list($k, $line) = each($lines))
					{
						$line = trim($line);
						if (""==$line)
								continue;
						if ("*" == $line[0])
								$phpdoc.= trim(substr($line, 1))."\n";
							else
								$phpdoc.= $line."\n";
					}
				return substr($phpdoc, 0, -1);
			}

		/**
		 * Extracts PHPDoc tags from a PHPDoc doc comment.
		 *
		 * @param	string		$phpdoc Doc comment.
		 * @return	array		List of tags ordered by their appearance containing the
		 * 						tag name and it's (unparsed) value.
		 * @see		getTagPos()
		 * @access	public
		 */
		public function getTags($phpdoc)
			{
				$positions = $this->getTagPos($phpdoc);
				if (0 == count($positions))
					return array();
				reset($positions);
				list($k, $data) = each($positions);
				$lastpos = $data['pos'];
				$lasttag = $data['tag'];
				while (list($k, $data) = each($positions))
					{
						$line 		= substr($phpdoc, $lastpos, ($data['pos'] - $lastpos));
						$value 		= trim(substr($line, strlen($lasttag)));
						//$tags[] 	= array ("tag"	=> $lasttag, "value"	=> $value );
						$tags[$lasttag] =  $value;
						$lastpos	= $data['pos'];
						$lasttag	= $data['tag'];
					}

				$line 	= substr($phpdoc, $lastpos);
				$value 	= trim(substr($line, strlen($lasttag)));
				//$tags[] = array ("tag"	=> $lasttag, "value"	=> $value );
				$tags[$lasttag] =  $value ;
				return $tags;
			}

	   /**
		* Find the position of the next phpdoc tag.
		*
		* @param		string	$phpdoc
		* @param		integer	$offset
		* @return 		array	$tag	0 => tag, 1 => offset
		* @access		public
		* @see			findTags()
		*/
		public function getTagPos($phpdoc, $offset = 0)
			{
				$positions	= array();
				$all_tags = "";
				reset($this->PHPDOC_TAGS);
				while (list($tag, $v)=each($this->PHPDOC_TAGS))
					$all_tags.= substr($tag, 1)."|";
				$all_tags = substr($all_tags, 0, -1);
				$this->TAGS["all"] = "/@($all_tags)/is";
				preg_match_all($this->TAGS["all"], $phpdoc, $regs, PREG_SET_ORDER);
				reset($regs);
				while (list($k, $data) = each($regs))
					{
						$pos = strpos($phpdoc, $data[0], $offset);
						if ($pos > 0 || $data[0] == substr($phpdoc, 0, strlen($data[0])) )
							{
								$positions[] = array ('pos' => $pos, 'tag' => $data[0]);
								$offset = $pos+1;
							}
					}
				return $positions;
			}
	}
//<<<<<------------------ Class Parser --------------------//
?>