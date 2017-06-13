
<?php
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

    $albums = $fb->api('/me/albums');
    foreach($albums['data'] as $album)  {
      print ('<a href="albumPhotos.php?album_id='.$album['id'].'">'.$album['name'].'</a>'.'</br>' ) ;
    }

    $album_id = $_GET['album_id']; // get the album_id passed in the URL
    $photos = $fb->api("/{$album_id}/photos"); // just get that one album
    foreach($photos['data'] as $photo)
    {
            echo "<img src='{$photo['source']}' />", "<br />";
    }

} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$permissions = ['email'];
	$loginUrl = $helper->getLoginUrl('https://bhautikng143.herokuapp.com/index.php', $permissions);
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}
?>
