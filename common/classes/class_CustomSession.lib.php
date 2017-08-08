<?php
/**
 * To handle sessions
 *
 * This file is having CustomSession class to handle sessions.
 *
 * PHP version 5.0
 *
 * @category	###Framework###
 * @package		###Common/Classes###
 * @author 		rajesh_04ag02
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		SVN: $Id: class_CustomSession.lib.php 170 2008-04-02 09:49:23Z vidhya_29ag04 $
 * @since 		2004-04-02
 */
//Custom Session using MySQL table
//include config.inc.php for $Db_Link & $Tbl_Sessions
//$sess = new CustomSession($Db_Link, $Tbl_Sessions);
//------------------- Class CustomSession begins ------------------->>>>>//
/**
 * This class is used to handle the session
 *
 * <b>Class overview</b>
 *
 * This class is for handling the sessions to read, write and destroy the
 * current user sessions details.
 *
 * <b>Methods overview</b>
 *
 * CustomSession class is having various methods to read, writ and destroy
 * the sessions.
 *
 * <b>How to use this class</b>
 *
 * Create a new object for this class. Then call the methods in the class
 * using that object
 *
 * @category	###FrameWork###
 * @package		###Common/Classes###
 * @author 		###rajesh_04ag02###
 * @copyright 	Copyright (c) 2008 {@link http://www.mediabox.uz Uzdc Infoway}
 * @license		http://www.mediabox.uz Uzdc Infoway Licence
 * @version		Release: @package_version@
 * @since 		2004-04-02
 */
