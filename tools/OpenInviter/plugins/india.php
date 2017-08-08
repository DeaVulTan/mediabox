<?php
$_pluginInfo=array(
	'name'=>'India',
	'version'=>'1.0.1',
	'description'=>"Get the contacts from an India account",
	'base_version'=>'1.6.3',
	'type'=>'email',
	'check_url'=>'http://mail.india.com/scripts/common/index.main?signin=1&lang=us'
	);
/**
 * India plugin
 * 
 * Imports user's contacts from India AddressBook
 * 
 * @author OpenInviter
 * @version 1.0.1
 */
class india extends OpenInviter_base
{
	private $login_ok=false;
	public $showContacts=true;
	public $requirement='user';
	public $internalError=false;
	protected $timeout=30;
	public $allowed_domains=false;
	
	public $debug_array=array('initial_get'=>'show_frame',
			  				  'login_post'=>'ob=',
			  				  'file_contacts'=>'Name'
							 );

	/**
	 * Login function
	 * 
	 * Makes all the necessary requests to authenticate
	 * the current user to the server.
	 * 
	 * @param string $user The current user.
	 * @param string $pass The password for the current user.
	 * @return bool TRUE if the current user was authenticated successfully, FALSE otherwise.
	 */
	public function login($user, $pass)
	{
		$this->resetDebugger();
		$this->service='indiatimes';
		$this->service_user=$user;
		$this->service_password=$pass;
		if (!$this->init()) return false;
		
		$res = $this->get("http://mail.india.com/scripts/common/index.main?signin=1&lang=us");
		if ($this->checkResponse("initial_get",$res))
			$this->updateDebugBuffer('initial_get',"http://mail.india.com/scripts/common/index.main?signin=1&lang=us",'GET');
		else
			{
			$this->updateDebugBuffer('initial_get',"http://mail.india.com/scripts/common/index.main?signin=1&lang=us",'GET',false);
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
			
		$form_action="http://mail.india.com/scripts/common/proxy.main";
		$post_elements=array('show_frame'=>'Enter',
							 'action'=>'login',
							 'domain'=>'india.com',
							 'u'=>$this->getElementString($res,'name="u" value="','"'),
							 'v'=>$this->getElementString($res,'name="v" value="','"'),
							 'mail_language'=>'us',
							 'login'=>$user,
							 'password'=>$pass,
							); 					
							
 		$res=$this->post($form_action,$post_elements,true);
 		if ($this->checkResponse("login_post",$res))
			$this->updateDebugBuffer('login_post',$form_action,'POST',true,$post_elements);
		else
			{
			$this->updateDebugBuffer('login_post',$form_action,'POST',false,$post_elements);
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
		
		$url_export="http://mymail.india.com/scripts/addr/external.cgi?.ob=a&gab=1";
		$this->login_ok=$url_export;
		return true;		
	} 

	/**
	 * Get the current user's contacts
	 * 
	 * Makes all the necesarry requests to import
	 * the current user's contacts
	 * 
	 * @return mixed The array if contacts if importing was successful, FALSE otherwise.
	 */	
	public function getMyContacts()
		{
		if (!$this->login_ok)
			{
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
		else $url=$this->login_ok;
		
		$form_action=$url;
		$post_elements=array('showexport'=>'showexport','action'=>'export','login'=>"{$this->service_user}@india.com",'format'=>'csv');
		$res=$this->post($form_action,$post_elements);
		if ($this->checkResponse("file_contacts",$res))
			$this->updateDebugBuffer('file_contacts',$form_action,'POST',true,$post_elements);
		else
			{
			$this->updateDebugBuffer('file_contacts',$form_action,'POST',false,$post_elements);
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
							
		$temp=$this->parseCSV($res);
		$contacts=array();
		foreach ($temp as $values)
			{
			$name=(!empty($values[0])?$values[0]:'').(empty($values[2])?'':(empty($values[0])?'':'-')."{$values[2]}").(empty($values[3])?'':' '.$values[3]);
			if (!empty($values[4]))
				$contacts[$values[4]]=(empty($name)?$values[4]:$name);
			if (!empty($values[5]))
				$contacts[$values[5]]=(empty($name)?$values[5]:$name);
			}
		foreach ($contacts as $email=>$name) if (!$this->isEmail($email)) unset($contacts[$email]);
		return $contacts;
		}

	/**
	 * Terminate session
	 * 
	 * Terminates the current user's session,
	 * debugs the request and reset's the internal 
	 * debudder.
	 * 
	 * @return bool TRUE if the session was terminated successfully, FALSE otherwise.
	 */	
	public function logout()
		{
		if (!$this->checkSession()) return false;
		$res=$this->get("http://mb.indiatimes.com/it/logout.jsp",true);
		$this->debugRequest();
		$this->resetDebugger();
		$this->stopPlugin();
		}
	}
?>