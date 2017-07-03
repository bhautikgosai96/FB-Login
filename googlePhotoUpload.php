<?php
      require_once 'Zend/Loader.php';
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



      // sanitize input
      $title = "cricket";
      $tags = "cricket photo";

      // set album name
      $albumName = "first";

      // construct photo object
      // save to server
      try {
        $photo = $gphoto->newPhotoEntry();

        // set file
        $file = $gphoto->newMediaFileSource("cricket2.jpg");
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
?>
/*<?php
    $userid = 'bhautikng143@gmail.com';

    // build feed URL
    $feedURL = "http://picasaweb.google.com/data/feed/api/user/$userid?kind=album";

    // read feed into SimpleXML object
    $sxml = simplexml_load_file($feedURL);

    // get album names and number of photos in each
    echo "<ul>";
    foreach ($sxml->entry as $entry) {
      $title = $entry->title;
      $gphoto = $entry->children('http://schemas.google.com/photos/2007');
      $numphotos = $gphoto->numphotos;
      echo "<li>$title - $numphotos photo(s)</li>\n";
    }
    echo "</ul>";
    ?>
*/