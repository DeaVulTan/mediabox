<?php

/**
 * This is the main page of the sample Web Auth site.  It displays the
 * Sign in/out link as well as a user greeting.
 */

// Load common settings.  For more information, settings.php for details.
include 'settings.php';

include 'userdb.php';
include '../lib/windowslivelogin.php';

// Initialize the WindowsLiveLogin module.
$wll = WindowsLiveLogin::initFromXml($KEYFILE);
$wll->setDebug($DEBUG);
$APPID = $wll->getAppId();
$userid = null;
$username = null;

// If the user token has been cached in a site cookie, attempt to
// process it and extract the user ID.
$token = @$_COOKIE[$COOKIE];
if ($token) {
    $user = $wll->processToken($token);
    echo "<pre>";print_r($user);echo "</pre>";
    var_dump($user);
    if ($user) {
        $userid = $user->getId();
    }
}

$message_html = "<p>This application does not know who you are!  Click the <b>Sign in</b> link above.</p>";

/* If we have a user ID, attempt to retrieve the user's name from the
   profile database.

   If we do not have a name in the database, but we are currently
   processing a profile submission, store the name into the profile
   DB.

   Otherwise, display a form and attempt to collect the profile
   information from the user. */
if ($userid) {
    $users  = new UserDB($USERDB);
    $username = $users->getName($userid);

    // If there is no name in the database, see if one has been
    // submitted through a form post and process it.
    if (!$username && @$_REQUEST['name']) {
        $username = $_REQUEST['name'];
        $users->setName($userid, $username);
    }

    if ($username) {
        $username = htmlspecialchars($username);
        $message_html = "<p>Now this application knows that you are the user with ID = '<b>$userid</b>' and name = '<b>$username</b>'.</p>";
    }
    else {
        $message_html = <<<END
<p>Now this application knows that you are the user with ID = '<b>$userid</b>'.</p> <p>Please enter your name.</p>
<p>
  <form method=post action="$INDEX">
    Name:
    <input type="text" name="name" size=10>
    <input type="Submit" value="Save">
  </form>
</p>
END;
    }
}

// This code embeds the Web Auth control on your webpage to display the
// appropriate application sign in/out link.
$control_html = <<<END
  <iframe
    id="WebAuthControl"
    name="WebAuthControl"
    src="$CONTROLURL?appid=$APPID&style=$CONTROLSTYLE"
    width="80px"
    height="20px"
    marginwidth="0"
    marginheight="0"
    align="middle"
    frameborder="0"
    scrolling="no">
  </iframe>
END;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
  <head>
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="-1" />
    <title>Windows Live ID&trade; Web Authentication Sample</title>
    <?php echo $BODYSTYLE; ?>
  </head>
  <body><table width="320"><tr><td>
    <h1>Welcome to the PHP Sample for the Windows Live&trade; ID Web
    Authentication SDK</h1>

    <p>The text of the link below indicates whether you are signed in
    or not. If the link invites you to <b>Sign in</b>, you are not
    signed in yet. If it says <b>Sign out</b>, you are already signed
    in.</p>

    <?php echo $control_html; ?>

    <?php echo $message_html; ?>
  </td></tr></table></body>
</html>
