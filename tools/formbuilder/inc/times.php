<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design, 
 * Please contact me if you need any such web-based information system 
 * 
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai 
 * @package FireForm a Ajax Form Builder
 * @version 1.0
 * 
 *
 */
	function getMonths()
	{
		$predefinedMonths = array(	
		"0"=>CMM_MONTH,
		"1"=>"01",
		"2"=>"02",
		"3"=>"03",
		"4"=>"04",
		"5"=>"05",
		"6"=>"06",
		"7"=>"07",
		"8"=>"08",
		"9"=>"09",
		"10"=>"10",
		"11"=>"11",
		"12"=>"12"	
		);	
		return $predefinedMonths;	
	}
	/**
	 * get a list of  months shown in drop down menu html
	 *
	 * @param string $name the select element name
	 * @param string $selected the selected option
	 * @param string $class the css class name
	 * @param string $onchangeEvent call back function when onchange
	 * 
	 * @return html drop down menu html	
	 */		
	function getMonthsHTML(
		$name = 'month', $selected = 0, $class = 'input', $onchangeEvent='')
	{
		$output = '';
		$output .= "<select name=\"" . $name . "\" id=\"" . $name . "\" ";
		if(!empty($class))
		{
			$output .= ' class="' . $class . '" ';
		}
		if(!empty($onchangeEvent))
		{
			$output .= ' onChange="' . $onchangeEvent . "\" ";
		}
		$output .= ">\n";
		foreach(getMonths() as $k=>$v)
		{
			$output .= "<option value=\"" . $k . "\" ";
			if($k == $selected)
			{
				$output .= ' selected="selected" ';
			}
			$output .= ">" .  $v . "</option>\n";
		}
		$output .= "</select>\n";
		return $output;
	}

	function getDays()
	{
		$predefinedDays = array(
		"0"=>CMM_DAY,
		"1"=>"01",
		"2"=>"02",
		"3"=>"03",
		"4"=>"04",
		"5"=>"05",
		"6"=>"06",
		"7"=>"07",
		"8"=>"08",
		"9"=>"09",
		"10"=>"10",
		"11"=>"11",
		"12"=>"12",
		"13"=>"13",
		"14"=>"14",
		"15"=>"15",
		"16"=>"16",
		"17"=>"17",
		"18"=>"18",
		"19"=>"19",
		"20"=>"20",
		"21"=>"21",
		"22"=>"22",
		"23"=>"23",
		"24"=>"24",
		"25"=>"25",
		"26"=>"26",
		"27"=>"27",
		"28"=>"28",
		"29"=>"29",
		"30"=>"30",
		"31"=>"31",
		
		);		
		return $predefinedDays;
	}
	/**
	 * get a list of days shown in drop down menu html
	 *
	 * @param string $name the select element name
	 * @param string $selected the selected option
	 * @param string $class the css class name
	 * @param string $onchangeEvent call back function when onchange
	 * 
	 * @return html drop down menu html	
	 */	
	function getDaysHTML($name = 'day', $selected = 0, $class = 'input', $onchangeEvent='')
	{
		$output = '';
		$output .= "<select name=\"" . $name . "\" id=\"" . $name . "\" ";
		if(!empty($class))
		{
			$output .= ' class="' . $class . '" ';
		}
		if(!empty($onchangeEvent))
		{
			$output .= ' onChange="' . $onchangeEvent . "\" ";
		}
		$output .= ">\n";
		foreach(getDays() as $k=>$v)
		{
			$output .= "<option value=\"" . $k . "\" ";
			if($k == $selected)
			{
				$output .= ' selected="selected" ';
			}
			$output .= ">" .  $v . "</option>\n";
		}
		$output .= "</select>\n";
		return $output;		
	}
	/**
	 * get a list of specified years
	 * e.g. getYears(3, 2005) array(2005=>2005, 2006=>2006, 2007=>2007)
	 * getYears(3, null, 2007): results: array(2005=>2005, 2006=>2006, 2007=>2007)
	 * getYears(null, 2005, 2007): results: array(2005=>2005, 2006=>2006, 2007=>2007)
	 *
	 * @param integer $length the number of years from the specified min year or max year
	 * @param integer $minYear the start year
	 * @param integer $maxYear the end year
	 * @return array
	 */
	function getYears($length =5, $minYear=null, $maxYear=null)
	{
		$outputs = array();
		$predinedYears = array(0=>"Year");
		if(!empty($maxYear) && !empty($minYear))
		{
			for($i=$minYear; $i <= $maxYear; $i++)
			{
				$outputs[$i] = $i;
			}
		}elseif(!empty($maxYear))
		{
			for($i=(($maxYear-$length) + 1); $i <= $maxYear; $i++)
			{
				$outputs[$i] = $i;
			}
		}elseif(!empty($minYear))
		{
			for($i = $minYear; $i <= ($minYear + $length - 1); $i++)
			{
				$outputs[$i] = $i;
			}
		}else 
		{
			
			$currentYear = intval(date("Y"));
			for($i=0; $i < $length; $i++)
			{
				$year = ($currentYear + $i);
				$outputs[$year] = $year;
			}	
					
		}
		return $outputs;

	}
	
	/**
	 * get a list of specified years shown in drop down menu html
	 *
	 * @param integer $length the number of years from the specified min year or max year
	 * @param integer $minYear the start year
	 * @param integer $maxYear the end year
	 * @param string $name the select element name
	 * @param string $selected the selected option
	 * @param string $class the css class name
	 * @param string $onchangeEvent call back function when onchange
	 * 
	 * @return html drop down menu html	
	 */
	 
	function getYearsHTML($length =5, $minYear=null, $maxYear=null, $name = 'year', $selected = 0, $class = 'input', $onchangeEvent='')
	{
		$output = '';
		$output .= "<select name=\"" . $name . "\" id=\"" . $name . "\" ";
		if(!empty($class))
		{
			$output .= ' class="' . $class . '" ';
		}
		if(!empty($onchangeEvent))
		{
			$output .= ' onChange="' . $onchangeEvent . "\" ";
		}
		$output .= ">\n";
		foreach(getYears($length, $minYear, $maxYear) as $k=>$v)
		{
			$output .= "<option value=\"" . $k . "\" ";
			if($k == $selected)
			{
				$output .= ' selected="selected" ';
			}
			$output .= ">" .  $v . "</option>\n";
		}
		$output .= "</select>\n";	
		return $output;	
	}	
	
	/**
	 * get the list of hours
	 *
	 */
	function getHours()
	{
		$outputs = array();
		for($i= 0; $i <=23; $i++)
		{
			$outputs[$i] = $i;
		}
		return $outputs;
	}
	/**
	 * get a list of hours shown in drop down menu html
	 *
	 * @param string $name the select element name
	 * @param string $selected the selected option
	 * @param string $class the css class name
	 * @param string $onchangeEvent call back function when onchange
	 * 
	 * @return html drop down menu html	
	 */	
	function getHoursHTML($name = 'hour', $selected = 0, $class = 'input', $onchangeEvent='')
	{
		$output = '';
		$output .= "<select name=\"" . $name . "\" id=\"" . $name . "\" ";
		if(!empty($class))
		{
			$output .= ' class="' . $class . '" ';
		}
		if(!empty($onchangeEvent))
		{
			$output .= ' onChange="' . $onchangeEvent . "\" ";
		}
		$output .= ">\n";
		foreach(getHours() as $k=>$v)
		{
			$output .= "<option value=\"" . $k . "\" ";
			if($k == $selected)
			{
				$output .= ' selected="selected" ';
			}
			$output .= ">" .  $v . "</option>\n";
		}
		$output .= "</select>\n";
		return $output;		
	}	
	/**
	 * get the list of minutes
	 *
	 */
	function getMinutes()
	{
		$outputs = array();
		for($i = 0; $i <= 59; $i++)
		{
			$outputs[$i] = $i;
		}
		return $outputs;
	}

	/**
	 * get a list of minutes shown in drop down menu html
	 *
	 * @param string $name the select element name
	 * @param string $selected the selected option
	 * @param string $class the css class name
	 * @param string $onchangeEvent call back function when onchange
	 * 
	 * @return html drop down menu html	
	 */	
	function getMinutesHTML($name = 'minute', $selected = 0, $class = 'input', $onchangeEvent='')
	{
		$output = '';
		$output .= "<select name=\"" . $name . "\" id=\"" . $name . "\" ";
		if(!empty($class))
		{
			$output .= ' class="' . $class . '" ';
		}
		if(!empty($onchangeEvent))
		{
			$output .= ' onChange="' . $onchangeEvent . "\" ";
		}
		$output .= ">\n";
		foreach(getMinutes() as $k=>$v)
		{
			$output .= "<option value=\"" . $k . "\" ";
			if($k == $selected)
			{
				$output .= ' selected="selected" ';
			}
			$output .= ">" .  $v . "</option>\n";
		}
		$output .= "</select>\n";	
		return $output;	
	}		
	
	function getCCExpiryYear($length=6)
	{
		$outputs = array();

		for($i = 0; $i < $length; $i++)
		{
			$currentDay =  mktime(0, 0, 0, date('m'), date('d'), intval(date("Y") ) + $i);
			$currentYearValue = date("Y", $currentDay);
			$currentYearKey = date("y",  $currentDay);		
			$outputs[$currentYearKey] = $currentYearValue;
		}
		return $outputs;
	}
	
	function getCCExpiryMonths()
	{
		$outputs = array();
		for($i = 1; $i <=12; $i++)
		{
			$month = sprintf("%02d", $i);
			$outputs[$month] = $month;
		}
		return $outputs;
	}

	
	function getTomorrow()
	{
		return getdate(mktime(0, 0, 0, date('n'), intval(date('j')) + 1, date("Y")));
	}
?>