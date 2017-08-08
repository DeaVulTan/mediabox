<?php
$_pluginInfo=array(
	'name'=>'Inet',
	'version'=>'1.0.0',
	'description'=>"Get the contacts from a Inet account",
	'base_version'=>'1.6.5',
	'type'=>'email',
	'check_url'=>'http://inet.ua/index.php'
	);
/**
 * Inet Plugin
 * 
 * Imports user's contacts from Inet AddressBook
 * 
 * @author OpenInviter
 * @version 1.0.0
 */
class inet extends OpenInviter_Base
	{
	private $login_ok=false;
	public $showContacts=true;
	public $internalError=false;
	public $requirement='email';
	public $allowed_domains=false;
	protected $timeout=30;
	
	public $debug_array=array(
				'initial_get'=>'login_username',
				'login_post'=>'frame',
				'url_redirect'=>'passport',
				'url_export'=>'FORENAME',
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
	public function login($user,$pass)
		{
		$this->resetDebugger();
		$this->service='inet';
		$this->service_user=$user;
		$this->service_password=$pass;
		if (!$this->init()) return false;
					
		$res=$this->get("http://inet.ua/index.php");
		if ($this->checkResponse("initial_get",$res))
			$this->updateDebugBuffer('initial_get',"http://inet.ua/index.php",'GET');
		else
			{
			$this->updateDebugBuffer('initial_get',"http://inet.ua/index.php",'GET',false);	
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}

		$user_array=explode('@',$user);$username=$user_array[0];	
		$form_action="http://newmail.inet.ua/login.php";
		$post_elements=array('username'=>$username,'password'=>$pass,'server_id'=>0,'template'=>'v-webmail','language'=>'ru','login_username'=>$username,'servname'=>'inet.ua','login_password'=>$pass,'version'=>1,'x'=>rand(1,100),'y'=>rand(1,100));
		$res=$this->post($form_action,$post_elements,true);	
		if ($this->checkResponse('login_post',$res))
			$this->updateDebugBuffer('login_post',$form_action,'POST',true,$post_elements);
		else
			{
			$this->updateDebugBuffer('login_post',$form_action,'POST',false,$post_elements);	
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
		
		$this->login_ok="http://newmail.inet.ua/download.php?act=process_export&method=csv&addresses=all";
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
		$res=$this->get($url);
		if ($this->checkResponse("url_export",$res))
			$this->updateDebugBuffer('url_export',$url,'GET');
		else
			{
			$this->updateDebugBuffer('url_export',$url,'GET',false);	
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
		
		$tempFile=explode(PHP_EOL,$res);$contacts=array();
		foreach ($tempFile as $valuesTemp)
			{
			$values=explode('~',$valuesTemp);
			$name=(!empty($values['1'])?$values['1'].' '.(empty($values['2'])?$values['2']:false):false);
			if (!empty($values['3']))
				$contacts[$values['3']]=(empty($name)?$values['3']:$name);
			if (!empty($values['4']))
				$contacts[$values['4']]=(empty($name)?$values['4']:$name);
			if (!empty($values['5']))
				$contacts[$values['5']]=(empty($name)?$values['5']:$name);				
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
		$res=$this->get('http://newmail.inet.ua/logout.php?vwebmailsession=',true);
		$this->debugRequest();
		$this->resetDebugger();
		$this->stopPlugin();
		return true;	
		}
	
	}	

?>