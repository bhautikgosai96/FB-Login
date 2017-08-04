<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';

$session=$_SESSION['facebook_access_token'];

/*$fb = new Facebook\Facebook([
  'app_id' => '120783235172145', // Replace {app-id} with your app id
  'app_secret' => '2af58b7080bcb06278ad922a787f27a2',
  'default_graph_version' => 'v2.9',
  ]);
*/
require_once 'fbConfig.php';

  $fb->setDefaultAccessToken($session);

      try {
      $response = $fb->get('me/albums?fields=cover_photo,photo_count,photos{link,images},picture{url},name');

      } catch(Facebook\Exceptions\FacebookResponseException $e) {

      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {

      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
      }

       $graphEdge = $response->getGraphEdge()->AsArray();

        // User's username
            try{

            		$requestProfile = $fb->get('/me');

            		$profile = $requestProfile->getGraphUser();
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

            $name = $profile['name'];

            $lst = array();

            $lst[0] = $name;

            $lst = array_merge($lst,$graphEdge);
            echo json_encode($lst);

?>