
<?php
require_once 'google-api-php-client-2.2.0/vendor/autoload.php';

session_start();

$client = new Google_Client();
$client->setAuthConfig('client_credentials.json');
$client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
  $drive = new Google_Service_Drive($client);
  $files = $drive->files->listFiles(array())->getItems();
  echo json_encode($files);
  print_r($file);
} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

$fileMetadata = new Google_Service_Drive_DriveFile(array(
  'name' => 'photo.jpg'));
$content = file_get_contents('files/try.jpg');
$file = $driveService->files->create($fileMetadata, array(
  'data' => $content,
  'mimeType' => 'image/jpeg',
  'uploadType' => 'multipart',
  'fields' => 'id'));
printf("File ID: %s\n", $file->id);
print_r("File ID: %s\n", $file->id);

?>