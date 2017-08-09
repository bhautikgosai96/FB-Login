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

    $final_array = json_encode($lst);
    foreach($final_array as $x){


            $albumnId = $x->id;

            array_push($all_array,$albumnId);

        }


echo json_encode($all_array);
?>




