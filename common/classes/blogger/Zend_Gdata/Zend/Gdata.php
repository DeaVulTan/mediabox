<?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Gdata
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */

/**
 * Zend_Feed
 */
require_once 'Zend/Feed.php';

/**
 * Zend_Gdata_Exception
 */
require_once 'Zend/Gdata/Exception.php';


/**
 * @category   Zend
 * @package    Zend_Gdata
 * @copyright  Copyright (c) 2006 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Gdata {
        
        /**
     * Client object used to communicate
     *
     * @var Zend_Http_Client
     */
    protected $client ;
        
    /**
     * Query parameters.
     *
     * @var array
     */
    protected $params = array();
    
    
    /**
     * Create Gdata object
     *
     * @param Zend_Http_Client $client
     */
    public function __construct(Zend_Http_Client $client) {
        $this->client = $client;
    }
    
    /**
     * Sets developer key
     *
     * @param string $key
     */
    public function setKey($key){
        $headers['X-Google-Key'] = 'key=' . (string) $key;
        $this->client->setHeaders($headers);
    }
    
    protected function getQueryString(){
        if (!count($this->params))
                return '';
        
        $querystring = '?';
        foreach ($this->params as $name => $value) {
            $querystring .= '&' . urlencode($name) . '=' . urlencode($value);
        }
        return $querystring;
    }
    
    public function resetParams(){
        $this->params = array();
    }
    
    /**
     * Retreive feed object
     *
     * @param string $uri
     * @return Zend_Feed
     */
    public function getFeed($uri){
        $feed = new Zend_Feed();
        $this->client->resetParameters();
        $feed->setHttpClient($this->client);
        return $feed->import($uri);
    }
    
    /**
     * POST xml data to Google with authorization headers set
     *
     * @param string $xml
     * @param string $uri POST URI
     * @return Zend_Http_Response
     */
    public function post($xml,$uri){
        $this->client->setUri($uri);
        $this->client->setMaxRedirects(0);
        $this->client->setRawData($xml,'application/atom+xml');
        $response = $this->client->request('POST');
        //set "S" cookie to avoid future redirects.
        if($cookie = $response->getHeader('Set-cookie')){
                $this->client->setCookie($cookie);
        }
        if ($response->isRedirect()){
                //this usually happens. Re-POST with redirected URI.
                $this->client->setUri($response->getHeader('Location'));
                $this->client->setRawData($xml,'application/atom+xml');
                $response = $this->client->request('POST');
        }
        
        if (!$response->isSuccessful()) {
                        return false;//commented by selvaraj//throw new Zend_Gdata_Exception("Post to Google failed.");
        }
        return $response;
    }
    
    /**
     * Delete an entry by it's ID uri
     *
     * @param string $uri
     */
    public function delete($uri){
        $feed = $this->getFeed($uri);
                $entry = $feed->current();
                $entry->delete();
                return true;
    }
    
    public function __set($var, $value) {
        $this->params[$var] = $value;
    }
    
}
