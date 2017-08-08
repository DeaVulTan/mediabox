<?php
set_include_path(dirname(__FILE__) . '/Ngeblog');
require_once 'Ngeblog/ClientLogin.php';

function getBlogLists($username, $password)
	{
		$resp =  @Ngeblog_ClientLogin::getClientLoginAuth($username,$password);
		if( $resp['response']=='authorized' )
			{
				$myblog = Ngeblog_ClientLogin::Connect($resp['auth']);
				return $myblog->getBlogLists();
			}
		else
			{
				return false;
			}
	}
	
function postNewBlog($username, $password, $title, $content, $blogid)
	{
		$resp =  @Ngeblog_ClientLogin::getClientLoginAuth($username,$password);
		if( $resp['response']=='authorized' )
			{
				$myblog = Ngeblog_ClientLogin::Connect($resp['auth']);
				$myblog->newPost($title,$content,$blogid);
				return true;
			}
		else
			{
				return false;
			}
	}

function chkIsBlogAvailable($blog_arr, $blog_title)
	{
		if(is_array($blog_arr))
			{
				foreach($blog_arr as $key=>$value)
					{
						if($blog_arr[$key]['url'] == 'http://'.$blog_title.'.blogspot.com/')
							{
								return $blog_arr[$key];
							}
					}
			}
		return false;
	}
?>