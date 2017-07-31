<?php

    require_once 'google-api-php-client/src/Google_Client.php';
    require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

    $client = new Google_Client();

    $client->setClientId('207582988644-ukqtahmngraq5963p19mi5u91t3kvf4r.apps.googleusercontent.com');
    $client->setClientSecret('MkhSpAhrUARWSZAokYCx9HzF');
    $client->setRedirectUri('https://bhautikng143.herokuapp.com/upload.php');
    $client->setScopes(array('https://www.googleapis.com/auth/drive'));



            $authUrl = $client->createAuthUrl();

            //Request authorization
            print "Please visit:\n$authUrl\n\n";
            print "Please enter the auth code:\n";
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for access token
            $accessToken = $client->authenticate($authCode);
            $client->setAccessToken($accessToken);

    $service = new Google_DriveService($client);

    $folder = new Google_DriveFile();

    $folder->setTitle('albumn');
    $folder->setMimeType('application/vnd.google-apps.folder');
    $newFolder = $service->files->insert($folder,array(
               'mimeType' => 'application/vnd.google-apps.folder',
         ));

    $parentId = $newFolder['id'];
    echo 'success';
    print_r($parentId);
?>