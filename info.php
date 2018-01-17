{albumnName:"",image:}

<?php

ignore_user_abort(1);
set_time_limit(0);

$data = file_get_contents('php://input');
$request = json_decode($data);
//$request = $_SESSION['data'];
//print_r($request);
$zip = new ZipArchive();

$filename = 'zip-'.time().'.zip';
if($zip->open($filename, ZipArchive::CREATE)!=TRUE)
    die ("Could not open archive");


$temp=[];

foreach($request as $k){

    $img=$k->image;
    $aName=$k->albumnName;


    $count = 0;

    foreach($img as $i){
       $download_file = file_get_contents($i);
        $count = $count + 1;
        $name = $aName."-".$count.".jpg";
        array_push($temp,$name);
        file_put_contents($name,$download_file);

        $zip->addFile($name,$aName.'/'.$name);

    }

    $zip->addFile($aName);

}

$zip->close();



echo json_encode($filename);




?>


$data = file_get_contents('php://input');
$r = json_decode($data);
$filename = $r->filename;
$request = $r->album;
//$request = $_SESSION['data'];
//print_r($request);
$zip = new ZipArchive();

if($filename == 'new'){
    $filename = 'zip-'.time().'.zip';
    if($zip->open($filename, ZipArchive::CREATE)!=TRUE)
        die ("Could not open archive");


    $temp=[];

    foreach($request as $k){

        $img=$k->image;
        $aName=$k->albumnName;


        $count = 0;

        foreach($img as $i){
           $download_file = file_get_contents($i);
            $count = $count + 1;
            $name = $aName."-".$count.".jpg";
            array_push($temp,$name);
            file_put_contents($name,$download_file);

            $zip->addFile($name,$aName.'/'.$name);

        }

        $zip->addFile($aName);

    }

    $zip->close();
echo json_encode($filename);
}else{

    $zip->open($filename, ZipArchive::CREATE)

        $temp=[];

        foreach($request as $k){

            $img=$k->image;
            $aName=$k->albumnName;


            $count = 0;

            foreach($img as $i){
               $download_file = file_get_contents($i);
                $count = $count + 1;
                $name = $aName."-".$count.".jpg";
                array_push($temp,$name);
                file_put_contents($name,$download_file);

                $zip->addFile($name,$aName.'/'.$name);

            }

            $zip->addFile($aName);

        }

        $zip->close();
echo json_encode($filename);
}










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

      //user albumn
      try {
      $response = $fb->get('me/albums?fields=cover_photo,photo_count,photos{link,images},picture{url},name');
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

       $graphEdge = $response->getGraphEdge()->AsArray();
/*$all_photos = array();
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
	}*/
	        // User's  username
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



/*try {
                    $response1 = $fb->get('936566536385825/photos?fields=source&limit=500');
                     $response1 = $fb->get('\''.$albumnId.'/photos?fields=source&limit=500'.'\'');
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

              $albumnObj->albumnName = $oneAlbumn->name;
              $albumnObj->photo_count = $oneAlbumn->count;
              $albumnObj->photo_list = $lst1;

              $obj = json_encode($albumnObj);

              $all_array = array_merge($all_array,array($obj))*/










            try {
                                //$response1 = $fb->get('936566536385825/photos?fields=source&limit=500');
                                 $response1 = $fb->get('\''.$albumnId.'/photos?fields=source&limit=500'.'\'');
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

                          $albumnObj->albumnName = $lst[$i]["name"];
                          $albumnObj->photo_count = $lst[$i]["count"];
                          $albumnObj->photo_list = $lst1;

                          $obj = json_encode($albumnObj);

                          $all_array = array_merge($all_array,array($obj))



  for($i = 0; $i<$len; $i++){


            $albumnId = $lst[$i]["id"];
            echo '\''.$albumnId.'/photos?fields=source&limit=500'.'\'';


        }



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
                                   $lst1= $response1->getGraphEdge()->AsArray();
                                   print_r($lst1);
                                   echo "<br/>";
                                   echo sizeof($lst1);
                                   echo "<br/>";
                          $all_array = array_push($all_array,$lst1);




      foreach($temp as $n){

      	unlink($n);
      	//removing file from server
      }