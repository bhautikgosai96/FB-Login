<?php
require_once 'lib/Zend/Loader.php';
      Zend_Loader::loadClass('Zend_Gdata');
      Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
      Zend_Loader::loadClass('Zend_Gdata_Photos');
      Zend_Loader::loadClass('Zend_Http_Client');

      // connect to service
      $svc = Zend_Gdata_Photos::AUTH_SERVICE_NAME;
      $user = "bhautikng143@gmail.com";
      $pass = "Kevin7872#";
      $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $svc);
      $gphoto = new Zend_Gdata_Photos($client);

      // validate input
      if (empty($_POST['title'])) {
        die('ERROR: Missing title');
      }

      // sanitize input
      $title = htmlentities($_POST['title']);
      $tags = htmlentities($_POST['tags']);

      // set album name
      $albumName = "France2008";

      // construct photo object
      // save to server
      try {
        $photo = $gphoto->newPhotoEntry();

        // set file
        $file = $gphoto->newMediaFileSource($_FILES['photofile']['tmp_name']);
        $file->setContentType("image/jpeg");
        $photo->setMediaSource($file);

        // set title
        $photo->setSummary($gphoto->newSummary($title));

        // set tags
        $photo->mediaGroup = new Zend_Gdata_Media_Extension_MediaGroup();
        $keywords = new Zend_Gdata_Media_Extension_MediaKeywords();
        $keywords->setText($tags);
        $photo->mediaGroup->keywords = $keywords;

        // link to album
        $album = $gphoto->newAlbumQuery();
        $album->setUser($user);
        $album->setAlbumName($albumName);

        // save photo
        $gphoto->insertPhotoEntry($photo, $album->getQueryUrl());
      } catch (Zend_Gdata_App_Exception $e) {
        echo "Error: " . $e->getResponse();
      }
      echo 'Photo successfully added!';
    }
    ?>