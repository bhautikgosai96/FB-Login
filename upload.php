<?php
echo "hello";
    require_once 'google-api-php-client-2.2.0/vendor/autoload.php';
echo"h1";
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

    $client = new Google_Client();
    $client->setAuthConfig('client_credentials.json');
    $client->setRedirectUri($redirect_uri);
    $client->addScope("https://www.googleapis.com/auth/drive");



     if(empty($_GET['code']))
            {
                $client->authenticate();
            }

      $accessToken = $client->authenticate($_GET['code']);
             $client->setAccessToken($accessToken);


?>
