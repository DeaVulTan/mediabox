<?php 

/**
 * This page handles the login, logout and clearcookie Web Auth
 * actions.  When you create a Windows Live application, you must
 * specify the URL of this handler page.
 */

// Load common settings.  For more information, settings.php for details.
include 'settings.php';

include '../lib/windowslivelogin.php';

// Initialize the WindowsLiveLogin module.
$wll = WindowsLiveLogin::initFromXml($KEYFILE);
$wll->setDebug($DEBUG);

// Extract the 'action' parameter from the request, if any.
$action = @$_REQUEST['action'];

/* If action is 'logout', clear the session token and redirect to the
   logout page. 

   If action is 'clearcookie', clear the session token and return a
   GIF as response to signify success.

   By default, try to process a login. If login was successful, cache
   the user token in the session and redirect to the site's main page.
   If login failed, clear the cookie and redirect to the main page. */

switch ($action) {
    case 'logout':
        setcookie($COOKIE);
        header("Location: $LOGOUT");
        break;
    case "clearcookie":
        ob_start();
        setcookie($COOKIE);

        list($type, $response) = $wll->getClearCookieResponse();
        header("Content-Type: $type");
        print($response);

        ob_end_flush();
        break;
    default:
        $user = $wll->processLogin($_REQUEST);
      
        if ($user) {
            if ($user->usePersistentCookie()) {
                setcookie($COOKIE, $user->getToken(), $COOKIETTL);
            }
            else {
                setcookie($COOKIE, $user->getToken());
            }
            header("Location: $LOGIN");
        }
        else {
            setcookie($COOKIE);
            header("Location: $LOGIN");
        }
}
?>
