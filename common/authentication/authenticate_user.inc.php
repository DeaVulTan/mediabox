<?php
/**
*
*
* @	Author			: By Haking Br
* @	Author			: Por Haking Br
* @ Brasil
* @	Release on		:	03.10.2011
*
*/
  if (!(!isset($_SESSION['user']['is_logged_in']) && $CFG['auth']['is_authenticate'] == 'root') && !(in_array($CFG['site']['script_name'], $CFG['auth']['no_authenticate_files']) && !isset($_SESSION['user']['is_logged_in']))) {
      $REDIRECT_URL = '';
      $folder_name  = substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1);
      $_current_url = $CFG['site']['current_url'];
      $_SCRIPT_NAME = $_SERVER['SCRIPT_NAME'];
     
      if (isset($_SESSION['user']['is_logged_in']) && substr_count($CFG['site']['current_url'], $CFG['site']['url'] . 'admin/') ) {

     
            
              $host = $_SERVER['HTTP_HOST'];
              if (strcasecmp('www.', substr($_SERVER['HTTP_HOST'], 0, 4)) == 0) {
                  $host = substr($_SERVER['HTTP_HOST'], 4);
              }     
      }
      if (is_string($CFG['auth']['no_authenticate_folders']) && $CFG['auth']['no_authenticate_folders'] == '*' || is_array($CFG['auth']['no_authenticate_folders']) && in_array(substr($_SERVER['SCRIPT_NAME'], 0, strrpos($_SERVER['SCRIPT_NAME'], '/') + 1), $CFG['auth']['no_authenticate_folders'])) {
          if (!isset($_SESSION['admin']['is_logged_in'])) {
              if (ini_get('session.use_only_cookies') && isset($_COOKIE[session_name()]) || isset($_GET[session_name()])) {
                  $_SESSION                = array();
                  $_SESSION['login_error'] = 'login_err_session_expired';
                  $_SESSION['url']         = urlencode(getCurrentUrl(true));
                  Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
              }
              $_SESSION                = array();
              $_SESSION['login_error'] = 'login_err_authorization_required';
              $_SESSION['url']         = urlencode(getCurrentUrl(true));
              Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
          } else {
              if ($CFG['auth']['session']['strict']['is_check'] && isMember()) {
                  $sql  = 'SELECT ip, session, usr_status FROM ' . $CFG['db']['tbl']['users'] . ' WHERE ' . 'user_id=' . $db->Param('user_id') . " AND usr_status='Ok'";
                  $stmt = $db->Prepare($sql);
                  $rs   = $db->Execute($stmt, array(
                      $_SESSION['user']['user_id']
                  ));
                  if (!$rs) {
                      trigger_db_error($db);
                  }
                  if ($rs->PO_RecordCount() == 0) {
                      $_SESSION                = array();
                      $_SESSION['login_error'] = 'login_err_invalid_user_session';
                      $_SESSION['url']         = urlencode(getCurrentUrl(true));
                      Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
                  }
                  $row = $rs->FetchRow();
                  if ($CFG['auth']['session']['strict']['is_check_session_spoof'] && session_id() != $row['session']) {
                      $_SESSION                = array();
                      $_SESSION['login_error'] = 'login_err_invalid_session';
                      $_SESSION['url']         = urlencode(getCurrentUrl(true));
                      Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
                  }
                  if ($CFG['auth']['session']['strict']['is_check_ip_diff'] && $CFG['remote_client']['ip'] != $row['ip']) {
                      $_SESSION                = array();
                      $_SESSION['login_error'] = 'login_err_wrong_ip';
                      $_SESSION['url']         = urlencode(getCurrentUrl(true));
                      Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
                  }
              } else if ($CFG['auth']['session']['is_check_useragent_diff'] && md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['user']['useragent_hash']) {
                  $_SESSION                = array();
                  $_SESSION['login_error'] = 'login_err_wrong_user_agent';
                  $_SESSION['url']         = urlencode(getCurrentUrl(true));
                  Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
              }
              if (!isset($_SESSION['user']['user_name'])) {
                  $_SESSION                = array();
                  $_SESSION['login_error'] = 'login_err_invalid_user_session';
                  $_SESSION['url']         = urlencode(getCurrentUrl(true));
                  Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
              }
              if (isMember() && isset($_SESSION['url']) && $_SESSION['url']) {
                  $url             = $_SESSION['url'];
                  $_SESSION['url'] = '';
                  Redirect2URL(urldecode($url));
              }
          }
      } else {
          if (isset($_SESSION['user']['is_logged_in']) && $CFG['auth']['is_authenticate'] == 'root') {
              Redirect2URL(getUrl($CFG['auth']['members_url']['file_name'], '', ''));
          } else {
              if (!isset($_SESSION['admin']['is_logged_in']) && isset($_SESSION['user']['membership_expiry_date']) && !isMemberShipValid($_SESSION['user']['membership_expiry_date'])) {
                  unset($this->user['is_logged_in']);
              }
              if (!isset($_SESSION['user']['is_logged_in']) && $CFG['auth']['is_authenticate'] == 'members') {
                  if (isset($REDIRECT_URL) && $REDIRECT_URL != '') {
                      Redirect2URL($REDIRECT_URL);
                  }
                  if (ini_get('session.use_only_cookies') && isset($_COOKIE[session_name()]) || isset($_GET[session_name()])) {
                      $_SESSION                = array();
                      $_SESSION['login_error'] = 'login_err_session_expired';
                      $_SESSION['url']         = urlencode(getCurrentUrl(true));
                      Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
                  }
                  $_SESSION                = array();
                  $_SESSION['login_error'] = 'login_err_authorization_required';
                  $_SESSION['url']         = urlencode(getCurrentUrl(true));
                  Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
              } else {
                  if ($CFG['auth']['session']['strict']['is_check'] && isMember()) {
                      $sql  = 'SELECT ip, session, usr_status FROM ' . $CFG['db']['tbl']['users'] . ' WHERE ' . 'user_id=' . $db->Param('user_id') . " AND usr_status='Ok'";
                      $stmt = $db->Prepare($sql);
                      $rs   = $db->Execute($stmt, array(
                          $_SESSION['user']['user_id']
                      ));
                      if (!$rs) {
                          trigger_db_error($db);
                      }
                      if ($rs->PO_RecordCount() == 0) {
                          $_SESSION                = array();
                          $_SESSION['login_error'] = 'login_err_invalid_user_session';
                          $_SESSION['url']         = urlencode(getCurrentUrl(true));
                          Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
                      }
                      $row = $rs->FetchRow();
                      if ($CFG['auth']['session']['strict']['is_check_session_spoof'] && session_id() != $row['session']) {
                          $_SESSION                = array();
                          $_SESSION['login_error'] = 'login_err_invalid_session';
                          $_SESSION['url']         = urlencode(getCurrentUrl(true));
                          Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
                      }
                      if ($CFG['auth']['session']['strict']['is_check_ip_diff'] && $CFG['remote_client']['ip'] != $row['ip']) {
                          $_SESSION                = array();
                          $_SESSION['login_error'] = 'login_err_wrong_ip';
                          $_SESSION['url']         = urlencode(getCurrentUrl(true));
                          Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
                      }
                  } else if ($CFG['auth']['session']['is_check_useragent_diff'] && md5($_SERVER['HTTP_USER_AGENT']) != $_SESSION['user']['useragent_hash']) {
                      $_SESSION                = array();
                      $_SESSION['login_error'] = 'login_err_wrong_user_agent';
                      $_SESSION['url']         = urlencode(getCurrentUrl(true));
                      Redirect2URL(getUrl($CFG['auth']['login_url']['file_name'], '', '', 'root'));
                  }
                  if (isset($_SESSION['admin']['is_logged_in'])) {
                      $CFG['admin']['is_logged_in'] = $_SESSION['admin']['is_logged_in'];
                  }
                  if (isMember() && isset($_SESSION['url']) && 1 <= strpos(urldecode($_SESSION['url']), 'dmin/') && !$CFG['admin']['is_logged_in']) {
                      $url             = $_SESSION['url'];
                      $_SESSION['url'] = '';
                      Redirect2URL(getUrl($CFG['auth']['members_url']['file_name'], '', '', 'members'));
                  }
                  if (isMember() && isset($_SESSION['url']) && $_SESSION['url']) {
                      $url             = $_SESSION['url'];
                      $_SESSION['url'] = '';
                      Redirect2URL(urldecode($url));
                  }
              }
          }
      }
      if (isset($REDIRECT_URL) && $REDIRECT_URL != '') {
          Redirect2URL($REDIRECT_URL);
      }
      $CFG['site']['current_url'] = $_current_url;
      $_SERVER['SCRIPT_NAME']     = $_SCRIPT_NAME;
  }
  if (!isMember() && !strstr($_SERVER['SCRIPT_NAME'], 'login.php') && isset($_COOKIE[$CFG['cookie']['starting_text'] . '_user_name']) && $_COOKIE[$CFG['cookie']['starting_text'] . '_user_name']) {
      Redirect2URL(getUrl('login', '', '', 'root'));
  }
?>