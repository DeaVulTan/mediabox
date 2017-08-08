<?php
	include_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'inc' . DIRECTORY_SEPARATOR . 'config.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 3.2 Final//EN">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link type="text/css" href="<?php echo URL_ADMIN_CSS  . 'login.css'; ; ?>" rel="stylesheet">
<title>Login Form</title>
</head>
<body>
<table cellpadding="0" cellspacing="0" id="wrapper">
    <tr>

        <td>
            <div id="loginform">           
                <div id="loginform-top">
                     <h1>Login Form</h1>
						<p>Please enter your supplied Username, Password<br>and the 4-character validation codes</p>
                    	<form method="post" action="">
					    <table cellpadding="0" cellspacing="0" id="loginTable" class="formtable">
					    
					        <tbody>
					            <tr>
					                <th class="padTop"><label><?php echo LOGIN_USERNAME; ?> </label></th>

					                <td class="padTop"><input type="text" value="" class="input" name="username" id="username" /></td>
					            </tr>
					            <tr>
					                <th><label><?php echo LOGIN_PASSWORD; ?> </label></th>
					                <td><input type="password" value="" class="input" name="password" id="password" /></td>
					            </tr>
											   <tr>
					                <th><label><?php echo LOGIN_VCODE; ?> </label></th>

					                <td><input type="text" value="" class="input" name="validation" id="validation" /></td>
					            </tr>
					        </tbody>
					        <tfoot>
					            <tr>
					            	<th><input type="hidden" name="form_event" value="login" /><img src='<?php echo URL_ADMIN; ?>validateimg.php' width='50' height='20'/></th>
					              <td><input type="submit" class="button" value="<?php echo L_ACTION_LOGIN; ?>" /></td>
					            </tr>			        
					        </tfoot>

					        
					    </table>  
					     </form>                
		
                </div>
                <div id="loginform-btm"></div>
            </div>
            <p  id="footer">&copy;2008 - <?php echo date('Y'); ?> Fire Form Builder, All Rights Reserved. Built by <a href="http://www.phpletter.com/">Logan Cai</a></p>	

        </td>

    </tr>

</table>
<?php
	$msg->displayPopupMsg();
?>
</body>
</html>
