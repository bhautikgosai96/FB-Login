<?php

require_once 'lib/Zend/Loader.php';

$postdata = file_get_contents('php://input');
$request = json_decode($postdata);



      Zend_Loader::loadClass('Zend_Gdata');
      Zend_Loader::loadClass('Zend_Gdata_ClientLogin');
      Zend_Loader::loadClass('Zend_Gdata_Photos');
      Zend_Loader::loadClass('Zend_Http_Client');

     $serviceName = Zend_Gdata_Photos::AUTH_SERVICE_NAME;

     $user = "bhautikng143@gmail.com";
     $pass = "Kevin7872#";

     $client = Zend_Gdata_ClientLogin::getHttpClient($user, $pass, $serviceName);

     $gp = new Zend_Gdata_Photos($client, "Google-DevelopersGuide-1.0");

     echo "success";
?>
