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
$fb_page_id = "120783235172145";
$graphAlbLink = "https://graph.facebook.com/v2.9/{$fb_page_id}/albums?fields={$fields}&access_token={$access_token}";

$jsonData = file_get_contents($graphAlbLink);
$fbAlbumObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);

// Facebook albums content
$fbAlbumData = $fbAlbumObj['data'];
?>
Loop through the retrieved album’s content of the Facebook page and list all the albums with the cover photo, name, and description.

<?php
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
}
?>

<?php
if(!session_id()){
    session_start();
}

// Get album id from url
$album_id = isset($_GET['album_id'])?$_GET['album_id']:header("Location: index.php");
$album_name = isset($_GET['album_name'])?$_GET['album_name']:header("Location: index.php");

// Get access token from session
$access_token = $_SESSION['facebook_access_token'];

// Get photos of Facebook page album using Facebook Graph API
$graphPhoLink = "https://graph.facebook.com/v2.9/{$album_id}/photos?fields=source,images,name&access_token={$access_token}";
$jsonData = file_get_contents($graphPhoLink);
$fbPhotoObj = json_decode($jsonData, true, 512, JSON_BIGINT_AS_STRING);

// Facebook photos content
$fbPhotoData = $fbPhotoObj['data'];
?>


<?php
// Render all photos
foreach($fbPhotoData as $data){
    $imageData = end($data['images']);
    $imgSource = isset($imageData['source'])?$imageData['source']:'';
    $name = isset($data['name'])?$data['name']:'';

    echo "<div class='fb-album'>";
    echo "<img src='{$imgSource}' alt=''>";
    echo "<h3>{$name}</h3>";
    echo "</div>";
}
?>

