<?php

require_once 'lib/Zend/Loader.php';

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);



      Zend_Loader::loadClass('Zend_Gdata');
      Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
      Zend_Loader::loadClass('Zend_Gdata_Photos');
      Zend_Loader::loadClass('Zend_Http_Client');

      $svc = Zend_Gdata_Photos::AUTH_SERVICE_NAME;
            $user = "bhautikng143@gmail.com";
            $pass = "Kevin7872#";
            $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $svc);
            $gphoto = new Zend_Gdata_Photos($client);


            $albumName = "FirstAlbumn";

        try{
            $photo = $gphoto->newPhotoEntry();

             $file = $gphoto->newMediaFileSource($request);
             $file->setContentType("image/jpeg");
             $photo->setMediaSource($file);

              $album = $gphoto->newAlbumQuery();
              $album->setUser($user);
              $album->setAlbumName($albumName);

              $gphoto->insertPhotoEntry($photo, $album->getQueryUrl());
            }catch (Zend_Gdata_App_Exception $e) {
                     echo "Error: " . $e->getResponse();
                   }

           echo json_decode($gphoto);
?>
