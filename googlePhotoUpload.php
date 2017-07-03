<?php
      require_once 'lib/Zend/Loader.php';
      Zend_Loader::loadClass('Zend_Gdata');
      Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
      Zend_Loader::loadClass('Zend_Gdata_Photos');
      Zend_Loader::loadClass('Zend_Http_Client');

      // connect to service
      $serviceName = Zend_Gdata_Photos::AUTH_SERVICE_NAME;
      $user = "bhautikng143@gmail.com";
      $pass = "Kevin7872#";

      $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $serviceName);

      // update the second argument to be CompanyName-ProductName-Version
      $gp = new Zend_Gdata_Photos($client, "Google-DevelopersGuide-1.0");

        $entry = new Zend_Gdata_Photos_AlbumEntry();
        $entry->setTitle($gp->newTitle("New album"));
        $entry->setSummary($gp->newSummary("This is an album."));

        $createdEntry = $gp->insertAlbumEntry($entry);
      echo 'Albumn successfully added!';
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