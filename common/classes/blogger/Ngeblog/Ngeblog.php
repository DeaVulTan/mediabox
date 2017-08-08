<?php
/**
 * Class for manipulating Blogger (http://www.blogger.com) using Google Data (GData) API
 *
 * PHP versions 5
 *
 * @category   Ngeblog
 * @package    Ngeblog
 * @author     Eris Ristemena <eristemena at ngoprekweb dot you-know-what>
 * @license    http://www.gnu.org/copyleft/lesser.html  GNU LGPL 2.1
 * @version    0.2
 * @link       http://www.ngoprekweb.com/tags/ngeblog
 * sample usage url http://www.ngoprekweb.com/2006/11/10/ngeblog-02-yes-you-can-use-authsub-now/
 * 
 * Version history:
 * * 0.0.1 16/10/2006 eris
 *   - Initial release
 *
 * * 0.0.2 22/10/06 eris
 *   - Codes Beautification (PHP5 taste :)
 *   - Get an entry
 *   - Update an entry
 *
 * * 0.0.3 23/10/06 eris
 *   - Manipulating multiple blogs in Blogger for one account
 *   - Add method getBlogInfo() to get blog Informations (needed when you have multiple blogs in an account)
 *
 * * 0.0.4 24/10/06 eris
 *   - Fixing bugs/inconsistency in google response to getPost() and getPosts()
 *
 * * 0.0.5 26/10/06 eris
 *   - Fixing another bugs in getPost() and getPosts() due to atom "type" attribute (text,html,xhtml)
 *
 * * 0.1-rc1 26/10/06 eris
 *   - Adding AuthSub authentication methods
 *
 * * 0.1-rc2 26/10/06 bill
 *   - Adding $_activeBlog, setActiveBlog() and changing related methods to use it
 *
 * * 0.1-rc3 26/10/06 eris
 *   - Adding protected methods _authenticate() for abstracting purposes
 *   - Fixing AuthSub method for newPost(),editPost() and deletePost()
 *
 * * 0.1 27/10/06 eris
 *   - Replacing all BasicAuth to ClientLogin authentication, since it works for both versions of Blogger
 *     (see: http://code.google.com/apis/gdata/blogger.html#Versions)
 *   - Fixing XML request (eliminating additional BR in newPost() and editPost())
 *
 * * 0.2 09/11/06 eris
 *   - Using Zend_Gdata for authentication abstraction
 *
 * * 0.2.1 21/11/06 eris
 *   - Fixing response for beta blogger
 */

  require_once 'Zend.php';
  Zend::loadClass('Zend_Gdata_AuthSub');
  Zend::loadClass('Zend_Gdata_ClientLogin');
  Zend::loadClass('Zend_Gdata');
  Zend::loadClass('Zend_Feed');
 
  class Ngeblog {
    /**
     * Version
     *
     * @var string
     */
    protected $_version = "0.2";
   
    /**
     * Username
     *
     * @var string
     */
    protected $_username;
   
    /**
     * Password
     *
     * @var string
     */
    protected $_password;
   
    /**
     * Authentication header to use for accesing Blogger
     *
     * @var string
     */
    protected $_auth_header;
   
    /**
     * Hold Blogger URL
     *
     * Currently, there are two distinct Blogger URL:
     * 1) http://www.blogger.com for current version of Blogger
     * 2) http://beta.blogger.com for beta version of Blogger
     *
     * @var string
     */
    protected $_blogger_url='http://www.blogger.com';
   
    /**
     * Blog IDs
     *
     * @var array
     */
    protected $_blogid = array();
   
    /**
     * Blog Info
     *
     * @var array
     */
    protected $_bloginfo = array();

        /**
         * Active Blog
         *
         * @var int
         */
        protected $_activeBlog = 0;
   
    /**
         * XML response from Blogger
         * Use for debug only
         *
         * @var string
         */
        protected $_xml_response = '';
       
    /**
     * Constructor
     *
     * @param string  $username           your Blogger username
     * @param string  $password           your Blogger password
     * @param string  $blogid             your Blogger blog ID (optional)
     */
    function __construct($username='',$password='',$blogid='',$auth_header='')
    {
      if ( $username!='' && $password!='' ) {
        $this->_username = $username;
        $this->_password = $password;
       
        $this->connect();
       
                if ( $blogid!='' ) {
                  $this->setActiveBlog($blogid);
                }
      } else if ( $auth_header!='' ) {
        $this->_auth_header = $auth_header;
                   
                    $this->_checkBloggerVersion();
                    $this->_retrieveBlogInfo();
      }
    }
   
    /**
     * Get Blogger URL
     *
     * @return string Blogger URL
     */
    public function getBloggerUrl()
    {
      return $this->_blogger_url;
    }
   
    /**
     * Get current version of Ngeblog
     *
     * @return string current version of Ngeblog
     */
    public function version()
    {
      return $this->_version;
    }
   
    /**
     * Connect to server using given token
     *
     */
    public function connect($token)
    {
      $this->_token = $token;
     
      // if authentication is ok, retrieve blog info
      $this->_retrieveBlogInfo();
    }
   
    /**
     * Get Blog Info
     *
     * This method is needed if you have more than one blog in your account
     *
     * @param string $param parameter of blog info
     * @return mixed array of Blog info or string (depends on $param)
     */
    public function getBlogInfo($param='',$blogid=0)
    {
      if ( $param!='' ) {
        if ( $blogid==0 ) {
          if ( $this->_activeBlog != 0 ) {
            $blogid = $this->_activeBlog;
          }
        }
       
        foreach ( $this->_bloginfo as $k=>$v ) {
          if ( $v[blogid]==$blogid ) {
            return $v[$param];
          }
        }
      } else {
        return $this->_bloginfo;
      }
    }
   
    /**
     * Set Active Blog
     *
     * This method is used to make a specific blog active if you have more than one blog in your account
     *
     * @param int $blogid ID of blog to activate
     */
    public function setActiveBlog($blogid)
    {
          $blogs = $this->_bloginfo;
          $oldid = $this->_activeBlog;
         
          $this->_activeBlog = 0;
         
          foreach($blogs as $blog) {
                if($blog['blogid'] == $blogid) {
                        $this->_activeBlog = $blogid;
                }
          }
         
          if($this->_activeBlog == 0) {
                $this->_activeBlog = $oldid;
                return false;//commented by selvaraj//throw new Exception("Could not set the active blog to $blogid, it was not found in the list of this user's blogs.");
          }
    }


    /**
     * Get Active Blog
     *
     * Returns the active blog
     *
     * @return int ID of active blog
     */
    public function getActiveBlog()
    {
            return $this->_activeBlog;
    }

    /**
     * Post a new entry
     *
     * @param string $title your title
     * @param string $msg your post content
     * @return boolean
     */
    public function newPost($title,$msg,$blogid=0)
    {
      $blogid = ( $blogid==0 ) ? $this->_activeBlog:$blogid;
     
    $xmlstr = '<entry xmlns=\'http://www.w3.org/2005/Atom\'>
  <title type=\'text\'>'.$title.'</title>
  <content type=\'html\'><![CDATA['.$msg.']]></content>
</entry>';
     
      $client = new Zend_Http_Client("{$this->_blogger_url}/feeds/$blogid/posts/full");
      $headers = array (  'Authorization: '.$this->_auth_header,
                          'Content-type: application/atom+xml'
                        );
     
      $client->setHeaders($headers);
     
      //ob_start();
        $response = $client->post($xmlstr);
        //ob_end_clean();
       
      $http_code = $response->getStatus();
      if ( $http_code=='201' ) {
        return true;
      } else {
        return false;//commented by selvaraj//throw new Exception('Failed to add new post, Blogger returns : '.$response->getStatus());
      }
    }
   
    /**
     * Edit an entry
     *
     * @param integer $entryid entry id to be updated
     * @param string $title your title
     * @param string $msg your post content
     * @return boolean
     */
    public function editPost($entryid,$title,$msg,$blogid=0)
    {
      $blogid = ( $blogid==0 ) ? $this->_activeBlog:$blogid;
     
      $xmlstr = "
<entry xmlns=\"http://www.w3.org/2005/Atom\">
  <title type=\"text\">$title</title>
  <content type=\"xhtml\">$msg</content>
</entry>
      ";
     
      $client = new Zend_Http_Client("{$this->_blogger_url}/feeds/$blogid/posts/full/$entryid");
      $headers = array (  'Authorization: '.$this->_auth_header,
                          'Content-type: application/atom+xml'
                        );
     
      $client->setHeaders($headers);
     
      ob_start();
        $response = $client->put($xmlstr);
        ob_end_clean();
       
        $http_code = $response->getStatus();
      if ( $http_code == '200' ) {
        return true;
      } else {
        return false;//commented by selvaraj//throw new Exception('Failed to edit post, Blogger returns : '.$response->getStatus());
      }
    }
   
    /**
     * Delete an entry
     *
     * @param integer $entryid entry id to be deleted
     * @param integer $blogid (optional)
     * @return boolean
     */
    public function deletePost($entryid,$blogid=0)
    {
      $blogid = ( $blogid==0 ) ? $this->_activeBlog:$blogid;
     
      $client = new Zend_Http_Client("{$this->_blogger_url}/feeds/$blogid/posts/full/$entryid");
      $headers = array (  'Authorization: '.$this->_auth_header
                        );
      $client->setHeaders($headers);
     
      ob_start();
        $response = $client->request('DELETE');
        ob_end_clean();
       
      if ($response->isSuccessful())
      {
        return true;
      }
      else
      {
        return false;//commented by selvaraj//throw new Exception('Failed to delete post, Blogger returns : '.$response->getStatus());
      }
    }
   
    /**
     * Get an entry
     *
     * @param integer $entryid entry ID you want to get
     * @param enum $type ('full','summary') type (default: full)
     */
    public function getPost($entryid,$blogid=0,$type='full')
    {
      if($blogid == 0 ) {
        $blogid = $this->_activeBlog;
      }
     
      $res = $this->_getPosts( array('blogid'=>$blogid,'type'=>$type,'entryid'=>$entryid) );
     
      return $res[0];
    }
   
    /**
     * Get some entries
     *
     * @param integer $start start index
     * @param integer $maxresults number of entries you'd like to get
     */
    public function getPosts($start,$maxresults,$blogid=0,$type='full')
    {
      $blogid = ( $blogid==0 ) ? $this->_activeBlog:$blogid;
     
      return $this->_getPosts( array('blogid'=>$blogid,'type'=>$type,'start'=>$start,'maxresults'=>$maxresults) );
    }
   
    /**
     * Actual methods to retrieve Blog ID
     *
     */
    protected function _retrieveBlogInfo()
    {
      $client = new Zend_Http_Client("{$this->_blogger_url}/feeds/default/blogs");
      $headers = array (  'Authorization: '.$this->_auth_header
                        );
      $client->setHeaders($headers);
     
      ob_start();
        $response = $client->request('GET');
        ob_end_clean();
       
      if ($response->isSuccessful())
      {
        $gdata = Zend_Feed::importString($response->getBody());
       
        $k=0;
        foreach ( $gdata as $item ) {
          if ( preg_match('|feeds/(\d+)/blogs/(\d+)|',$item->id(),$regs) ) {
            $blogid = $regs[2];
          } elseif ( preg_match('|user-(\d+)\.blog-(\d+)|',$item->id(),$regs) ) {
            $blogid = $regs[2];
          }
         
          $this->_blogid[$k]              = $blogid;
          $this->_bloginfo[$k]['blogid']  = $blogid;
          $this->_bloginfo[$k]['title']   = $item->title();
          $this->_bloginfo[$k]['url']     = $item->link('alternate');
          $k++;
        }
       
      }
      else
      {
        return false;//commented by selvaraj//throw new Exception('Failed to retrieve blog info, Blogger returns error: '.$response->getStatus());
      }
    }
   
    /**
     * Get list of entry
     *
     * $options is array of query options
     * $options = array (
     *     'blogid'      => blog id
     *     'type'        => 'full'/'summary'
     *     'start'       => start index
     *     'maxresults'  => maximum results
     *     'entryid'     => entry id
     * );
     *
     * @param array $options array of options
     */
    protected function _getPosts($options)
    {
      if ( is_array($options) && $options['start']!='' && $options['maxresults']!='' ) {
        $url = "{$this->_blogger_url}/feeds/{$options[blogid]}/posts/{$options[type]}?start-index={$options[start]}&max-results={$options[maxresults]}";
      } elseif ( is_array($options) && $options['entryid']!='' ) {
        $url = "{$this->_blogger_url}/feeds/{$options[blogid]}/posts/{$options[type]}/{$options[entryid]}";
      }
     
      $client = new Zend_Http_Client($url);
      $headers['authorization'] = $this->_auth_header;
      $client->setHeaders($headers);
     
      ob_start();
        $response = $client->request('GET');
        ob_end_clean();
       
      $http_code = $response->getStatus();
      if ( ($http_code == '200') || ($http_code == '202') )
      {
        $gdata = Zend_Feed::importString($response->getBody());
       
        $k=0;
        foreach ( $gdata as $item ) {
          if ( preg_match('"posts/'.$options[type].'/(\d+)"',$item->id(),$regs) ) {
            $entryid = $regs[1];
          } elseif ( preg_match('|post-(\d+)|',$item->id(),$regs) ) {
            $entryid = $regs[1];
          }
         
          $res[$k]['id']        = $item->id();
          $res[$k]['entryid']   = $entryid;
          $res[$k]['title']     = $item->title();
          $res[$k]['content']   = $item->content();
          $res[$k]['updated']   = $item->updated();
          $res[$k]['published'] = $item->published();
          $res[$k]['link']      = $item->link('alternate');
         
          $k++;
        }
       
        return $res;
      }
      else
      {
              return false;//commented by selvaraj//throw new Exception('Failed to retrieve post, Blogger returned error : '.$response->getBody());
      }
    }
   
    /**
     * Check Blogger Version
     *
     * Sending whatever credential after Google Login to http://www.blogger.com
     * and get the redirection whether http://www.blogger.com for current version
     * or http://beta.blogger.com for beta version
     *
     */
    protected function _checkBloggerVersion()
    {
      $client = new Zend_Http_Client("http://www.blogger.com/feeds/default/blogs");
      $headers = array (  'Authorization: '.$this->_auth_header
                        );
      $client->setHeaders($headers);
      $client->setMaxRedirects(0);
     
      ob_start();
        $response = $client->request('GET');
        ob_end_clean();
       
        $http_code = $response->getStatus();
      if ( $http_code == '302' )
      {
        if ( preg_match("|(http://[^/]+)|si",$response->getHeader('Location'),$matches) ) {
          $this->_blogger_url = $matches[1];
        }
      }
    }
   
   
    /**
     * Extract content appropriately from atom text constructs
     *
     * Because of different rules applied to the content element and other text
     * constructs, they are deployed as separate functions, but they share quite
     * a bit of processing. This method performs the core common process, which is
     * to apply the rules for different mime types in order to extract the content.
     *
     * @param  string $content  the text construct to be parsed
     * @param enum $type the mime type used by Atom content ('text','html','xhtml')
     * @return String
     **/
    protected function parseTextConstruct($content,$type)
    {
      // cleanup xhtml tags it may have
      $find     = array ("'<content type=\"(text|html|xhtml)\">(.*)</content>'si","'<div xmlns=\"[^\"]+\">(.*)</div>'si",";<div xmlns='[^']+'>(.*)</div>;si");
      $replace  = array("$2","$1","$1");
      $content  = preg_replace($find,$replace,$content);
     
      switch ( $type )
      {
        case 'html':
          $search = array ( '&lt;','&gt;','&amp;' );
          $replace = array ('<','>','&');
          return str_replace($search, $replace, $content);
          break;
         
        case 'xhtml':
          return utf8_decode($content);
          break;
       
        case 'text':
          return $content;
         
      }
    }
   
    public function getXMLResponse()
    {
      return $this->_xml_response;
    }
   
	public function getBlogLists()
   		{
			return $this->_bloginfo;
		}
  } // end of Class Ngeblog
