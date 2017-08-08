<?php
/**
 * Class for handling user details
 *
 * This is having class User to get the user details like user current ip,
 * user status and password etc.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author 		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2006-03-17
 */
//------------------- Class User begins ------------------->>>>>//
/**
 * Class for handling the logged in user details
 *
 * <b>Class overview</b>
 *
 * User class is to handle the user details for getting the user password,
 * user status, user IP.
 *
 * <b>Methods overview</b>
 *
 * This class is having _getCurrentIP method to get the current IP, isUserExists
 * method to check whether the user exists, getUserStatus method to get the user
 * status, isValidUser method to check whether the user is valid, isValidSession
 * method for valid session, _getUserInfo method to get the user info.
 *
 * <b>How to use this class</b>
 *
 * Create a new object for this class. Then call the corresponding methods to
 * get the user details.
 *
 * <b>Table structure</b>
 *
 * <pre>
 * CREATE TABLE IF NOT EXISTS users (
 * 	  user_id bigint(20) NOT NULL auto_increment,
 * 	  user_name varchar(80) collate latin1_general_ci NOT NULL default '',
 * 	  `password` varchar(40) collate latin1_general_ci NOT NULL default '',
 * 	  email varchar(80) collate latin1_general_ci NOT NULL default '',
 * 	  first_name varchar(100) collate latin1_general_ci NOT NULL default '',
 * 	  last_name varchar(100) collate latin1_general_ci NOT NULL default '',
 * 	  phone varchar(30) collate latin1_general_ci NOT NULL default '',
 * 	  fax varchar(30) collate latin1_general_ci NOT NULL default '',
 * 	  address varchar(100) collate latin1_general_ci NOT NULL default '',
 * 	  city varchar(50) collate latin1_general_ci NOT NULL default '',
 * 	  state varchar(50) collate latin1_general_ci NOT NULL default '',
 * 	  country char(3) collate latin1_general_ci NOT NULL default '--',
 * 	  verification_level tinyint(4) NOT NULL default '0',
 * 	  usr_status enum('0-Ok','1-ToActivate','2-Locked')
 *    collate latin1_general_ci NOT NULL default '1-ToActivate',
 * 	  doj datetime NOT NULL default '0000-00-00 00:00:00',
 * 	  date_of_activation datetime NOT NULL,
 * 	  last_logged datetime default NULL,
 * 	  num_visits int(11) NOT NULL default '0',
 * 	  cookie varchar(32) character set latin1 collate latin1_bin NOT NULL default '',
 * 	  `session` varchar(32) character set latin1 collate latin1_bin NOT NULL default '',
 * 	  ip varchar(15) character set latin1 collate latin1_bin NOT NULL default '',
 * 	  signup_ip varchar(15) character set latin1 collate latin1_bin NOT NULL default '',
 * 	  time_zone tinyint(4) NOT NULL default '0',
 * 	  pref_lang varchar(10) collate latin1_general_ci NOT NULL default '',
 * 	  PRIMARY KEY  (user_id),
 * 	  UNIQUE KEY email (user_name),
 * 	  KEY user_id (user_id)
 * 	) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci COMMENT='Prime table about user';
 * </pre>
 *
 * <b>Sample data</b>
 *
 * <pre>
 * INSERT users SET
 * 	user_id = 1,
 * 	user_name = 'asdas',
 * 	password = 'asdas',
 * 	email = 'asdasd@yah.com',
 * 	first_name = 'asdasda',
 * 	last_name = 'sdasda',
 * 	phone = 'sdasd',
 * 	fax = 'asdasd',
 * 	address = 'asdasda',
 * 	city = 'sdasdas',
 * 	state = 'dasdas',
 * 	country = 'BN',
 * 	verification_level = 0,
 * 	usr_status = '1-ToActivate',
 * 	doj = '2005-04-13 17:31:53',
 * 	date_of_activation = '0000-00-00 00:00:00',
 * 	last_logged = '2006-01-31 11:48:50',
 * 	num_visits = 6,
 * 	cookie = '',
 * 	session = 0x3664343739363936633965393731666336313264306434393166303763313934,
 * 	ip = 0x3132372e302e302e31,
 * 	signup_ip = '',
 * 	time_zone = 0,
 * 	pref_lang = '' ;,
 * </pre>
 *
 * @category	###Framework###
 * @package	    ###Common/Classes###
 * @author 	    ###rajesh_04ag02###
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license	    http://www.mediabox.uz Uzdc Infoway Licence
 * @version	    Release: @package_version@
 * @since 		2006-03-17
 */
