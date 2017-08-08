<?php
/**
 * To handle errors
 *
 * This file is having ErrorHandler class to deal error details
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author 		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: class_ErrorHandler.lib.php 170 2008-04-02 09:49:23Z vidhya_29ag04 $
 * @since 		2004-04-02
 * @todo 		mailing and logging
 * @todo 		fix severe flaw at processTrappedErrors() or done?
 */
//To test this class in standalone mode with test cases
//found at the end of this class...
if (!isset($CFG['debug']['debug_standalone_modules']))
		$CFG['debug']['debug_standalone_modules'] = true;

/**
 * This file is having ErrorHandler class for handling the errors
 *
 * <b>Class overview</b>
 *
 * ErrorHandler is having various methods to handle the errors
 *
 * <b>Methods overview</b>
 *
 * ErrorHandler class is having setErrorLevel() method to set the error level,
 * setErrorNotifyEmail() method set the error notify email,
 * setIsDebugMode() is to set the debug mode,  setIsCatchFatalError() to cacth
 * fatal errors, setNumSourceToFetch() to set the number of source
 * to fetch before and afetr error lines,  _getSource() method to get the source
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author 		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2004-04-02
 **/
class ErrorHandler
	{
		private $dbObject = null;					//database object
		private $error_level = E_ALL;				//error level
		private $error_notify_email = null;			//error notify e-mail
		private $source_before_errline = 2;			//source to fetch before error line
		private $source_after_errline = 2;			//source to fetch after error line
		private $error_stack_arr = null;			//stack of errors
		private $error_log_name = null;				//error log name
		private $error500_document = null;			//error 500 file
		private $user_error_msg = 'Script error occured. Please retry later!';		//User error message
		private $is_debug_mode = false;				//whether debug mode?
		private $is_catch_fatal_error = false;		//whether catch fatal errors?
		private $debug_css_url = null;				//the URL of debug.css (http://foo.com/debug.css)

		/**
        * ErrorHandler :: ErrorHandler()
        *
        * @return void The function does not return any value
		* @access public
        */
		public function __construct()
			{
				if (!defined('E_STRICT')) //available only in PHP5
						define('E_STRICT', 2048);	//Run-time notices. Enable to have PHP suggest changes to your code which will ensure the best interoperability and forward compatibility of your code.
				set_error_handler(array(&$this, 'normalErrorHandler'));
			}

		/**
        * ErrorHandler :: setErrorLevel()
        *
		* @param int $errlevel error level
        * @return void
		* @access public
        */
		public function setErrorLevel($errlevel)
			{
				$this->error_level = $errlevel;
			}

		/**
        * ErrorHandler :: setErrorNotifyEmail()
        *
		* @param string $email E-mail address
        * @return void
		* @access public
        */
		public function setErrorNotifyEmail($email)
			{
				$this->error_notify_email =  $email;
			}

		/**
		 * ErrorHandler::setIsDebugMode()
		 *
		 * @param boolean $is_debug_mode whether debug mode
		 * @return void
		 * @access public
		 */
		public function setIsDebugMode($is_debug_mode)
			{
				$this->is_debug_mode = $is_debug_mode;
			}

		/**
		 * ErrorHandler::setIsCatchFatalError()
		 *
		 * @param boolean $is_catch_fatal_error whether catch fatal errors
		 * @return void
		 * @access public
		 */
		public function setIsCatchFatalError($is_catch_fatal_error)
			{
				$this->is_catch_fatal_error = $is_catch_fatal_error;
				//catch via out put buffer...
				ob_start(array(&$this, 'fatalErrorHandler'));
			}

		/**
        * ErrorHandler :: setNumSourceToFetch()
        *
		* @param int $num_before_error number of source to fetch before error line
		* @param int $num_after_error number of source to fetch after error line
        * @return void
		* @access public
        */
		public function setNumSourceToFetch($num_before_error, $num_after_error)
			{
				$this->source_before_errline = $num_before_error;
				$this->source_after_errline = $num_after_error;
			}

		/**
		 * ErrorHandler::setDebugCSSURL()
		 *
		 * @param string $url URL of debug.css
		 * @return void
		 * @access public
		 */
		public function setDebugCSSURL($url)
			{
				$this->debug_css_url = $url;
			}

		/**
        * ErrorHandler :: _die()
        *
        * @return void
		* @access private
        */
		private function _die()
			{
				echo $this->user_error_msg;
				exit(1);
			}

		/**
        * ErrorHandler :: _die500()
        *
        * @return void
		* @access private
        */
		private function _die500()
			{
				header('Status: 500');
				header('HTTP/1.0 500 Internal Server Error');
				if (!empty($this->error500_document))
					readfile($this->error500_document);
				exit(1);
			}


		/**
        * ErrorHandler::_formatDebugBacktrace()
        *
        * @param array $trace_arr debug_backtrace()
        * @return string Formatted debug_backtrace()
		* @access private
        */
		private function _formatDebugBacktrace($trace_arr)
			{
				$s = '';
				if (!empty($trace_arr))
					{
						array_shift($trace_arr);	//skip the first one, since it's always this func
						$tabs = count($trace_arr) - 1;
						foreach($trace_arr as $arr)
							{
								$line = (isset($arr['line'])? $arr['line'] : 'unknown');
								$file = (isset($arr['file'])? $arr['file'] : 'unknown');

								for ($i=0; $i < $tabs; ++$i)
									$s .= '  ';
								$s .= '<strong>Line: </strong>['.$line.'] '.$file."\n";
								for ($i=0; $i < $tabs; ++$i)
									$s .= '  ';
								$tabs -= 1;
								if (isset($arr['class']))
									$s .= $arr['class'].$arr['type'];
								$args = array();
								if (isset($arr['args']) && count($arr['args']) > 0)
									foreach($arr['args'] as $v)
										{
											if (is_null($v))
												$args[] = 'null';
											else if (is_array($v))
												$args[] = 'Array['.sizeof($v).']';
											else if (is_object($v))
												$args[] = 'Object:'.get_class($v);
											else if (is_bool($v))
												$args[] = $v ? 'true' : 'false';
											else
												{
												    $v = (string) @$v;
												    $args[] = '"'.htmlspecialchars($v).'"';
												}
										}
								$s .= $arr['function'].'('.implode(', ', $args).')';
								$s .= "\n";
							}
						}
				return $s;
			}

		/**
        * ErrorHandler :: normalErrorHandler()
        *
		* @param int $errno Error Number
		* @param string $errstr Error Message
		* @param array $errfile File of Error Messages
		* @param int $errline Error Line Number
		* @param array $errcontext_arr Array of contextual error messages
        * @return void
		* @access public
        */
		public function normalErrorHandler($errno, $errstr, $errfile, $errline, $errcontext_arr)
			{
				//error_reporting will be temporarily set to zeor on using @
				//so, don't handle @'d errors
				//@link http://www.php.net/set_error_handler
				if (error_reporting()!=0)
					{
						$exclude_context_vars_arr = array('GLOBALS',
															'_POST',
															'HTTP_POST_VARS',
															'_GET',
															'HTTP_GET_VARS',
															'_COOKIE',
															'HTTP_COOKIE_VARS',
															'_SERVER',
															'HTTP_SERVER_VARS',
															'_ENV',
															'HTTP_ENV_VARS',
															'_FILES',
															'HTTP_POST_FILES',
															'_REQUEST',
															'CFG',
															'errHandler',
															'buffer',
															'db');
						//Couldn't directly unset $errcontext_arr[$key]. That's why variables are moved to another array and bring back...
						$errcontext_fixed_arr = array();
						foreach($errcontext_arr as $key=>$val)
							if (!in_array($key, $exclude_context_vars_arr))
								$errcontext_fixed_arr[$key] = $val;
						$errcontext_arr = $errcontext_fixed_arr; //<--end workaround for unset problem
						$errors_for_500 = array('DB Connection Error');
						//if the error has to be trapped according to error level...
						if ($this->error_level & $errno)  //push it into error stack...
							{
								$debug_trace = array();
								if ($errno!=E_ERROR)	//debug_backtrace only on non-fatal errors
									$debug_trace = debug_backtrace();
								$this->error_stack_arr[] = array($errno, $errstr, $errfile, $errline, $errcontext_arr, $debug_trace);
							}
						switch($errno)
							{
								case E_USER_ERROR: //fatal user error...
								    echo $this->processTrappedErrors();
									if (in_array($errstr, $errors_for_500))
											$this->_die500();
										else
											$this->_die();
									break;
								//fatal error handled by fatalErrorHandler. So ignore here...
								//case E_ERROR:
							}
					}
			}

		/**
        * ErrorHandler :: _my_highlight_string()
        *
		* @param string $str String Message
        * @return string $highlighted_str The highlighted message
		* @access private
        */
		private function _my_highlight_string($str)
			{
				//using tokenizer functions (www.php.net/tokenizer) ...
				/* T_ML_COMMENT does not exist in PHP 5.
				   * The following three lines define it in order to
				   * preserve backwards compatibility.
				   *
				   * The next two lines define the PHP 5-only T_DOC_COMMENT,
				   * which we will mask as T_ML_COMMENT for PHP 4.
				   * @link www.php.net/tokenizer
				   */
				if (!defined('T_ML_COMMENT'))
				 		define('T_ML_COMMENT', T_COMMENT);
				if (!defined('T_DOC_COMMENT'))
						define('T_DOC_COMMENT', T_ML_COMMENT);
				if (!defined('T_OLD_FUNCTION'))		//Not sure, why this is not defined in PHP 5; no info on internet
						define('T_OLD_FUNCTION', T_FUNCTION);
				$colorize_map = array(
					T_INCLUDE                  =>  'keyword',
					T_INCLUDE_ONCE             =>  'keyword',
					T_EVAL                     =>  'keyword',
					T_REQUIRE                  =>  'keyword',
					T_REQUIRE_ONCE             =>  'keyword',
					T_LOGICAL_OR               =>  'keyword',
					T_LOGICAL_XOR              =>  'keyword',
					T_LOGICAL_AND              =>  'keyword',
					T_PRINT                    =>  'keyword',
					T_PLUS_EQUAL               =>  'keyword',
					T_MINUS_EQUAL              =>  'keyword',
					T_MUL_EQUAL                =>  'keyword',
					T_DIV_EQUAL                =>  'keyword',
					T_CONCAT_EQUAL             =>  'keyword',
					T_MOD_EQUAL                =>  'keyword',
					T_AND_EQUAL                =>  'keyword',
					T_OR_EQUAL                 =>  'keyword',
					T_XOR_EQUAL                =>  'keyword',
					T_SL_EQUAL                 =>  'keyword',
					T_SR_EQUAL                 =>  'keyword',
					T_BOOLEAN_OR               =>  'keyword',
					T_BOOLEAN_AND              =>  'keyword',
					T_IS_EQUAL                 =>  'keyword',
					T_IS_NOT_EQUAL             =>  'keyword',
					T_IS_IDENTICAL             =>  'keyword',
					T_IS_NOT_IDENTICAL         =>  'keyword',
					T_IS_SMALLER_OR_EQUAL      =>  'keyword',
					T_IS_GREATER_OR_EQUAL      =>  'keyword',
					T_SL                       =>  'keyword',
					T_SR                       =>  'keyword',
					T_INC                      =>  'keyword',
					T_DEC                      =>  'keyword',
					T_INT_CAST                 =>  'keyword',
					T_DOUBLE_CAST              =>  'keyword',
					T_STRING_CAST              =>  'keyword',
					T_ARRAY_CAST               =>  'keyword',
					T_OBJECT_CAST              =>  'keyword',
					T_BOOL_CAST                =>  'keyword',
					T_UNSET_CAST               =>  'keyword',
					T_NEW                      =>  'keyword',
					T_EXIT                     =>  'keyword',
					T_IF                       =>  'keyword',
					T_ELSEIF                   =>  'keyword',
					T_ELSE                     =>  'keyword',
					T_ENDIF                    =>  'keyword',
					T_LNUMBER                  =>  'default',
					T_DNUMBER                  =>  'default',
					T_STRING                   =>  'string',
					T_STRING_VARNAME           =>  'string',
					T_VARIABLE                 =>  'default',
					T_NUM_STRING               =>  'string',
					T_INLINE_HTML              =>  'html',
					T_CHARACTER                =>  'default',
					T_BAD_CHARACTER            =>  'default',
					T_ENCAPSED_AND_WHITESPACE  =>  'default',
					T_CONSTANT_ENCAPSED_STRING =>  'string',
					T_ECHO                     =>  'keyword',
					T_DO                       =>  'keyword',
					T_WHILE                    =>  'keyword',
					T_ENDWHILE                 =>  'keyword',
					T_FOR                      =>  'keyword',
					T_ENDFOR                   =>  'keyword',
					T_FOREACH                  =>  'keyword',
					T_ENDFOREACH               =>  'keyword',
					T_DECLARE                  =>  'keyword',
					T_ENDDECLARE               =>  'keyword',
					T_AS                       =>  'keyword',
					T_SWITCH                   =>  'keyword',
					T_ENDSWITCH                =>  'keyword',
					T_CASE                     =>  'keyword',
					T_DEFAULT                  =>  'keyword',
					T_BREAK                    =>  'keyword',
					T_CONTINUE                 =>  'keyword',
					T_OLD_FUNCTION             =>  'default',
					T_FUNCTION                 =>  'default',
					T_CONST                    =>  'default',
					T_RETURN                   =>  'keyword',
					T_USE                      =>  'default',
					T_GLOBAL                   =>  'default',
					T_STATIC                   =>  'default',
					T_VAR                      =>  'default',
					T_UNSET                    =>  'default',
					T_ISSET                    =>  'default',
					T_EMPTY                    =>  'default',
					T_CLASS                    =>  'keyword',
					T_EXTENDS                  =>  'keyword',
					T_OBJECT_OPERATOR          =>  'keyword',
					T_DOUBLE_ARROW             =>  'keyword',
					T_LIST                     =>  'keyword',
					T_ARRAY                    =>  'default',
					T_LINE                     =>  'default',
					T_FILE                     =>  'default',
					T_COMMENT                  =>  'comment',
					T_ML_COMMENT               =>  'comment',
					T_OPEN_TAG                 =>  'keyword',
					T_OPEN_TAG_WITH_ECHO       =>  'keyword',
					T_CLOSE_TAG                =>  'keyword',
					T_WHITESPACE               =>  'default',
					T_START_HEREDOC            =>  'keyword',
					T_END_HEREDOC              =>  'keyword',
					T_DOLLAR_OPEN_CURLY_BRACES =>  'keyword',
					T_CURLY_OPEN               =>  'keyword',
					T_PAAMAYIM_NEKUDOTAYIM     =>  'keyword',
					T_DOUBLE_COLON             =>  'keyword'
					);
				$tokens = token_get_all($str);
				$highlighted_str = '<code>';
				foreach ($tokens as $token)
					{
					   if (is_string($token)) // simple 1-character token
					   		{
								//some fixations
								$token = htmlentities($token);
								$token = str_replace(array('  ', "\t"),
													array(' &nbsp;', ' &nbsp; &nbsp;'),
													$token);
								$highlighted_str .= $token;
							}
					   	else if (is_array($token))
							{
								list($id, $text) = $token; // token array
								//some fixations
								$text = htmlentities($text);
								$text = str_replace(array('  ', "\t"),
													array(' &nbsp;', ' &nbsp; &nbsp;'),
													$text);
							   $highlighted_str .= '<font color="'.ini_get('highlight.'.$colorize_map[$id]).'">'.$text.'</font>';
							}
					}
				$highlighted_str .= '</code>';
				return $highlighted_str;
			}

		/**
        * ErrorHandler :: _getSource()
        *
		* @param string $filename Name of the file
		* @param int $errline Error Line Number
		* @return string $source The highlighted string message
		* @access private
        */
		private function _getSource($filename, $errline)
			{
				$source = "\t".'<div class="clsDebugSource">'."\n";
				$file_in_arr = file($filename);
				//$errline will be less 1 as array begins at 0 offset. So fix errline
				$errline -= 1;
				$source_begin_line = $errline - $this->source_before_errline;
				$source_end_line = 1 + $errline + $this->source_after_errline;
				if ($source_begin_line<0)
						$source_begin_line = 0;
				$num_lines_in_file = count($file_in_arr);
				if ($source_end_line>$num_lines_in_file)
						$source_end_line = $num_lines_in_file;
				$tmp_highlighted_source = '';
				for($i=$source_begin_line; $i<$source_end_line; ++$i)
					{
						//rtrim for newlines and space cleanup at the end...
						$file_in_arr[$i] = rtrim($file_in_arr[$i]);
						//Alert: highlight_string and higlight_file won't work with output buffering..
						//Revision: But, works with ob_gzhandler. Kinda strange!!
						if ($this->is_catch_fatal_error)  //if (ob_get_level())
							{
								//call my simple highlight funciton (using tokenizer)...
								//add php tag for highlight...
								$tmp_highlight_line = $this->_my_highlight_string("<?php\n".$file_in_arr[$i]);
								//remove added php tag...
								$expected_prefix = '<code><font color="'.ini_get('highlight.keyword').'">&lt;?php'."\n".'</font>';
								if (strncasecmp($tmp_highlight_line, $expected_prefix, strlen($expected_prefix))==0)
								    	$tmp_highlight_line = '<code>' . substr($tmp_highlight_line, strlen($expected_prefix));
									else //in some cases it messed up. Dirty fix.
										{
											$expected_prefix = '<code><font color="'.ini_get('highlight.default').'">&lt;?</font><font color="'.ini_get('highlight.string').'">php</font>';
											if (strncasecmp($tmp_highlight_line, $expected_prefix, strlen($expected_prefix))==0)
											    	$tmp_highlight_line = '<code>' . substr($tmp_highlight_line, strlen($expected_prefix));
										}
							}
							else
								{
									//add php tag for highlight...
									$tmp_highlight_line = highlight_string("<?php\n".$file_in_arr[$i], true);
									//remove added php tag...
									$tmp_highlight_line = str_replace('&lt;?php<br />', '', $tmp_highlight_line);
								}
						//xhtml compliant source. (version<PHP5 will add font tag)...
						// Replacement-map to replace deprecated "<font>" tag with "<span>"
						$xhtml_convmap = array(
									'<code>' => '', //also few cleanup
									'</code>' => '',
									//'<br />' => "\n",
									//'&nbsp;' => ' ',
									"\n" => '', //tidy as it is just one string
									'<font' => '<span',
									'</font>' => '</span>',
									'color="' => 'style="color:'
								);
						$tmp_highlight_line = strtr($tmp_highlight_line, $xhtml_convmap);
						//differentiate exact line and add <br />\n at end...
						if ($i==$errline)
								$tmp_highlighted_source .= "\t\t".'<code><span class="clsDebugSourceLine"><span style="color:#999999">'.($i+1).'</span> '.$tmp_highlight_line.'</span></code><br />'."\n";
							else
								$tmp_highlighted_source .= "\t\t".'<code><span style="color:#999999">'.($i+1).'</span> '.$tmp_highlight_line.'</code><br />'."\n";
					}
				$source .= $tmp_highlighted_source;
				$source .= "\t".'</div>'."\n";
				return $source;
			}

		/**
	    * ErrorHandler :: fatalErrorHandler()
	    *
		* @param string $buffer Buffered Message
	    * @return string $buffer Buffered Message
		* @access public
        */
		public function fatalErrorHandler($buffer)
			{
//				if (preg_match("/<b>(.*?error)<\/b>:(.*?) in <b>(.*?)<\/b> on line <b>(.*?)<\/b><br \/>/i", $buffer, $matches))  ///(error</b>:)(.+)(<br)/i
				//Fix for new php versions (?)...
				if (preg_match("/(?:<b>)?(.*?error)(?:<\/b>)?: (.*?) in (?:<b>)?(.*?)(?:<\/b>)? on line (?:<b>)?(\d+)(?:<\/b>)?(?:<br \/>)?/i", $buffer, $matches))  ///(error</b>:)(.+)(<br)/i
					{
						//clean up PHP codes and spaces...
						foreach($matches as $key=>$val)
							$matches[$key] = trim(preg_replace("/<.*?>/",'',$val));
						//now send the values to the error handler...
						$this->normalErrorHandler(E_ERROR, $matches[2], $matches[3], $matches[4], get_defined_vars());
						//also process trapped errors...
						$errmsg = $this->processTrappedErrors();
						//remove fatal error message from the buffer...
//						$buffer = preg_replace("/<b>(.*?error<\/b>:.*? in <b>.*?<\/b> on line <b>.*?<\/b><br \/>)/i", $this->user_error_msg, $buffer);
						//Fix for new php versions (?)...
						$buffer = preg_replace("/(.*?error.*?:.*? in .*? on line \d+)/i", $this->user_error_msg, $buffer);
						//append errmsg..
						$buffer .= $errmsg;
//script died because of fatal error. So, flush all output buffers...
//						while(ob_get_level())
//								ob_end_clean();
//						while (@ob_end_clean());
					}
				return $buffer;
			}

		/**
		 * ErrorHandler::_my_var_export()
		 * Taken from PEAR::PHP_Compact
		 * @param $array array to export
		 * @param boolean $return Is return or echo?
		 * @link http://pear.php.net/package/PHP_Compat
		 * @return string/void
		 * @access private
		 */
		private function _my_var_export($array, $return = false)
			{
				//Common output variables
				$indent         = '  ';
				$doublearrow    = ' => ';
				$lineend        = ",\n";
				$stringdelim    = '\'';
				$newline        = "\n";

				//Check the export isn't a simple string / int
				if (is_string($array))
					  $out = $stringdelim . $array . $stringdelim;
				  else if (is_int($array))
					  $out = (string)$array;
			        //Begin the array export
					else
						{
				            //Start the string
				            $out = 'array ('."\n";
				            //Loop through each value in array
				            foreach($array as $key => $value)
				            {
				                //If the key is a string, delimit it
				                if (is_string($key))
				                    $key = $stringdelim . addslashes($key) . $stringdelim;
				                //If the value is a string, delimit it
				                if (is_string($value))
				                    $value = $stringdelim . addslashes($value) . $stringdelim;
					                //We have an array, so do some recursion
					                else if (is_array($value))
										{
											//Do some basic recursion while increasing the indent
											$recur_array = explode($newline, $this->_my_var_export($value, true));
											$recur_newarr = array ();
											foreach ($recur_array as $recur_line)
												$recur_newarr[] = $indent . $recur_line;
											$recur_array = implode($newline, $recur_newarr);
											$value = $newline . $recur_array;
										}
									//Piece together the line
									$out .= $indent . $key . $doublearrow . $value . $lineend;
				            }
				            //End our string
				            $out .= ')';
				        }
		        //Decide method of output
		        if ($return === true)
		            	return $out;
		        	else
						{
				            echo $out;
				            return;
						}
   			}

		/**
	    * ErrorHandler :: processTrappedErrors()
        *
        * @return string $errmsg Error Message
		* @access public
        */
		public function processTrappedErrors()
			{
				$errmsg = '';
				if ( !empty($this->error_stack_arr) )
					{
						//remove duplicates...
						$errortypes_arr = array (
								               E_ERROR          => 'Fatal Error',
								               E_WARNING        => 'Warning',
								               E_PARSE          => 'Parsing Error',
								               E_NOTICE          => 'Notice',
								               E_CORE_ERROR      => 'Core Error',
								               E_CORE_WARNING    => 'Core Warning',
								               E_COMPILE_ERROR  => 'Compile Error',
								               E_COMPILE_WARNING => 'Compile Warning',
								               E_USER_ERROR      => 'User Error',
								               E_USER_WARNING    => 'User Warning',
								               E_USER_NOTICE    => 'User Notice',
								               E_STRICT          => 'Runtime Notice'
								             );
						$num_errors = count($this->error_stack_arr);
						//JavaScript alert and focus on errors...
						if ($num_errors && $this->is_debug_mode)
							$errmsg .= '<div id="selDebugErrors">'."\n";
						for($i=0; $i<$num_errors; ++$i)
							{
								//if debug mode, then echo errors...
								if ($this->is_debug_mode)
									{
									   //-->error_stack_arr[] = array(errno, errstr, errfile, errline, errcontext_arr)
									   $errmsg .= '<div class="clsDebugErrors">'."\n";
									   $errmsg .= "\t".'<p><strong>Error: </strong>['.$this->error_stack_arr[$i][0].'] ['.$errortypes_arr[$this->error_stack_arr[$i][0]].'] '.$this->error_stack_arr[$i][1].'<br />'."\n";
									   $errmsg .= "\t".'<strong>Line: </strong>['.$this->error_stack_arr[$i][3].'] '.$this->error_stack_arr[$i][2].'<br />'."\n";
									   $errmsg .= "\t".'<strong>Source:</strong></p>'."\n";
									   $errmsg .= $this->_getSource($this->error_stack_arr[$i][2], $this->error_stack_arr[$i][3]);
									   $errmsg .= "\t".'<p><strong>Debug Trace:</strong></p>'."\n";
									   $errmsg .= "\t".'<pre class="clsDebugTrace">'."\n".$this->_formatDebugBacktrace($this->error_stack_arr[$i][5])."\n\t".'</pre>'."\n";
									   $errmsg .= "\t".'<p><strong>Context Variables:</strong></p>'."\n";
									   if ($this->is_catch_fatal_error) //cannot use output buffering builtin functions like var_export
									   		$errmsg .= "\t".'<pre class="clsDebugContextVars">'."\n".htmlentities($this->_my_var_export($this->error_stack_arr[$i][4], true))."\n\t".'</pre>'."\n";
										 else
											$errmsg .= "\t".'<pre class="clsDebugContextVars">'."\n".htmlentities(var_export($this->error_stack_arr[$i][4], true))."\n\t".'</pre>'."\n";
									   $errmsg .= '</div>'."\n";
									}
							}
						//debug CSS, JavaScript alert and focus on errors...
						if ($num_errors && $this->is_debug_mode)
							{
								$errmsg .= '</div>'."\n";
								//debug style...
								$errmsg .= '<style type="text/css">'."\n";
								$errmsg .= '@import url("'.$this->debug_css_url.'");'."\n";
								$errmsg .= '</style>'."\n";
								//javascript alert
								$errmsg .= '<script language="JavaScript" type="text/javascript">'."\n";
								$errmsg .= '<!--'."\n";
								$errmsg .= 'window.scroll(0, document.getElementById("selDebugErrors").offsetTop);'."\n";
								$errmsg .= 'window.focus();'."\n";
								$errmsg .= 'alert("PHP Error Handler:\n\n'.$num_errors.' errors found!");'."\n";
								$errmsg .= '//-->'."\n";
								$errmsg .= '</script>'."\n";
							}
					}
/*	-- @todo Severe flaw here. -- to do or get fixed ??!...
				//if output is not bufferred, then must echo...
				if (!$this->is_catch_fatal_error)
						echo $errmsg;
*/
				return $errmsg;
			}
	}/*----------class ErrorHandler------------*/


/****************************************/
/*----Test cases in standalone mode-----*/
/****************************************/
if ($CFG['debug']['debug_standalone_modules'])
	{
		$errHandler = new ErrorHandler();
		$errHandler->setErrorLevel(E_ALL);
		$errHandler->setIsCatchFatalError(false);
		$errHandler->setIsDebugMode(true);
		for($i=0; $i<5; ++$i)
			echo $a; //undefined variable
		$a = b; //notice of $b
		include('nonoo'); //no such file
		//test fatal error...
	    $a = ao();
		//trigger_error('Test', E_USER_ERROR);
		$errHandler->processTrappedErrors();
	}
?>