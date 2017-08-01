<?php

    require_once 'google-api-php-client/src/Google_Client.php';
    require_once 'google-api-php-client/src/contrib/Google_DriveService.php';

    $driveAlbumnName = $_SESSION['driveAlbumn'];
    $driveUserName = $_SESSION['DriveUserName'];
    $driveImg = $_SESSION['driveImg'];

    print_r($driveAlbumnName);
    print_r(driveUserName);
    print_r(driveImg);
    $client = new Google_Client();

    $client->setClientId('207582988644-ukqtahmngraq5963p19mi5u91t3kvf4r.apps.googleusercontent.com');
    $client->setClientSecret('MkhSpAhrUARWSZAokYCx9HzF');
    $client->setRedirectUri('https://bhautikng143.herokuapp.com/upload.php');
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



        $folder = new Google_DriveFile();

        $folder->setTitle('facebook');
        $folder->setMimeType('application/vnd.google-apps.folder');
        $newFolder = $service->files->insert($folder,array(
                   'mimeType' => 'application/vnd.google-apps.folder',
             ));
        print_r($newFolder);
        $parentId = $newFolder['id'];
        echo 'success';
        echo $parentId;

        $file = new Google_DriveFile();

        $parent = new Google_ParentReference();
        $parent->setId($parentId);
        $file->setParents(array($parent));

        $file->setTitle('Insidealbumn');
        $file->setMimeType('application/vnd.google-apps.folder');
        $newFolder1 = $service->files->insert($file,array(
                 'mimeType' => 'application/vnd.google-apps.folder',
                ));
        $parentId1 = $newFolder1['id'];
        echo "successssssssssssssssssssssssssssssss";
        echo $parentId1;

        $file1 = new Google_DriveFile();

                $parent2 = new Google_ParentReference();
                $parent2->setId($parentId1);
                $file1->setParents(array($parent2));


        $data = file_get_contents('try.jpg');
        $createdFile = $service->files->insert($file1, array(
                  'data' => $data,
                  'mimeType' => 'image/jpeg',
                ));
            echo "successsss";
            print_r($createdFile);


?>