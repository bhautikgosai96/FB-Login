
<?php
require_once 'google-api-php-client-2.2.0/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig('client_credentials.json');
$client->setRedirectUri('https://bhautikng143.herokuapp.com/upload.php');
$client->setScopes('https://www.googleapis.com/auth/drive');

 $authUrl = $client->createAuthUrl();
    printf("Open the following link in your browser:\n%s\n", $authUrl);
    print 'Enter verification code: ';
    $authCode = trim(fgets(STDIN));

    // Exchange authorization code for an access token.
    $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

    $client->setAccessToken($accessToken);

    $service = new Google_Service_Drive($client);

    $fileMetadata = new Google_Service_Drive_DriveFile(array(
      'name' => 'try.jpg'));
    $content = file_get_contents('try.jpg');
    $file = $service->files->create($fileMetadata, array(
      'data' => $content,
      'mimeType' => 'image/jpeg',
      'uploadType' => 'multipart',
      'fields' => 'id'));
    printf("File ID: %s\n", $file->id);


?>