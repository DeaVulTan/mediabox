<?php
$_pluginInfo=array(
	'name'=>'Pochta',
	'version'=>'1.0.0',
	'description'=>"Get the contacts from a Pochta account",
	'base_version'=>'1.6.5',
	'type'=>'email',
	'check_url'=>'http://www.pochta.ru/'
	);
/**
 * Pochta Plugin
 * 
 * Imports user's contacts from Pochta AddressBook
 * 
 * @author OpenInviter
 * @version 1.0.0
 */
class pochta extends OpenInviter_Base
	{
	private $login_ok=false;
	public $showContacts=true;
	public $internalError=false;
	public $requirement='email';
	public $allowed_domains=false;
	protected $timeout=30;
	
	public $debug_array=array(
				'initial_get'=>'user',
				'login_post'=>'inbox',
				'url_export'=>',"',
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
		$this->service='pochta';
		$this->service_user=$user;
		$this->service_password=$pass;
		if (!$this->init()) return false;
					
		$res=$this->get("http://www.pochta.ru/");
		if ($this->checkResponse("initial_get",$res))
			$this->updateDebugBuffer('initial_get',"http://www.pochta.ru/",'GET');
		else
			{
			$this->updateDebugBuffer('initial_get',"http://www.pochta.ru/",'GET',false);	
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}

		$user_array=explode('@',$user);$username=$user_array[0];$domain=$user_array[1];	
		$form_action="http://www.pochta.ru/auth/logon";
		$post_elements=array('reason'=>'login','back'=>false,'lng'=>'ru','user'=>$username,'domain'=>$domain,'pass'=>$pass,'long_session'=>1);
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
		
		$this->login_ok="http://www.pochta.ru/adb/export/?export_type=outlook&export_action=export";
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
		$contacts=array();
		$temp=$this->parseCSV($res);
		foreach ($temp as $values)
			{
			$name=$values[1].(empty($values[2])?'':(empty($values[1])?'':'-')."{$values[2]}");
			if (!empty($values[82]))
				$contacts[$values[82]]=(empty($name)?$values[82]:$name);
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
		$res=$this->get('http://www.pochta.ru/auth/logout/',true);
		$this->debugRequest();
		$this->resetDebugger();
		$this->stopPlugin();
		return true;	
		}
	
	}	

?>