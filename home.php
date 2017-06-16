<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';
$session=$_SESSION['facebook_access_token'];
$fb = new Facebook\Facebook([
  'app_id' => '120783235172145', // Replace {app-id} with your app id
  'app_secret' => '2af58b7080bcb06278ad922a787f27a2',
  'default_graph_version' => 'v2.9',
  ]);

  $fb->setDefaultAccessToken($session);

      try {
      $response = $fb->get('me/albums?fields=cover_photo,photo_count,photos{link,images},picture{url},name');
     // $userNode = $response->getGraphUser();
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
      }

       //$get_data = $response->getDecodedBody();
       $graphEdge = $response->getGraphEdge()->AsArray();
       //$ob = $response -> getGraphObject() -> AsArray();


       //echo json_encode($graphEdge);

        // User profile picture
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

            $name = $profile['name'];
            echo json_encode($name);
        	// showing picture on the screen

       //echo $obj;

      //echo $graphEdge;

?>