class User
	{

		/**
		 * @var		object database object
		 */
		protected $db;
		/**
		 * @var		array hash array to hold user information
		 */
		protected $user_info = array();

	   /**
		* Constructor
		*
		* When object is initiated, constructor method is called immediately.
		*
		* @return 		void
		* @access 		public
		*/
		public function __construct()
			{
				global $Db_Link;
				$this->db = $Db_Link;
			}

		/**
		 * To get the user current IP
		 *
		 * @return 		string IP address
		 * @access		private
		 */
		private function _getCurrentIP()
			{
			   if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown"))
			            $ip = getenv("HTTP_CLIENT_IP");
			        else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown"))
			            $ip = getenv("HTTP_X_FORWARDED_FOR");
			        else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown"))
			            $ip = getenv("REMOTE_ADDR");
			        else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown"))
			            $ip = $_SERVER['REMOTE_ADDR'];
			        else
			            $ip = "unknown";
			    return($ip);
			}

		/**
		 * To check whether the user exists
		 *
		 * @param		string username of the user
		 * @return 		true/false
		 * @access		public
		 */
		public function isUserExists($username)
			{
				global $Tbl_User_Info;
				$sql = "SELECT COUNT(*) FROM " . $Tbl_User_Info . " WHERE username='".$username."'";
				$result = mysql_query($sql, $this->db);
				if (!$result)
						die("Query Error at isUserExists()" . mysql_error($this->db));
				$num_of_users = mysql_result($result, 0);
				return (($num_of_users!=0)); //user exists if $number_of_users!=0
			}

		/**
		 * To get the user status
		 *
		 * @param		string username of the user
		 * @return 		string user status
		 * @access		public
		 */
		public function getUserStatus($username)
			{
				global $Tbl_User_Info;
				$sql = "SELECT usr_status FROM " . $Tbl_User_Info . " WHERE username='".$username."'";
				$result = mysql_query($sql, $this->db);
				return(mysql_result($result, 0));
			}

		/**
		 * To get the user password
		 *
		 * @param		string username of the user
		 * @return 		string password of the user
		 * @access		public
		 */
		public function getUserPassword($username)
			{
				global $Tbl_User_Info;
				$sql = "SELECT password FROM ".$Tbl_User_Info." WHERE username='".$username."'";
				$result = mysql_query($sql, $this->db);
				return(mysql_result($result, 0));
			}

		/**
		 * To check whether the user is valid
		 *
		 * @param		string username of the user
		 * @param		string password of the user
		 * @param		string turing number when login
		 * @return 		string error number
		 * @access		public
		 */
		public function isValidUser($username, $password, $turing)
			{
				global $Tbl_User_Info;
				$err_val = 0; //0-No error
				//query...
				$sql = "SELECT * FROM " . $Tbl_User_Info . " WHERE username='".$username."'";
				$result = mysql_query($sql, $this->db);
				if (!$result)
						die("Query Error at isValidUser()" . mysql_error($this->db));
				if ( (!isset($_SESSION['sn_turing'])) || $_SESSION['sn_turing']!=$turing )
						$err_val = 9;	//invalid turing text
					else if (mysql_num_rows($result)==0)
						$err_val = 3;	//no user ie, invalid username
					else
						{
							$row = mysql_fetch_assoc($result);
							if ($row['password']!=$password)
									$err_val = 4;	//invalid password
								else if ($row['usr_status']!=0)
									$err_val = intval($row['usr_status']);	//user status is not Ok
						}
				if (isset($_SESSION['sn_turing']))
						unset($_SESSION['sn_turing']);	//reset turing session value
				return($err_val);
			}

		/**
		 * To check whether the session is valid
		 *
		 * @return 		string error value
		 * @access		public
		 */
		public function isValidSession()
			{
				global $Tbl_User_Info;
				$err_val = 0; //0-No error
				if (isset($_SESSION['sn_logged'])) //if session found, check its validity (may be fake)
					{
						//query...
						$sql = "SELECT * FROM " . $Tbl_User_Info . " WHERE id='".$_SESSION['sn_uid']."'";
						$result = mysql_query($sql, $this->db);
						if (!$result)
							die("Query Error at isValidSession()" . mysql_error($this->db));
						if (mysql_num_rows($result)==0)
								$err_val = 5;	//No user for $_SESSION['sn_uid']
							else
								{
									$row = mysql_fetch_assoc($result);
									if ($row['usr_status']!=0)
											$err_val = intval($row['usr_status']);
										else
											{
												$ip = $row['ip'];
												$session = $row['session'];
												if ($ip!=$this->_getCurrentIP())
														$err_val = 6;	//ip address conflict...User logged in another system
													else if ($session!=session_id())
														$err_val = 7; //invalid session. Session expired.
											}
								}
					}
				   else if (isset($_COOKIE['sn_login_cookie'])) //additional check so that to correctly prompt session expire
				   		$err_val = 7; //Session expired.
				   	else
				   		$err_val = 8; //error not logged in (ie, no session found)
				return($err_val);
			}

		/**
		 * To get the user information
		 *
		 * @param		string username oftyhe user
		 * @return 		void
		 * @access		private
		 */
		private function _getUserInfo($username)
			{
				global $Tbl_User_Info;
				//query...
				$sql = "SELECT * FROM " . $Tbl_User_Info . " WHERE username='".$username."'";
				$result = mysql_query($sql, $this->db);
				if (!$result)
						die("Query Error at _getUserInfo()" . mysql_error($this->db));
				$row = mysql_fetch_assoc($result);
				//get it in user_info array...
				foreach($row as $key => $value)
						$this->user_info[$key] = $value;
			}

		/**
		 * To login of the user
		 *
		 * @param		string username of the user
		 * @param		string login URL
		 * @return 		void
		 * @access		public
		 */
		public function doLogin($username, $login2url)
			{
				global $Tbl_User_Info;
				$this->_getUserInfo($username);
				//set session variables...
				$_SESSION['sn_logged'] = true;
				$_SESSION['sn_uid'] = $this->user_info['id'];
				$_SESSION['sn_username'] = $this->user_info['username'];
				$_SESSION['sn_email'] = $this->user_info['email'];
				$_SESSION['sn_name'] = $this->user_info['name'];
				$_SESSION['sn_egold_account'] = $this->user_info['egold_account'];
				$_SESSION['sn_last_logged'] = $this->user_info['last_logged'];
				$_SESSION['sn_doj'] = $this->user_info['doj'];
				$_SESSION['sn_num_visits'] = $this->user_info['num_visits'];
				$_SESSION['sn_last_ip'] = $this->user_info['ip'];
				//set cookie flag so that to prompt session expire correctly....
				setcookie('sn_login_cookie', '1', 0, '/');
				//update database with ip address, login time, num_visits, session id...
				$ip = $this->_getCurrentIP();
				$session = session_id();
				$sql = 	"UPDATE " .	$Tbl_User_Info . " SET last_logged=NOW(), " .
						"num_visits=num_visits + 1 , " .
						"ip='".$ip."', " .
						"session='".$session."' " .
						"WHERE id='".$_SESSION['sn_uid']."'";
				$result = mysql_query($sql, $this->db);
				if (!$result)
						die( "UPDATE Query error at doLogin()" . mysql_error($this->db));
				if (isset($_COOKIE['url']))
						Redirect2URL($_COOKIE['url']);
					else
						Redirect2URL($login2url);
			}

		/**
		 * To check whether the user is logged in
		 *
		 * @return 		boolean 0/1
		 * @access		public
		 */
		public function isUserLogined()
			{
				return(isset($_SESSION['sn_logged']));
			}

		/**
		 * To logout of the current user
		 *
		 * @return 		void
		 * @access		public
		 */
		public function doLogout()
			{
				global $Tbl_User_Info;
				//clean up the session value in DB. Added for correcting Online status of user
				$sql = 	"UPDATE ".$Tbl_User_Info." SET ".
						"session='' WHERE id='".$_SESSION['sn_uid']."'";
				@mysql_query($sql, $this->db); //ignore any errors
				//clear session variables...
				// Unset session data
				$_SESSION=array();
				// Clear cookie
				if (isset($_COOKIE[session_name()]))
						unset($_COOKIE[session_name()]);
				//Without unset, the session ident remains the same...
				if (isset($_REQUEST[session_name()]))
						unset($_REQUEST[session_name()]);
				//delete url cookie...
				setcookie('url', '', time()-60*60*24*30*12, '/');
				//delete login cookie flag...
				setcookie('sn_login_cookie', '', time()-60*60*24*30*12, '/');
				// Destroy session data
				session_destroy();
			}
	}
//<<<<<------------------ Class User ends --------------------//
?>