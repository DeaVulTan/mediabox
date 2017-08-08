<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design, 
 * Please contact me if you need any such web-based information system 
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai 
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 * 
 *
 */
class Msg
{
	var $msgs = array();
	var $msgExist;
	var $errExist;
	var $advMsgs = array();
	/**
	 * constroctor function
	 *
	 * @return Msg
	 */
	function Msg()
	{
		$this->msgExist = false;
		$this->errExist = false;
		$this->__staticMsg();
		$this->__staticMsgExist();
		$this->__staticErrExist();
	}
	/**
	 * add message
	 *
	 * @param string $Msg
	 */
	function setMsg($Msg)
	{
		$this->__staticMsg("set", $Msg);
		$this->__setMsgExist();
	}

	/**
	 * add error message
	 *
	 * @param string $error
	 */
	function setErrMsg($error, $errorIndex = null, $hiddenError = false)
	{
		$this->__staticMsg("set", $error, $errorIndex, $hiddenError);
		$this->__setErrExist();
		$this->__setMsgExist();
	}

	/**
	 * check if there exists any message including error message
	 *
	 * @return boolean
	 */
	function isMsgExist()
	{
		return $this->__staticMsgExist("get");

	}
	/**
	 * check if there exists any error messages
	 *
	 * @return boolean
	 */
	function isErrExist($index = null)
	{
		if(is_null($index))
		{
			return $this->__staticErrExist("get");
		}else 
		{
			$errorIndexs = $this->__staticMsg('getIndex');
			if(array_search($index, $errorIndexs) !== false)
			{
				return true;
			}else 
			{
				return false;
			}			
		}

		

	}
	/**
	 * get all existed messages including errors.
	 *
	 * @return array
	 */
	function getMsg()
	{
		return $this->__staticMsg("get");

	}
	/**
	 * get the javascript string which contain all messages and
	 *  shown it in a alert popup window
	 *
	 * @return string javascript html
	 */
	
	function getPopupMsg()
	{
		$result = "";
		if($this->isMsgExist())
		{
			$msgs = $this->__staticMsg("get");
			if(sizeof($msgs))
			{
				$result .= "\n\n\n<script language=\"javascript\" type=\"text/javascript\">\n";
				$result .= "function displayErrPopupMsg()\n";
				$result .= "{\n";
				$result .= "alert('";
				foreach($msgs as $msg)
				{
	
					$result .= addslashes(trim($msg)) . "\\n";
				}
				$result .= "');\n}\n\n\n";
				$result .= "if(window.addEventListener) window.addEventListener('load', displayErrPopupMsg, false);\n";
				$result .= "else if(window.attachEvent)\n";
				$result .= "{\n";
				$result .= "window['eloaddisplayErrPopupMsg']=displayErrPopupMsg;\n";
				$result .= "window['loaddisplayErrPopupMsg'] = function()\n";
				$result .= "{\n";
				$result .= "window['eloaddisplayErrPopupMsg'](window.event);\n";
				$result .= "};\n";
				$result .= "window.attachEvent('onload', window['loaddisplayErrPopupMsg']);\n";
				$result .= "};\n";
	
				$result .= "</script>\n";				
			}

		}
		return $result;
	}
	/**
	 * display those message within a javascription popup windows
	 *
	 */
	function displayPopupMsg()
	{
		echo $this->getPopupMsg();
	}
	
	function shownError()
	{
		if($this->isErrExist())
		{
			$msgs = $this->__staticMsg("get");
			if(sizeof($msgs))
			{
				echo '<table cellpadding="0" cellspacing="0" style="width:100%"><tbody>';
				foreach ($msgs as $error)
				{
						echo 	'<tr><td style="text-align:center; color:red; font-size:24px; padding-top:100px">';
						echo  $error  ;
						echo '</td><tr>';
				}
				echo '</tbody></table>';
			}
		}
	}






	/**
	 * private function
	 *
	 */
	function __setErrExist()
	{
		$this->__staticErrExist("set");
	}




	/**
	 * private function
	 *
	 */
	function __setMsgExist()
	{
		$this->__staticMsgExist("set");
	}


	/**
	 * private function
	 *
	 */
	function __staticMsg($action="clear", $Msg="", $errorIndex=null, $hiddenError=false)
	{
		static $msgs, $errorIndexs, $arrayIndex;
		if($action == "set")
		{
			if(!empty($Msg) && !$hiddenError)
			{
				array_push($msgs, $Msg);
			}
			
			if(!is_null($errorIndex))
			{
				if(is_array($errorIndex))
				{
					foreach($errorIndex as $index)
					{
						$errorIndexs[] = $index;
					}
				}else 
				{
					$errorIndexs[] = $errorIndex;
				}
				$arrayIndex = 0;
				
			}
		}elseif($action=="get")
		{
			return $msgs;
		}elseif($action == 'getIndex')
		{
			return $errorIndexs;
		}
		else
		{
			$errorIndexs = array();
			$msgs = array();
		}

	}

	/**
	 * private function
	 *
	 */
	function __staticMsgExist($action="clear")
	{
		static $msgExist;
		if($action == "set")
		{
			$msgExist = true;
		}elseif($action == "get")
		{
			return $msgExist;
		}else
		{
			$msgExist = false;
		}
	}
	/**
	 * private function
	 *
	 */
	function __staticErrExist($action="clear")
	{
		static $errExist;
		if($action == "set")
		{
			$errExist = true;
		}elseif($action == "get")
		{
			return $errExist;
		}else
		{
			$errExist = false;
		}
	}

	
	
}



?>