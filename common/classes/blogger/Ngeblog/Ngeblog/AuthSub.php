<?php
/**
 * Class for manipulating Blogger (http://www.blogger.com) using Google Data (GData) API
 *
 * PHP versions 5
 *
 * @category   Ngeblog
 * @package    Ngeblog_AuthSub
 * @author     Eris Ristemena <eristemena@ngoprekweb.com>
 * @license    http://www.gnu.org/copyleft/lesser.html  GNU LGPL 2.1
 * @link       http://www.ngoprekweb.com/tags/ngeblog
 */
 
/**
 * Ngeblog
 */
require_once 'Ngeblog.php';


/**
 * Wrapper around Zend_Gdata_AuthSub 
 */
class Ngeblog_AuthSub {
        
        const AUTHSUBREQUEST_URI                = 'https://www.google.com/accounts/AuthSubRequest';

         /**
          * Creates a URI to request a single-use AuthSub token.
          *
          * @param int $secure (optional) Boolean flag indicating whether the authentication
          *  transaction should issue a secure token (1) or a non-secure token (0). Secure tokens
          *  are available to registered applications only.
          * @param int $session (optional) Boolean flag indicating whether the one-time-use 
          *  token may be exchanged for a session token (1) or not (0).
          */
         static public function getAuthSubTokenUri($secure=0,$session=1){
                $next   = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
                $scope  = 'http://beta.blogger.com/feeds';
                
                $querystring = '?next='.urlencode($next).'&scope='.urldecode($scope).
                                                '&secure='.urlencode($secure).'&session='.urlencode($session);
                
                return self::AUTHSUBREQUEST_URI.$querystring;
         } 
        
        
        /**
          * Upgrades a single use token to a session token
          *
          * @param string $token
          */
         static public function getAuthSubSessionToken($token) {
                return Zend_Gdata_AuthSub::getAuthSubSessionToken($token);
         }
         
         /**
          * Revoke a token
          *
          * @param string $token
          * @return boolean
          */
         static public function AuthSubRevokeToken($token){
                return Zend_Gdata_AuthSub::AuthSubRevokeToken($token);
         }
        
        static public function connect($token,$blogid=0) {
          $auth_header = 'AuthSub token="' . $token . '"';
          $myblog = new Ngeblog('','',$blogid,$auth_header);
          
          return $myblog;
        }
         
}
