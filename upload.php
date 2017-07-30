

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

    //create folder

    $folder_mime = "application/vnd.google-apps.folder";
    $folder_name = 'facebook Albumn';

    //Insert a file

    $folder = new Google_DriveFile();

    $folder->setTitle($folder_name);
    $folder->setMimeType($folder_mime);
    $newFolder = $service->files->insert($folder, array(

                    'mimeType' => 'application/vnd.google-apps.folder',
               ));
    print_r($newFolder);
    echo "success";
    print_r($newFolder['id']);
    $parentId  = $newFolder['id'];

    $file = new Google_DriveFile();

    $parent = new ParentReference();
    $parent->setId($parentId);
    $file->setParents(array($parent));


      $file->setTitle('Myfirstphoto');
      $file->setDescription('My File');
      $file->setMimeType('image/jpeg');


     $data = file_get_contents('try.jpg');
     $createdFile = $service->files->insert($file, array(
              'data' => $data,
              'mimeType' => 'image/jpeg',
            ));

        print_r($createdFile);
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