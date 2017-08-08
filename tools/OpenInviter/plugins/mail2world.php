<?php
$_pluginInfo=array(
	'name'=>'Mail2World',
	'version'=>'1.0.0',
	'description'=>"Get the contacts from a Mail2World account",
	'base_version'=>'1.6.5',
	'type'=>'email',
	'check_url'=>'http://www.mail2world.com/'
	);
/**
 * Mail2World Plugin
 * 
 * Import user's contacts from Mail2World account
 *
 * 
 * @author OpenInviter
 * @version 1.0.0
 */
class mail2world extends OpenInviter_Base
	{
	private $login_ok=false;
	public $showContacts=true;
	public $requirement='email';
	public $internalError=false;
	public $allowed_domains=false;
	
	public $debug_array=array(
				'initial_get'=>'securebutt',
				'login_post'=>'G_ViewType',
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
		$this->service='mail2world';
		$this->service_user=$user;
		$this->service_password=$pass;
		if (!$this->init()) return false;

		$res=$this->get("http://www.mail2world.com/",true);
		if ($this->checkResponse("initial_get",$res))
			$this->updateDebugBuffer('initial_get',"http://www.mail2world.com/",'GET');
		else
			{
			$this->updateDebugBuffer('initial_get',"http://www.mail2world.com/",'GET',false);
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
		$userBulk=explode('@',$user);$username=$userBulk[0];$domain=$this->getElementString($user,'@','.');
		$form_action="http://www.mail2world.com/web/app.asp?db_browser=Firefox&db_os=WIN&db_width=1280&db_height=1024";
		$post_elements=array('db_width'=>'1280',
							 'db_height'=>'1024',
							 'db_os'=>'WIN',
							 'db_browser'=>'Firefox',
							 'faction'=>'login',
							 'username'=>$username,
							 'domain'=>$domain,
							 'password'=>$pass,
							 'submitbut.x'=>rand(1,50),
							 'submitbut.y'=>rand(1,50),
							 'securebutt'=>'on'
							);
		$res=$this->post($form_action,$post_elements,true);
		if ($this->checkResponse("login_post",$res))
			$this->updateDebugBuffer('login_post',"{$form_action}",'POST',true,$post_elements);
		else
			{
			$this->updateDebugBuffer('login_post',"{$form_action}",'POST',false,$post_elements);
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}

		$url_file_contacts='http://www.mail2world.com/contacts/contacts_import_export.asp?action=export&app=Outlook_2000&NewContacts=true&ContactType=all';
		$this->login_ok=$url_file_contacts;
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
		if ($this->checkResponse("file_contacts",$res))
			$this->updateDebugBuffer('file_contacts',$url,'GET');
		else
			{
			$this->updateDebugBuffer('file_contacts',$url,'GET',false);
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
		
		$contacts=array();
		$temp=$this->parseCSV($res);
		$contacts=array();
		foreach ($temp as $values)
			{
			$name=$values[0].(empty($values[1])?'':(empty($values[0])?'':'-')."{$values[1]}");
			if (!empty($values[3]))
				$contacts[$values[3]]=(empty($name)?$values[3]:$name);
			
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
		$res=$this->get("http://www.mail2world.com/logout.asp?action=logout",true);
		$this->debugRequest();
		$this->resetDebugger();
		$this->stopPlugin();
		return true;	
		}
	}	

?>