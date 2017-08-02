<?php

    require_once 'google-api-php-client/src/Google_Client.php';
    require_once 'google-api-php-client/src/contrib/Google_DriveService.php';
    session_start();
    $driveAlbumnList = $_SESSION['driveAlbumnList'];
    $driveUserName = $_SESSION['DriveUserName'];
    //$driveImg = $_SESSION['driveImg'];

//   print_r($driveAlbumnList);
  // print_r($driveUserName);
   // print_r($driveImg);


    $client = new Google_Client();

    $client->setClientId('207582988644-ukqtahmngraq5963p19mi5u91t3kvf4r.apps.googleusercontent.com');
    $client->setClientSecret('MkhSpAhrUARWSZAokYCx9HzF');
    $client->setRedirectUri('https://bhautikng143.herokuapp.com/uploadAllAlbumn.php');
    $client->setScopes(array('https://www.googleapis.com/auth/drive'));


    $service = new Google_DriveService($client);
            $authUrl = $client->createAuthUrl();

            //Request authorization
            //print "Please visit:\n$authUrl\n\n";
            //print "Please enter the auth code:\n";
            $authCode = trim(fgets(STDIN));

            // Exchange authorization code for access token
            $accessToken = $client->authenticate($authCode);
            $client->setAccessToken($accessToken);



        $folder = new Google_DriveFile();

        $folder->setTitle('facebook_'.$driveUserName.'_albums');
        $folder->setMimeType('application/vnd.google-apps.folder');
        $newFolder = $service->files->insert($folder,array(
                   'mimeType' => 'application/vnd.google-apps.folder',
             ));
        //print_r($newFolder);
        $parentId = $newFolder['id'];
        //echo 'success';
        //echo $parentId;

        foreach($driveAlbumnList as $list){

            $driveAlbumnName = $list->albumnName;
            $driveImg = $list->image;

            //echo $driveAlbumnName;
            //print_r($driveImg);

            $file = new Google_DriveFile();

            $parent = new Google_ParentReference();
            $parent->setId($parentId);
            $file->setParents(array($parent));

            $file->setTitle($driveAlbumnName);
            $file->setMimeType('application/vnd.google-apps.folder');
            $newFolder1 = $service->files->insert($file,array(
                     'mimeType' => 'application/vnd.google-apps.folder',
                    ));
            $parentId1 = $newFolder1['id'];
            //echo "successsssssssss";
            //echo $parentId1;



            $count = 0;
            foreach($driveImg as $photo){

                 $count = $count + 1;

                 $file1 = new Google_DriveFile();

                 $parent2 = new Google_ParentReference();
                 $parent2->setId($parentId1);
                 $file1->setParents(array($parent2));

                $file1->setTitle('img-'.$count);
                $data = file_get_contents($photo);
                $createdFile = $service->files->insert($file1, array(
                          'data' => $data,
                          'mimeType' => 'image/jpeg',
                        ));

            }
        }
         echo "successfully uploaded!!!!";
                    echo "<br/>";
                    echo "Now, You can see your albumn in your google drive."
           // print_r($createdFile);


?>