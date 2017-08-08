<?php
/**
 * FireForm is a web based form builder enpowed by jquery javascript library and PHP
 * We are specilized in Website Development, Online Survey Creation, Online Shopping Site Design, 
 * Please contact me if you need any such web-based information system 
 * my email address ccc19800408-phpletter(@)yahoo(dot)com(dot)cn
 * please replace (@) with @, (dot) with . when sending email to me
 * thanks.
 * @author logan cai 
 * @package FireForm a  Ajax Form Builder
 * @version 1.0
 * 
 *
 */
	
		/**
		 * convert mysql date string to user friendly format
		 *
		 * @param string $date
		 * @return string
		 */
		function strDate($date)
		{
			return date(CMM_DATE_FORMAT, @strtotime($date));
		}
		/**
		 * convert mysql date time string to user friendly format
		 *
		 * @param string $datetime
		 * @return string
		 */		
		function strDateTime($datetime)
		{
			return date(CMM_DATE_TIME_FORMAT, @strtotime($datetime));
		}	


		