<?php
/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to version 1.0 of the Zend Framework
 * license, that is bundled with this package in the file LICENSE,
 * and is available through the world-wide-web at the following URL:
 * http://www.zend.com/license/framework/1_0.txt. If you did not
 * receive a copy of the Zend Framework license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * license@zend.com so we can mail you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Http
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com/)
 * @license    http://www.zend.com/license/framework/1_0.txt Zend Framework License version 1.0
 */

require_once "Zend.php";
require_once "Zend/Uri.php";
require_once "Zend/Http/Exception.php";

/**
 * Zend_Http_Cookie is a class describing an HTTP cookie and all it's parameters.
 *
 * Zend_Http_Cookie is a class describing an HTTP cookie and all it's parameters. The
 * class also enables validating whether the cookie should be sent to the server in
 * a specified scenario according to the request URI, the expiry time and whether
 * session cookies should be used or not. Generally speaking cookies should be
 * contained in a Cookiejar object, or instantiated manually and added to an HTTP
 * request.
 *
 * See http://wp.netscape.com/newsref/std/cookie_spec.html for some specs.
 *
 * @category    Zend
 * @package     Zend_Http
 * @copyright   Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com/)
 * @license     http://www.zend.com/license/framework/1_0.txt Zend Framework License version 1.0
 */
class Zend_Http_Cookie
{    
    /**
     * Cookie name
     *
     * @var string
     */
    protected $name;
   
    /**
     * Cookie value
     *
     * @var string
     */
    protected $value;
   
    /**
     * Cookie expiry date
     *
     * @var int
     */
    protected $expires;
   
    /**
     * Cookie domain
     *
     * @var string
     */
    protected $domain;
   
    /**
     * Cookie path
     *
     * @var string
     */
    protected $path;
   
    /**
     * Whether the cookie is secure or not
     *
     * @var boolean
     */
    protected $secure;
   
    /**
     * Cookie object constructor
     *
     * @todo Add validation of each one of the parameters (legal domain, etc.)
     *  
     * @param string $name
     * @param string $value
     * @param int $expires
     * @param string $domain
     * @param string $path
     * @param bool $secure
     */
    public function __construct($name, $value, $domain, $expires = null, $path = null, $secure = false)
    {
        if (preg_match("/[=,; \t\r\n\013\014]/", $name))
            return false;//commented by selvaraj//throw new Zend_Http_Exception("Cookie name cannot contain these characters: =,; \\t\\r\\n\\013\\014 ({$name})");

        if (! $this->name = (string) $name)
            return false;//commented by selvaraj//throw new Zend_Http_Exception('Cookies must have a name');

        if (! $this->domain = (string) $domain)
            return false;//commented by selvaraj//throw new Zend_Http_Exception('Cookies must have a domain');

        $this->value = (string) $value;
        $this->expires = (is_null($expires) ? null : (int) $expires);
        $this->path = ($path ? $path : '/');
        $this->secure = $secure;
    }
   
    /**
     * Get Cookie name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
   
    /**
     * Get cookie value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }
   
    /**
     * Get cookie domain
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
   
    /**
     * Get the cookie path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }
   
    /**
     * Get the expiry time of the cookie, or null if no expiry time is set
     *
     * @return int|null
     */
    public function getExpiryTime()
    {
        return $this->expires;
    }
   
    /**
     * Check whether the cookie should only be sent over secure connections
     *
     * @return boolean
     */
    public function isSecure()
    {
        return $this->secure;
    }
   
    /**
     * Check whether the cookie has expired
     *
     * Always returns true if the cookie is a session cookie (has no expiry time)
     *
     * @param int $now Timestamp to consider as "now"
     * @return boolean
     */
    public function isExpired($now = null)
    {
        if (is_null($now)) $now = time();
        if (is_int($this->expires) && $this->expires < $now) {
            return true;
        } else {
            return false;
        }
    }
   
    /**
     * Check whether the cookie is a session cookie (has no expiry time set)
     *
     * @return boolean
     */
    public function isSessionCookie()
    {
        return (is_null($this->expires));
    }
   
    /**
         * Get the cookie as a string, suitable for sending as a "Cookie" header in an
         * HTTP request
         *
         * @return string
         */
        public function asString()
        {
                return "{$this->name}={$this->value}; ";
        }
       
        /**
         * Checks whether the cookie should be sent on not in a specific scenario
         *
         * @param string|Zend_Uri_Http $uri URI to check against (secure, domain, path)
         * @param boolean $matchSessionCookies Whether to send session cookies
         * @param int $now Override the current time when checking for expiry time
         * @return boolean
         */
        public function match($uri, $matchSessionCookies = true, $now = null)
        {
                if (is_string ($uri)) {
            $uri = Zend_Uri_Http::factory($uri);
        }
       
        // Make sure we have a valid Zend_Uri_Http object
        if (! ($uri->valid() && ($uri->getScheme() == 'http' || $uri->getScheme() =='https')))
                return false;//commented by selvaraj//throw new Zend_Http_Exception('Passed URI is not a valid HTTP or HTTPS URI');
       
        // Check that the cookie is secure (if required) and not expired
        if ($this->isSecure() && $uri->getScheme() != 'https') return false;
        if ($this->isExpired($now)) return false;
        if ($this->isSessionCookie() && ! $matchSessionCookies) return false;
       
        // Validate domain and path
        // Domain is validated using tail match, while path is validated using head match
        $domain_preg = preg_quote($this->getDomain(), "/");
        if (! preg_match("/{$domain_preg}$/", $uri->getHost())) return false;
        $path_preg = preg_quote($this->getPath(), "/");
        if (! preg_match("/^{$path_preg}/", $uri->getPath())) return false;
       
        // If we didn't die until now, return true.
                return true;
        }
   
    /**
     * Generate a new Cookie object from a cookie string
     * (for example the value of the Set-Cookie HTTP header)
     *
     * @param string $cookieStr
     * @param Zend_Uri_Http|string $ref_uri Reference URI for default values (domain, path)
     * @return Zend_Http_Cookie A new Zend_Http_Cookie object or false on failure.
     */
    static public function factory($cookieStr, $ref_uri = null)
    {
        // Set default values
        if (is_string($ref_uri)) {
            $ref_uri = Zend_Uri_Http::factory($ref_uri);
        }
       
        $name = null;
        $value = null;
        $expires = null;
        $domain = null;
        $path = null;
        $secure = false;


        if ($ref_uri instanceof Zend_Uri_Http) {
            $domain = $ref_uri->getHost();
            $path = dirname($ref_uri->getPath());
        }

        foreach (explode(';', $cookieStr ) as $part) {
            $part = trim($part);
            if (strtolower($part) == 'secure') {
                $secure = true;
                continue;
            }
           
            list($k, $v) = explode('=', $part);
            if (isset($k) && isset($v))    {
                switch ($k)    {
                    case 'expires':
                        $expires = strtotime($v);
                        break;
                    case 'path':
                        $path = $v;
                        break;
                    case 'domain':
                        $domain = $v;
                        break;
                    default:
                        $name = $k;
                        $value = $v;
                        break;
                }
            }
        }
       
        if ($name && isset($value)) {
            return new Zend_Http_Cookie($name, $value, $domain, $expires, $path, $secure);
        } else {
            return false;
        }
    }
}
