<?php

require_once 'lib/Zend/Loader.php';





      Zend_Loader::loadClass('Zend_Gdata');
      Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
      Zend_Loader::loadClass('Zend_Gdata_Photos');
      Zend_Loader::loadClass('Zend_Http_Client');

     $serviceName = Zend_Gdata_Photos::AUTH_SERVICE_NAME;

     $user = "bhautikng143@gmail.com";
     $pass = "Kevin7872#";

     $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $serviceName);

     $gp = new Zend_Gdata_Photos($client, "Google-DevelopersGuide-1.0");
$query = $gp->newAlbumQuery();

$query->setUser("default");
$query->setAlbumName("sample.albumname");

$albumFeed = $gp->getAlbumFeed($query);
foreach ($albumFeed as $albumEntry) {
    echo $albumEntry->title->text . "<br />\n";
}
?>
