<?php

session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';

$session=$_SESSION['facebook_access_token'];

require_once 'fbConfig.php';

  $fb->setDefaultAccessToken($session);

try {
      $response = $fb->get('me/albums?fields=id,name,count&limit=500');
        //$photos = $response->getGraphEdge();
      } catch(Facebook\Exceptions\FacebookResponseException $e) {

      // When Graph returns an error
      echo 'Graph returned an error: ' . $e->getMessage();
      exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {

      // When validation fails or other local issues
      echo 'Facebook SDK returned an error: ' . $e->getMessage();
      exit;
      }
    $lst= $response->getGraphEdge()->AsArray();

    $all_array = array();

    print_r($lst);
    $len = sizeof($lst);

    try {
                                    $response1 = $fb->get('936566536385825/photos?fields=source&limit=500');
                                     //$response1 = $fb->get('\''.$albumnId.'/photos?fields=source&limit=500'.'\'');
                                      //$photos = $response->getGraphEdge();
                                    } catch(Facebook\Exceptions\FacebookResponseException $e) {

                                    // When Graph returns an error
                                    echo 'Graph returned an error: ' . $e->getMessage();
                                    exit;
                                    } catch(Facebook\Exceptions\FacebookSDKException $e) {

                                    // When validation fails or other local issues
                                    echo 'Facebook SDK returned an error: ' . $e->getMessage();
                                    exit;
                                    }
                              $lst1= $response1->getGraphEdge()->AsArray();



echo json_encode($lst1);
?>




