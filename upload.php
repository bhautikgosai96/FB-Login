<?php
    require_once '/src/google-api-php-client-master/src/google/Client.php';
    require_once '/src/google-api-php-client-master/src/google/Service.php';

    $client = new Google_Client();
    // Get your credentials from the console
    $client->setClientId('120783235172145');
    $client->setClientSecret('2af58b7080bcb06278ad922a787f27a2');
    $client->setRedirectUri('urn:ietf:wg:oauth:2.0:oob');
    $client->setScopes(array('https://www.googleapis.com/auth/drive'));

    $service = new Google_DriveService($client);

    $authUrl = $client->createAuthUrl();

    //Request authorization
    print "Please visit:\n$authUrl\n\n";
    print "Please enter the auth code:\n";
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for access token
    $accessToken = $client->authenticate($authCode);
    $client->setAccessToken($accessToken);

    //Insert a file
    $file = new Google_DriveFile();
    $localfile = '/lib/image/background.jpg';
    $title = basename($localfile);
    $file->setTitle($title);
    $file->setDescription('My File');
    $file->setMimeType('image/jpeg');

    $data = file_get_contents($localfile);

    $createdFile = $service->files->insert($file, array(
          'data' => $data,
          'mimeType' => 'image/jpeg',
        ));

    print_r($createdFile);
    ?>