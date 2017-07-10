

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<?php
/*  GOOGLE LOGIN BASIC - Tutorial
 *  file            - index.php
 *  Developer       - Krishna Teja G S
 *  Website         - http://packetcode.com/apps/google-login/
 *  Date            - 28th Aug 2015
 *  license         - GNU General Public License version 2 or later
*/

// REQUIREMENTS - PHP v5.3 or later
// Note: The PHP client library requires that PHP has curl extensions configured.

/*
 * DEFINITIONS
 *
 * load the autoload file
 * define the constants client id,secret and redirect url
 * start the session
 */
require_once __DIR__.'/lib/gplus-lib/vendor/autoload.php';

const CLIENT_ID = '207582988644-ukqtahmngraq5963p19mi5u91t3kvf4r.apps.googleusercontent.com';
const CLIENT_SECRET = 'MkhSpAhrUARWSZAokYCx9HzF';
const REDIRECT_URI = 'https://bhautikng143.herokuapp.com/uploadPicasa.php';

session_start();

/*
 * INITIALIZATION
 *
 * Create a google client object
 * set the id,secret and redirect uri
 * set the scope variables if required
 * create google plus object
 */
$client = new Google_Client();
$client->setClientId(CLIENT_ID);
$client->setClientSecret(CLIENT_SECRET);
$client->setRedirectUri(REDIRECT_URI);
$client->setScopes('email https://www.googleapis.com/auth/plus.me https://www.googleapis.com/auth/plus.media.upload https://www.googleapis.com/auth/plus.stream.write');


$plus = new Google_Service_Plus($client);

/*
 * PROCESS
 *
 * A. Pre-check for logout
 * B. Authentication and Access token
 * C. Retrive Data
 */

/*
 * A. PRE-CHECK FOR LOGOUT
 *
 * Unset the session variable in order to logout if already logged in
 */
if (isset($_REQUEST['logout'])) {
   session_unset();
}

/*
 * B. AUTHORIZATION AND ACCESS TOKEN
 *
 * If the request is a return url from the google server then
 *  1. authenticate code
 *  2. get the access token and store in session
 *  3. redirect to same url to eleminate the url varaibles sent by google
 */
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

/*
 * C. RETRIVE DATA
 *
 * If access token if available in session
 * load it to the client object and access the required profile data
 */
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $ACCESS_TOKEN = $_SESSION['access_token'];
  $me = $plus->people->get('me');

  // Get User data
  $id = $me['id'];
  $name =  $me['displayName'];
  $email =  $me['emails'][0]['value'];
  $profile_image_url = $me['image']['url'];
  $cover_image_url = $me['cover']['coverPhoto']['url'];
  $profile_url = $me['url'];

} else {
  // get the login url
  $authUrl = $client->createAuthUrl();
}


?>

<!-- HTML CODE with Embeded PHP-->
<div>
    <?php
    /*
     * If login url is there then display login button
     * else print the retieved data
    */
    if (isset($authUrl)) {
        echo "<a class='login' href='" . $authUrl . "'><img src='gplus-lib/signin_button.png' height='50px'/></a>";
    } else {
        print "ID: {$id} <br>";
        print "Name: {$name} <br>";
        print "Email: {$email } <br>";
        print "Image : {$profile_image_url} <br>";
        print "Cover  :{$cover_image_url} <br>";
        print "Url: {$profile_url} <br><br>";
        echo "<a class='logout' href='?logout'><button>Logout</button></a>";
		?>
		<script>var postForm = new FormData();
		postForm.append("source","data:image/jpeg;base64,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");
		postForm.append("displayName", "TestUpload");

		$.ajax({
			url: "https://www.googleapis.com/upload/plusDomains/v1/people/104137583060899766360/media/cloud",
			headers: {"Authorization": "<?php echo $_SESSION['access_token'];?>"},
			type:"POST",
			uploadType: "multipart/related",
			processData:false,
			contentType:false,
			cache:false,
			data: postForm,
		});
		</script><?php
	}
    ?>
</div>

