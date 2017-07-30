<?php
require_once 'google-api-php-client-2.2.0/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfigFile('client_credentials.json');
$client->setRedirectUri('http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php');
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

if (! isset($_GET['code'])) {
  $auth_url = $client->createAuthUrl();
  header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
} else {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

$fileMetadata = new Google_Service_Drive_DriveFile(array(
  'name' => 'photo.jpg'));
$content = file_get_contents('try.jpg');
$file = $driveService->files->create($fileMetadata, array(
  'data' => $content,
  'mimeType' => 'image/jpeg',
  'uploadType' => 'multipart',
  'fields' => 'id'));
printf("File ID: %s\n", $file->id);
print_r("File ID: %s\n", $file->id);

?>