//<<<<<------------------ Class CustomSession ends --------------------//
class CustomSession
	{
		/**
		 * @var	object database object
		 */
		private $db;
		/**
		 * @var	string table name
		 */
		private $table_name;
		/**
		 * @var	string garbage maximum life time
		 */
		private $sess_gc_maxlifetime;
		//additional variables for Online User part...
		/**
		 * @var	string total of guest + members
		 */
		private $num_online_visitors;
		/**
		 * @var	string number of guests
		 */
		private $num_online_guests;
		/**
		 * @var	string number of members
		 */
		private $num_online_members;

		/**
		 * Customize session
		 *
		 * @param		object $db_link database link
		 * @param		string $session_table_name session table name
		 * @return 		void
		 * @access		public
		 */
		public function CustomSession($db_link, $session_table_name='sessions')	//constructor
			{
				$this->db = $db_link;
				$this->table_name = $session_table_name;
				$this->_setINI();
				$this->sess_gc_maxlifetime = ini_get('session.gc_maxlifetime');
				//add session handler...
				//reference http://in.php.net/session_set_save_handler
				//No idea about array things...
				session_set_save_handler( array( &$this, '_sess_open' ),
											array( &$this, '_sess_close' ),
											array( &$this, '_sess_read' ),
											array( &$this, '_sess_write' ),
											array( &$this, '_sess_destroy' ),
											array( &$this, '_sess_gc' ) );
				//also start the session...
				session_start();
				//initialize online users count...
				$this->_updateOnlineUsersCount();
				//$this->num_online_visitors = 0;
				//$this->num_online_guests = 0;
				//$this->num_online_members = 0;
			}

		/**
		 * session ini settings
		 *
		 * @return 		void
		 * @access		private
		 */
		private function _setINI()
			{
				ini_set('session.save_handler', 'user');
				//The following settings are not necessary...
				//ini_set('session.name', 'PHPSESSID' );
				//ini_set('session.use_cookies', 1);
				//ini_set('session.gc_maxlifetime', 1440);
				//ini_set('session.gc_probability', 1);
				//ini_set('session.use_only_cookies', 0);
			}

		/**
		 * Open session
		 *
		 * @param	    string $dummy_save_path dummy save path
		 * @param		string $dummy_session_name dummy session name
		 * @return 		boolean true/false
		 * @access		private
		 */
		private function _sess_open($dummy_save_path, $dummy_session_name)
			{
				return( true );
			}

		/**
		 * Session close
		 *
		 * @return 		boolean true
		 * @access		private
		 */
		private function _sess_close()
			{
				return( true );
			}

		/**
		 * Read session
		 *
		 * @param	    string $session_id session id
		 * @return 		string
		 * @access		private
		 */
		private function _sess_read($session_id)
			{
				$sql = 'SELECT data FROM '.$this->table_name.' WHERE ' .
					   'session_id=\''.$session_id.'\' AND expires>=UNIX_TIMESTAMP()';
				$result = mysql_query($sql, $this->db);
				if (mysql_num_rows($result)>0)
					{
						$row = mysql_fetch_assoc($result);
						$ret_val = $row['data'];
					}
				  else
						{
					  		//http://www.phpbuilder.com/annotate/message.php3?id=1009034
							//delete expired session...if garbage collection is not running...
							$sql = 'DELETE FROM '.$this->table_name.' WHERE expires<UNIX_TIMESTAMP()';
							$result = mysql_query($sql, $this->db);
					  		$ret_val = '';   //as by note @ http://in.php.net/session_set_save_handler
						}
				return( $ret_val );
			}

		/**
		 * Write session
		 *
 		 * @param	    string $session_id session id
		 * @param	    string $data data
		 * @return 		string
		 * @access		private
		 */
		private function _sess_write($session_id, $data)
			{
				$data = addslashes($data);
				//REPLACE INTO for update or insert logic...
				$sql = 'REPLACE INTO '.$this->table_name.' SET ' .
						'session_id=\''.$session_id.'\', ' .
						'expires=UNIX_TIMESTAMP()+'.$this->sess_gc_maxlifetime.', ' .
						'data=\''.$data.'\'';
				return( mysql_query($sql, $this->db) );
			}

		/**
		 * Destroy session
		 *
 		 * @param	    string $session_id session id
		 * @return 		string
		 * @access		private
		 */
		private function _sess_destroy($session_id)
			{
				$sql = 'DELETE FROM '.$this->table_name.' WHERE session_id=\''.$session_id.'\'';
				return( mysql_query($sql, $this->db) );
			}

		/**
		 * Session garbage collection
		 *
		 * @param	    string $dummy_gc_maxlifetime dummy garbage collection maximum life time
		 * @return 		string
		 * @access		private
		 */
		private function _sess_gc($dummy_gc_maxlifetime)
			{
				$sql = 'DELETE FROM '.$this->table_name.' WHERE expires<UNIX_TIMESTAMP()';
				return( mysql_query($sql, $this->db) );
			}

		//Additional methods to handle online visitors...
		/**
		 * Update online user count
		 *
		 * @return 		void
		 * @access		private
		 */
		private function _updateOnlineUsersCount()
			{
				//total visitors...
				$sql = 'SELECT COUNT(*) FROM '.$this->table_name;
				$result = mysql_query($sql, $this->db);
				$this->num_online_visitors = mysql_result($result, 0); //total
				//total online logged in members...
				$sql = 'SELECT COUNT(*) FROM '.$this->table_name.' WHERE INSTR(data, \'sn_logged\')';
				$result = mysql_query($sql, $this->db);
				$this->num_online_members = mysql_result($result, 0);
				//guests = total - members...
				$this->num_online_guests = $this->num_online_visitors - $this->num_online_members;
			}

		/**
		 * Gets number of online visitors
		 *
		 * @return 		integer
		 * @access		public
		 */
		public function getNumOnlineVisitors()
			{
				return( $this->num_online_visitors );
			}

		/**
		 * Gets number of online members
		 *
		 * @return 		integer
		 * @access		public
		 */
		public function getNumOnlineMembers()
			{
				return( $this->num_online_members );
			}

		/**
		 * Gets number of online guests
		 *
		 * @return 		integer
		 * @access		public
		 */
		public function getNumOnlineGuests()
			{
				return( $this->num_online_guests );
			}

		/**
		 * Checks session active
		 *
		 * @param	    string $session_id session id
		 * @return 		void
		 * @access		public
		 */
		public function isSessionActive($session_id)
			{
				$sql = 'SELECT COUNT(*) FROM '.$this->table_name.' WHERE session_id=\''.$session_id.'\'';
				$result = mysql_query($sql, $this->db);
				$num_sessions = mysql_result($result, 0);
				return( $num_sessions!=0 );
			}
	}
?>