

<?php
    echo "hello";
    require_once 'google-api-php-client/src/Google_Client.php';
    require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
    echo "hello1";
    $client = new Google_Client();
    // Get your credentials from the console
    $client->setClientId('207582988644-ukqtahmngraq5963p19mi5u91t3kvf4r.apps.googleusercontent.com');
    $client->setClientSecret('MkhSpAhrUARWSZAokYCx9HzF');
    $client->setRedirectUri('https://bhautikng143.herokuapp.com/upload.php');
    $client->setScopes(array('https://www.googleapis.com/auth/drive'));

    $service = new Google_DriveService($client);

    $authUrl = $client->createAuthUrl();

    //Request authorization
    echo "Please visit:\n$authUrl\n\n";
    echo "Please enter the auth code:\n";
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for access token
    $accessToken = $client->authenticate($authCode);
    $client->setAccessToken($accessToken);

    //Insert a file
    $file = new Google_DriveFile();
    //$localfile = 'try.jpeg';

    //$title = basename($localfile);
    $file->setTitle('My Photo');
    $file->setDescription('My File');
    //$file->setMimeType('image/jpeg');
    $file->setMimeType('text/plain');
    $data = file_get_contents('test.txt');

    $createdFile = $service->files->insert($file, array(
          'data' => $data,
          'mimeType' => 'text/plain',
        ));

    print_r($createdFile);
    ?>