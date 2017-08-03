# Facebook Albumn Challenge
# Live Demo: https://bhautikng143.herokuapp.com

This web application authenticates user using Facebook authentication and fetchs user's albumn data.
It allows user to download albumn with different option.
User can download single albumn, selected multiple albumns and all albumn.
This web application downloads albumn in zip format.

#First Step:
Get app_id and app_secret from https://developers.facebook.com
and change configuration file 'fbConfig.php'

code:

$fb = new Facebook\Facebook([
      'app_id' => $app_id, // Replace {app-id} with your app id
      'app_secret' =>$app_sec ,
      'default_graph_version' =>$g_v
       ]);

In this project, application needs user's permissions to get access of user's album data.
Application is making a call to Facebook Graph API to get necessary data.
To control access of data you can have options which requires to be setup in home.PHP file.

By setting up home.PHP, resonse will be retrieved in json format as below:

code:

 $response = $fb->get('me/albums?fields=cover_photo,photo_count,photos{link,images},picture{url},name');

#Step 2:
Once data retrieved, user redirects to 'home.html'.

'Angularjs Framework' is used for client side logic,

There are three function:

-> Download single albumn
-> Download multiple albumn
-> download all albumn

After selecting on eof the option, data is passed to PHP api,
PHP api fetches, downloads content to server and provide unique albumn's link to download in zip format.

code:

$download_file=file_get_contents($file);
//Get content(image) from url

file_put_contents($name,$download_file);
//stores data in server
//$name is name of file

$zip->addFile($name);
//Adds file in zip

#Step 3:

First You have to get credentials for google authentication for that go to 'console.developers.google.com'
and set in upload.php and uploadAllAlbumn.php

Yoe have to download google-api-client library.

And then uploads photo in drive
code:
      $file1 = new Google_DriveFile();
      //create file

      $file1->setTitle('file name');
      //give required parameter

       $createdFile = $service->files->insert($file1, array(
                            'data' => file_get_contents('file name which you want to upload'),
                            'mimeType' => 'image/jpeg',
                          ));

#Third Party library:

1. Facebook PHP sdk V5
-https://developers.facebook.com/docs/php/gettingstarted
2. Angular JS
-https://angularjs.org/
3. Bootstrap
-http://v4-alpha.getbootstrap.com/
4.PHPUnit 5.5
-https://phpunit.de/
5.Upload photo in Google drive
-https://developers.google.com/drive/v3/web/quickstart/php
6. PHP 5.4 or more



#Develop By;- Bhautik Gosai
Github Profile:- https://github.com/bhautikgosai96

