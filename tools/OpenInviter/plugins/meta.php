<?php
$_pluginInfo=array(
	'name'=>'Meta',
	'version'=>'1.0.0',
	'description'=>"Get the contacts from a Meta account",
	'base_version'=>'1.6.5',
	'type'=>'email',
	'check_url'=>'http://meta.ua/'
	);
/**
 * Meta Plugin
 * 
 * Imports user's contacts from Meta AddressBook
 * 
 * @author OpenInviter
 * @version 1.0.0
 */
class meta extends OpenInviter_Base
	{
	private $login_ok=false;
	public $showContacts=true;
	public $internalError=false;
	public $requirement='user';
	public $allowed_domains=false;
	protected $timeout=30;
	
	public $debug_array=array(
				'initial_get'=>'login',
				'login_post'=>'INBOX',
				'file_contacts'=>'Name',
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
		$this->service='meta';
		$this->service_user=$user;
		$this->service_password=$pass;
		if (!$this->init()) return false;
					
		$res=$this->get("http://meta.ua/");
		if ($this->checkResponse("initial_get",$res))
			$this->updateDebugBuffer('initial_get',"http://meta.ua/",'GET');
		else
			{
			$this->updateDebugBuffer('initial_get',"http://meta.ua/",'GET',false);	
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
			
		$form_action="http://passport.meta.ua/";
		$post_elements=array('login'=>$user,'password'=>$pass,'mode'=>'login','from'=>'mail','lifetime'=>'alltime','subm'=>'Enter');
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
		
		$this->login_ok=true;
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
		
		$form_action="http://webmail.meta.ua/adress_transfer.php";
		$post_elements=array('mail_client'=>'outlook_en','js_enable'=>false,'action'=>'export','groups[]'=>'all','subm'=>true);
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
			
		$contacts=array();$tempFile=explode(PHP_EOL,$res);
		foreach ($tempFile as $valuesTemp)
			{
			$values=explode(';',$valuesTemp);
			$name=$values[0].(empty($values[1])?'':(empty($values[0])?'':'-')."{$values[1]}").(empty($values[3])?'':" \"{$values[3]}\"").(empty($values[2])?'':' '.$values[2]);
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
		$res=$this->get('http://webmail.meta.ua/logout.php',true);
		$this->debugRequest();
		$this->resetDebugger();
		$this->stopPlugin();
		return true;	
		}
	
	}	

?>