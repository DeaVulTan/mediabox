<?php
set_include_path(dirname(__FILE__) . '/Ngeblog');
require_once 'Ngeblog/ClientLogin.php';

 $username = 'mail2selvaraj@gmail.com';
  $password = 'ganeshselva';
  $resp =  @Ngeblog_ClientLogin::getClientLoginAuth($username,$password);
  if ( $resp['response']=='authorized' )
  {
    $myblog = Ngeblog_ClientLogin::Connect($resp['auth']);

    /*$title = 'this is test msg';
    $content = '<b>this is test messsgae for cricket</b>';
    $blogid = '3901242561548398387';
    $myblog->newPost($title,$content,$blogid);*/
	echo '<pre>';print_r($myblog->getBlogLists());echo '</pre>';
  }
 else
 	{
		echo 'selvaraj auth failed';
	}

  
/*$obj = new Ngeblog_ClientLogin();
$arr = $obj->getClientLoginAuth('tester@gmail.com', 'tester');
$arr1 = $obj->connect($arr['auth']);

$obj1 = new Ngeblog('tester@gmail.com', 'tester');
//$obj1->newPost('this is test msg','<b>this is test messsgae for cricket</b>', '3901242561548398387');
echo '<pre>';print_r($arr);echo '</pre>';
echo '<pre>';print_r($arr1);echo '</pre>';*/
?>