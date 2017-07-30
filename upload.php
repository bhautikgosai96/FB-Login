

<?php

    require_once 'google-api-php-client/src/Google_Client.php';
    require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

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

    //create folder

    $folder_mime = "application/vnd.google-apps.folder";
    $folder_name = 'facebook Albumn';

    //Insert a file
    $service = new Google_DriveService($client);
    $folder = new Google_DriveFile();

    $folder->setTitle($folder_name);
    $folder->setMimeType($folder_mime);
    $newFolder = $service->files->insert($folder);

    $parentId  = $newFolder['id'];


    $service = new Google_DriveService($client);
    $file = new Google_DriveFile();

    if ($parentId != null) {
        $parent = new Google_ParentReference();
        $parent->setId($parentId);
        $file->setParents(array($parent));
    }

    $file->setTitle('photo.jpg');
    $file->setDescription('This is a photo in folder);
    $file->setMimeType('image/jpeg');
    $data = file_get_contents('try.jpg');
    try {
    return $service->files->insert(
        $file,
        array(
            'data' => $data;
        )
    );
    } catch (Exception $e) {
    print "An error occurred: " . $e->getMessage();
    }
    //$localfile = 'try.jpeg';

    //$title = basename($localfile);
    //$file->setTitle('MyPhoto1');
    //$file->setDescription('My File');
    //$file->setMimeType('image/jpeg');
    //$file->setMimeType('text/plain');

    //$data = file_get_contents('test.txt');
      //  $data = file_get_contents('try.jpg');
    //$createdFile = $service->files->insert($file, array(
      //    'data' => $data,
        //  'mimeType' => 'image/jpeg',
        //));

    //print_r($createdFile);
    ?>