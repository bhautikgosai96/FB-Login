
<?php
if(!session_id()){
    session_start();
}

// Include the autoloader provided in the SDK
require_once __DIR__ . '/src/autoload.php';

// Include required libraries
use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;

/*
 * Configuration and setup Facebook SDK
 */
$appId         = '120783235172145'; //Facebook App ID
$appSecret     = '2af58b7080bcb06278ad922a787f27a2'; //Facebook App Secret
$redirectURL   = 'https://bhautikng143.herokuapp.com/index.php'; //Callback URL
$fbPermissions = array('email');  //Optional permissions

$fb = new Facebook(array(
    'app_id' => $appId,
    'app_secret' => $appSecret,
    'default_graph_version' => 'v2.4',
));

// Get redirect login helper
$helper = $fb->getRedirectLoginHelper();

// Try to get access token
try {
    if(isset($_SESSION['facebook_access_token'])){
        $accessToken = $_SESSION['facebook_access_token'];
    }else{
          $accessToken = $helper->getAccessToken();
    }
} catch(FacebookResponseException $e) {
     echo 'Graph returned an error: ' . $e->getMessage();
      exit;
} catch(FacebookSDKException $e) {
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
}

if(isset($accessToken)){
    if(isset($_SESSION['facebook_access_token'])){
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }else{
        // Put short-lived access token in session
        $_SESSION['facebook_access_token'] = (string) $accessToken;

          // OAuth 2.0 client handler helps to manage access tokens
        $oAuth2Client = $fb->getOAuth2Client();

        // Exchanges a short-lived access token for a long-lived one
        $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
        $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

        // Set default access token to be used in script
        $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
    }

    // Redirect the user back to the same page if url has "code" parameter in query string
    if(isset($_GET['code'])){
        header('Location: ./');
    }

    // Getting user facebook profile info
    try {
        $profileRequest = $fb->get('/me?fields=name,first_name,last_name,email,link,gender,locale,picture');
        $fbUserProfile = $profileRequest->getGraphNode()->asArray();
    } catch(FacebookResponseException $e) {
        echo 'Graph returned an error: ' . $e->getMessage();
        session_destroy();
        // Redirect user back to app login page
        header("Location: ./");
        exit;
    } catch(FacebookSDKException $e) {
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
    }
    // Get logout url
        $logoutURL = $helper->getLogoutUrl($accessToken, $redirectURL.'logout.php');

        // Render facebook profile data
        if(!empty($fbUserProfile)){
            $output  = '<h1>Facebook Profile Details </h1>';
            $output .= '<img src="'.$fbUserProfile['picture'].'">';
            $output .= '<br/>Facebook ID : ' . $fbUserProfile['oauth_uid'];
            $output .= '<br/>Name : ' . $fbUserProfile['first_name'].' '.$fbUserProfile['last_name'];
            $output .= '<br/>Email : ' . $fbUserProfile['email'];
            $output .= '<br/>Gender : ' . $fbUserProfile['gender'];
            $output .= '<br/>Locale : ' . $fbUserProfile['locale'];
            $output .= '<br/>Logged in with : Facebook';
            $output .= '<br/><a href="'.$fbUserProfile['link'].'" target="_blank">Click to Visit Facebook Page</a>';
            $output .= '<br/>Logout from <a href="'.$logoutURL.'">Facebook</a>';
        }else{
            $output = '<h3 style="color:red">Some problem occurred, please try again.</h3>';
        }

    }else{
        // Get login url
        $loginURL = $helper->getLoginUrl($redirectURL, $fbPermissions);

        // Render facebook login button
        $output = '<a href="'.htmlspecialchars($loginURL).'">login with facebook</a>';
    }
?>


<html>
<head>
<title>Login with Facebook using PHP by CodexWorld</title>
<style type="text/css">
    h1{font-family:Arial, Helvetica, sans-serif;color:#999999;}
</style>
</head>
<body>
    <!-- Display login button / Facebook profile information -->
    <div><?php echo $output; ?></div>
</body>
</html>






























/*<?php
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '120783235172145',
  'app_secret' => '2af58b7080bcb06278ad922a787f27a2',
  'default_graph_version' => 'v2.4',
  ]);
$helper = $fb->getRedirectLoginHelper();


try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
 }
if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		// getting short-lived access token
		$_SESSION['facebook_access_token'] = (string) $accessToken;
	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);

		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

	// getting basic info about user
	try {
		$profile_request = $fb->get('/me');
		$profile = $profile_request->getGraphUser();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		unset($__SESSION['facebook_access_token']);
		exit;

	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}

	// printing $profile array on the screen which holds the basic info about user

    //echo "Logged in as " . $profile->getName();
	//print_r($profile);

	// getting profile picture of the user
    	try {
    		$requestPicture = $fb->get('/me/picture?redirect=false&height=300'); //getting user picture
    		$requestProfile = $fb->get('/me'); // getting basic info
    		$picture = $requestPicture->getGraphUser();
    		$profile = $requestProfile->getGraphUser();
    	} catch(Facebook\Exceptions\FacebookResponseException $e) {
    		// When Graph returns an error
    		echo 'Graph returned an error: ' . $e->getMessage();
    		exit;
    	} catch(Facebook\Exceptions\FacebookSDKException $e) {
    		// When validation fails or other local issues
    		echo 'Facebook SDK returned an error: ' . $e->getMessage();
    		exit;
    	}

    	// showing picture on the screen
    	//echo "<img src='".$picture['url']."'/>";
    	//echo "image";
?>
    	<html>
    	    <body>
                <img src="<?php echo $picture['url']; ?>"/>
                <p>Your Name is <?php echo $profile->getName(); ?></p>
    	    </body>
    	</html>
<?php

  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']

} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$permissions = ['email'];
	$loginUrl = $helper->getLoginUrl('https://bhautikng143.herokuapp.com/index.php', $permissions);
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}
?>*/