/*<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';

$fb = new Facebook\Facebook([
  'app_id' => '120783235172145',
  'app_secret' => '2af58b7080bcb06278ad922a787f27a2',
  'default_graph_version' => 'v2.5',
  ]);

$helper = $fb->getRedirectLoginHelper();


$permissions = ['email','publish_actions','user_photos']; // optional
?>


<html>
		      <head>
		           <title>rtCamp| Nirma</title>
		           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
		           <link rel="stylesheet" href="css/index.css">
		           <meta name="viewport" content="width=device-width, initial-scale=1">
					<link rel="stylesheet" href="https://use.fontawesome.com/56f96413ae.css">
					<link rel="stylesheet" type="text/css" href="css/animate.css">
		      </head>
		      <body>



<?php

try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error:'.$e->getMessage();

  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Error' . $e->getMessage();
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

		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;

		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

	// redirect the user back to the same page if it has "code" GET variable
	if (isset($_GET['code'])) {
		header('Location: ./');
	}

	try{
		$request = $fb->get('/me?fields=name,first_name,last_name,email');
	}catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		if($e == 190){
			$helper = $fb->getRedirectLoginHelper();
			$permissions = ['email','publish_actions']; // optional
			$loginUrl = $helper->getLoginUrl('https://bhautikng143.herokuapp.com/index.php', $permissions);
			echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
		}
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}


	// getting basic info about user
	try {
		$profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
		$profile = $profile_request->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: ./");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}


	try{
		$requestPicture = $fb->get('/me/picture?redirect=false');
		$requestProfile = $fb->get('/me');
		$picture = $requestPicture->getGraphUser();
		$profile = $requestProfile->getGraphUser();
	}catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();					//  Profile Picture
		session_destroy();
		// redirecting user back to app login page
		header("Location: ./");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	?>
	<div class="navbar">
		<div class="company">
			rtCamp
		</div>
		<div class="name">
			Welcome <?php echo $profile['name']; ?>
			<a href="logout.php" class="logout">Log Out</a>
		</div>


	</div>
	<?php

	try{
		$albums = $fb->get('/me/albums', $accessToken);
		$albums_array = $albums->getGraphEdge()->asArray();
	}catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: ./");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
		//print_r($albums_array);
		//echo "<br>";
		$array_length =count($albums_array);
	?>
	<center>

	<form method="post" action="create_zip.php">
			<Button type="submit" name="download_selection" class="download_button btn btn-success btn-lg">Download Selection</Button>
			<Button type="submit" name="download_all" class="download_button btn btn-success btn-lg">Download All</Button>
			<br><br>
			<div class="album_form">
					<?PHP
					$all_download  = array();
					for($i=0; $i<$array_length; $i++){
						$id = $albums_array[$i]['id'];
						$name= $albums_array[$i]['name'];
						 array_push($all_download, $id);
						$photos = $fb->get("/$id/photos?fields=name,picture&limit=9", $token)->getGraphEdge()->asArray();
						$count = count($photos);
						//echo $count;

						?>

						<div class="image_display">

							<input type="checkbox" name="files_s[]" value="<?php echo $id; ?>" >
							<div class="album_title">
								<?php
									echo $name;
								?>
							</div>
							<br>
							<Button type="submit" name="sbt" value="<?php echo $id; ?>" class="btn btn-primary btn_p_download">Download</button>
							<a href='slide_show.php?id=<?php echo $id."&name=".$name; ?>' class="btn btn-warning btn_slideshow" target="_blank">Full slide show</a>
							<br>
						<?php
						//print_r($photos);
						       foreach ($photos as $key) {
								$photo_request = $fb->get('/'.$key['id'].'?fields=images');
								$photo = $photo_request->getGraphNode()->asArray();
								//echo $photo['images'][2]['source'];
								?>
								<div class="inside_photo">
								<?php
								echo '<img src="'.$photo['images'][2]['source'].'" width="100%" height="100%" ><br>';
								?>
								</div>
								<?php
								}

				    	?>
				    	</div>
				    	<?php
					}

					?>

			</div>
	</form>
	</center>
			<?php
			$_SESSION['all_download'] = $all_download;
			//print_r($all_download);

			$var = $_SESSION['all_download'];
			//print_r($var);
			//echo $var[0];
			?>


	<?php
  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl('https://bhautikng143.herokuapp.com/index.php', $permissions);
	?>



	<div class="homepage-hero-module">
    <div class="video-container">
        <div class="filter">

        	<center>
        		<div class="title">
        			rtCamp<br>
        			Facebook Albums
        		</div>
        		<h4 class="desc typed">
        			Show your facebook albums, Enjoy it and Download it
        		</h4>
        		<span class="typed-cursor">|</span>
        		<div class="link">
        		<?php  echo '<a href="' . $loginUrl . '" >Log in with Facebook</a>'; ?>
        		</div>
        	</center>
        </div>
        <video autoplay loop class="fillWidth">
            <source src="css/MP4/Hey-World.mp4" type="video/mp4" />Your browser does not support the video tag. I suggest you upgrade your browser.
            <source src="css/WEBM/Hey-World.webm" type="video/webm" />Your browser does not support the video tag. I suggest you upgrade your browser.
        </video>
        <div class="poster hidden">
            <img src="css/Snapshots/Hey-World.jpg" alt="">
        </div>
    </div>
</div>
	<?php
}

?>

</body>
</html>
*/
/*<?php
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '120783235172145',
  'app_secret' => '2af58b7080bcb06278ad922a787f27a2',
  'default_graph_version' => 'v2.9',
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

    try{
    		$albums = $fb->get('/me/albums', $accessToken);
    		$albums_array = $albums->getGraphEdge()->asArray();
    	}catch(Facebook\Exceptions\FacebookResponseException $e) {
    		// When Graph returns an error
    		echo 'Graph returned an error: ' . $e->getMessage();
    		session_destroy();
    		// redirecting user back to app login page
    		header("Location: ./");
    		exit;
    	} catch(Facebook\Exceptions\FacebookSDKException $e) {
    		// When validation fails or other local issues
    		echo 'Facebook SDK returned an error: ' . $e->getMessage();
    		exit;
    	}
    		print_r($albums_array);
    		echo "<br>";
    		$array_length =count($albums_array);
            echo $array_length;
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$permissions = ['email'];
	$loginUrl = $helper->getLoginUrl('https://bhautikng143.herokuapp.com/index.php', $permissions);
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}
?>*/
