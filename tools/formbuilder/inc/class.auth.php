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
	class Auth
	{
		public  $db;
		public  $msg;
		public $__loginIndex = 'frontenduser_';
		public $__returnTimesIndex = 'return_times';
		public $__cookieLifeTime = 31536000;
		public $__cookieEnable = false;
		public $__cookieChecked = false;
		public $__tableName = '';






		/**
		 * countruction
		 *
		 * @param object $db
		 * @param object $msg
		 * @return Auth
		 */
		public function __construct(&$db, $tableName = 'survey_user')
		{
			$this->db = &$db;
			$this->msg = &$msg;
			if(!isset($_SESSION[$this->__loginIndex]))
			{
				$_SESSION[$this->__loginIndex] = array();
			}
			$this->__tableName = $tableName;


		}
		/**
		 * enalbe to use cookie the keep userid
		 *
		 * @param integer $cookieLiftTime
		 */
		public function enableCookie($cookieLiftTime = 31536000)
		{
			$this->__cookieEnable = true;
			$this->__cookieLifeTime = $cookieLiftTime;
		}
		/**
		 * check if the user has logged in
		 *
		 * @return boolean
		 */
		public function isLogin()
		{
		   	//return true;
			if(!empty($_SESSION[$this->__loginIndex]) && !empty($_SESSION[$this->__loginIndex]['id']))
			{
				return true;
			}else
			{
				if(!$this->__cookieChecked  && $this->__cookieEnable && $this->getUserIdFromCookie() !== false)
				{
					$this->__cookieChecked = true;
					$_SESSION[$this->__loginIndex]['id'] = $this->getUserIdFromCookie();
					$this->refreshLoginStatus();
					return $this->isLogin();
				}else
				{
					$this->__clearCookieStatus();
				}

			}
			return false;
		}
		/**
		 * log out
		 *
		 */
		public function logout()
		{
			$this->__clearLoginStatus();
		}
		/**
		 * clear the login status
		 *
		 */
		public function __clearLoginStatus()
		{
			$_SESSION[$this->__loginIndex] = array();
			if($this->__cookieEnable)
			{
				$this->__clearCookieStatus();
			}
		}
		/**
		 * remove the cookie
		 *
		 */
		public function __clearCookieStatus()
		{
			if(isset($_COOKIE[$this->__loginIndex]))
			{
				unset($_COOKIE[$this->__loginIndex]);
			}
		}
		/**
		 * process login
		 *
		 * @param string $username
		 * @param string $password
		 * @param mix $userGroups
		 * @return boolean
		 */
		public function processLogin($username, $password, $rememberLogin=false )
		{

			$query = "SELECT * FROM " . $this->__tableName . "
			WHERE username=" . $this->db->quote($username, 'text') . " AND password=" . $this->db->quote(md5($password), 'text');
			$this->db->setLimit(1);
			if(($result = $this->db->query($query)) && $result->numrows())
			{
				$row = strip_slashes($result->fetchrow());
				foreach($row as $k=>$v)
				{
					$_SESSION[$this->__loginIndex][$k] = $v;
				}
				if($rememberLogin)
				{
					$this->setCookieLoginStatus();
				}elseif($this->__cookieEnable)
				{
					$this->__clearCookieStatus();
				}
				return true;
			}else
			{
				return false;
			}

		}

		public function setCookieLoginStatus()
		{
			setcookie($this->__loginIndex, $this->getUserId() . md5($this->getUserId()), $this->__cookieLifeTime, "/");
		}
		/**
		 * get user id from cookie
		 *
		 * @return integer / boolean
		 */
		public function getUserIdFromCookie()
		{
			if(isset($_COOKIE[$this->__loginIndex]) && strlen($_COOKIE[$this->__loginIndex]) > 32)
			{
				return substr($_COOKIE[$this->__loginIndex], 1, strlen($_COOKIE[$this->__loginIndex])-32);
			}else
			{
				return false;
			}
		}
		/**
		 * renew the login status when the user details has been updated
		 *
		 */
		public function refreshLoginStatus($id=null)
		{
			$id = (is_null($id)?$this->getUserId():$id);
			$query = "SELECT * FROM " . $this->__tableName .  " WHERE id=" . $this->db->quote($id, 'integer');

			$this->db->setLimit(1);
			if(($result = $this->db->query($query)) && $result->numrows())
			{
				$row = strip_slashes($result->fetchrow());
				foreach($row as $k=>$v)
				{
					$_SESSION[$this->__loginIndex][$k] = $v;
				}
				return true;
			}else
			{
				return false;
			}
		}



		/**
		 * get username
		 *
		 * @return string
		 */

		public function getUsername()
		{
			return $this->getUserInfo('username');
		}

		/**
		 * get first name
		 *
		 * @return string
		 */
		public function getFirstName()
		{
			return $this->getUserInfo('first_name');
		}

		/**
		 * get last name
		 *
		 * @return string
		 */
		public function getLastName()
		{
			return $this->getUserInfo('last_name');
		}

		/**
		 * get user id
		 *
		 * @return integer
		 */
		public function getUserId()
		{
			return $this->getUserInfo('id');
		}
		/**
		 * get full user information
		 *
		 */
		public function getFullUserInfo($userId = null)
		{
			$userId = (is_null($userId)?$this->getUserId():$userId);
			$query = "SELECT * FROM " . $this->__tableName . " WHERE id=" . $this->db->quote($userId, 'integer') ;
			$this->db->setLimit(1);
			$row = array();
			if(($result = $this->db->query($query)))
			{
				$row = strip_slashes($result->fetchrow());
			}
			return $row;
		}

		public function getUserInfo($key=null)
		{
			if(is_null($key))
			{
				if(isset($_SESSION[$this->__loginIndex]))
				{
					return $_SESSION[$this->__loginIndex];
				}
			}else
			{
				return (isset($_SESSION[$this->__loginIndex][$key])?$_SESSION[$this->__loginIndex][$key]:'');
			}

		}
		/**
		 * check if this user is a type of super admin
		 *
		 * @return boolean
		 */
		public function isSuperAdmin()
		{
			return ($this->getUserInfo('is_super_admin')?true:false);
		}


	}
