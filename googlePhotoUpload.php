<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <title>Listing album contents</title>
    <style>
    body {
      font-family: Verdana;
    }
    h2 {
      color: red;
      text-decoration: none;
    }
    span.attr {
      font-weight: bolder;
    }
    img {
      float: left;
    }
    </style>
  </head>
  <body>
    <?php
    // load library
    require_once 'Zend/Loader.php';
    Zend_Loader::loadClass('Zend_Gdata');
    Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
    Zend_Loader::loadClass('Zend_Gdata_Photos');
    Zend_Loader::loadClass('Zend_Http_Client');

    // create authenticated HTTP client for Picasa service
    $svc = Zend_Gdata_Photos::AUTH_SERVICE_NAME;
    $user = "bhautikng143@gmail.com";
    $pass = "Kevin7872#";
    $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $svc);
    $gphoto = new Zend_Gdata_Photos($client);

    // generate query to get album feed
    $query = $gphoto->newAlbumQuery();
    $query->setUser("default");
    $query->setAlbumName("First");

    // get and parse album feed
    // get album name and number of photos
    try {
      $feed = $gphoto->getAlbumFeed($query);
    } catch (Zend_Gdata_App_Exception $e) {
      echo "Error: " . $e->getResponse();
    }
    ?>
    <h1><?php echo $feed->getTitle(); ?></h1>
    <?php echo $feed->getTotalResults(); ?> photo(s) found.
    <p/>

    <?php
    // process each photo entry
    // print each entry's title, size, dimensions, tags, and thumbnail image
    foreach ($feed as $entry) {
      $title = $entry->getTitle();
      $summary = $entry->getSummary();
      $thumbnail = $entry->getMediaGroup()->getThumbnail();
      $tags = $entry->getMediaGroup()->getKeywords();
      $size = $entry->getGphotoSize();
      $height = $entry->getGphotoHeight();
      $width = $entry->getGphotoWidth();

      echo "<h2>$summary</h2>\n";
      echo "<table><tr><td><img src=\"" .
      $thumbnail[1]->url . "\"/></td>\n";
      echo "<td><span class=\"attr\">File</span>: $title
      <br />\n";
      echo "<span class=\"attr\">Size</span>: $size bytes
      ($height x $width) <br />\n";
      echo "<span class=\"attr\">Tags</span>: $tags
      </td></tr></table>\n";
    }
    ?>

  </body>
</html>




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