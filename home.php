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



    print_r($lst);
    $len = sizeof($lst);


$final = array();

  for($i = 0; $i<$len; $i++){
    $all_photos = array();

            $albumnId = $lst[$i]["id"];

 try {
                                    //$response1 = $fb->get('527185053990644/photos?fields=source&limit=500');
                                     $response1 = $fb->get($albumnId.'/photos?fields=source&limit=500');
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
                              $photos = $response1->getGraphEdge();
                              if ($fb->next($photos)) {
                              		$photos_array = $photos->asArray();
                              		$all_photos = array_merge($photos_array, $all_photos);
                              		while ($photos = $fb->next($photos)) {
                              			$photos_array = $photos->asArray();
                              			$all_photos = array_merge($photos_array, $all_photos);
                              		}
                              	} else {
                              		$photos_array = $photos->asArray();
                              		$all_photos = array_merge($photos_array, $all_photos);
                              	}
                              print_r($all_photos);
                              echo "<br/>";
                              echo sizeof($all_photos);
                              echo "<br/>";
                     array_push($final,$all_photos);
        }




echo json_encode($final);
echo sizeof($final);
?>




