<?php
/**
 * Class for manipulating Blogger (http://www.blogger.com) using Google Data (GData) API
 *
 * PHP versions 5
 *
 * @category   Ngeblog
 * @package    Ngeblog_ClientLogin
 * @author     Eris Ristemena <eristemena@ngoprekweb.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  GNU LGPL 2.1
 * @link       http://www.ngoprekweb.com/tags/ngeblog
 */
 
/**
 * Ngeblog
 */
require_once 'Ngeblog.php';

/**
 * Wrapper around Zend_Gdata_ClientLogin
 */
class Ngeblog_ClientLogin {
        
         const CLIENTLOGIN_SOURCE = 'Ngoprekweb-Ngeblog-0.2';
         const CLIENTLOGIN_SERVICE = 'blogger';
         
         /**
          * Get Google ClientLogin Auth code.
          *
          */
         static public function getClientLoginAuth($username,$password,$logintoken='',$logincaptcha='') {
          return Zend_Gdata_ClientLogin::getClientLoginAuth($username,$password,self::CLIENTLOGIN_SERVICE,self::CLIENTLOGIN_SOURCE,$logintoken,$logincaptcha);
         }
        
        static public function connect($token,$blogid=0) {
          $auth_header = 'GoogleLogin auth=' . $token;
          $myblog = new Ngeblog('','',$blogid,$auth_header);
          
          return $myblog;
        }
        
}
