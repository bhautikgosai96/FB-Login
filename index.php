<?php
if(!session_id()){
    session_start();
}

/*
 * Get access token using Facebook Graph API
 */
if(isset($_SESSION['facebook_access_token'])){
    // Get access token from session
    $access_token = $_SESSION['facebook_access_token'];
}else{
    // Facebook app id & app secret
    $appId = '120783235172145';
    $appSecret = '2af58b7080bcb06278ad922a787f27a2';

    // Generate access token
    $graphActLink = "https://graph.facebook.com/oauth/access_token?client_id={$appId}&client_secret={$appSecret}&grant_type=client_credentials";

    // Retrieve access token
    $accessTokenJson = file_get_contents($graphActLink);
    $accessTokenObj = json_decode($accessTokenJson);
    $access_token = $accessTokenObj->access_token;

    // Store access token in session
    $_SESSION['facebook_access_token'] = $access_token;
}

// Get photo albums of Facebook page using Facebook Graph API
$fields = "id,name,description,link,cover_photo,count";
$fb_page_id = "6429603637678731258";
$graphAlbLink = "https://graph.facebook.com/v2.9/{$fb_page_id}/albums?fields={$fields}&access_token={$access_token}";

$jsonData = file_get_contents($graphAlbLink);
$fbAlbumObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);

// Facebook albums content
$fbAlbumData = $fbAlbumObj['data'];

// Render all photo albums
foreach($fbAlbumData as $data){
    $id = isset($data['id'])?$data['id']:'';
    $name = isset($data['name'])?$data['name']:'';
    $description = isset($data['description'])?$data['description']:'';
    $link = isset($data['link'])?$data['link']:'';
    $cover_photo_id = isset($data['cover_photo']['id'])?$data['cover_photo']['id']:'';
    $count = isset($data['count'])?$data['count']:'';

    $pictureLink = "photos.php?album_id={$id}&album_name={$name}";

    echo "<div class='fb-album'>";
    echo "<a href='{$pictureLink}'>";
    echo "<img src='https://graph.facebook.com/v2.9/{$cover_photo_id}/picture?access_token={$access_token}' alt=''>";
    echo "</a>";
    echo "<h3>{$name}</h3>";

    $photoCount = ($count > 1)?$count. 'Photos':$count. 'Photo';

    echo "<p><span style='color:#888;'>{$photoCount} / <a href='{$link}' target='_blank'>View on Facebook</a></span></p>";
    echo "<p>{$description}</p>";
    echo "</div>";
    echo "";
}
?>

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