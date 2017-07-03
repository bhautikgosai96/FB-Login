<?php
require_once 'lib/picasa/autoload.php';
// $cacher = new Doctrine\Common\Cache\ArrayCache();


session_start();
$cacher = new Doctrine\Common\Cache\FilesystemCache('/tmp');


    $uploader = RemoteImageUploader\Factory::create('Picasa', array(
        'cacher'         => $cacher,
        'api_key'        => '207582988644-ukqtahmngraq5963p19mi5u91t3kvf4r.apps.googleusercontent.com',
        'api_secret'     => 'MkhSpAhrUARWSZAokYCx9HzF',

        // if `album_id` is `null`, this script will automatic
        // create a new album for storage every 2000 photos
        // (due Google Picasa's limitation)
        'album_id'               => null,
        'auto_album_title'       => "MyAlbumn",
        'auto_album_access'      => 'public',
        'auto_album_description' => 'App created by sagar bhatt',

        // if you have `refresh_token` you can set it here
        // to pass authorize action.
        'refresh_token' => null,
    ));

    $callbackUrl = 'http'.(getenv('HTTPS') == 'on' ? 's' : '').'://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    //echo var_dump($callbackUrl);
    //echo '<script> alert('.var_dump($callbackUrl).');</script>';
    $uploader->authorize($callbackUrl);

    //$url = $uploader->upload('/Volumes/Data/Data/Photos/My Icon/ninja.JPG');
    //var_dump($url);

    // http://dantri.vcmedia.vn/Uploaded/2011/04/08/9f5anh%205.JPG

    $url = $uploader->upload('http://www.w3resource.com/w3r_images/php-isset-function.png');
    //$url = $uploader->transload('http://www.w3resource.com/w3r_images/php-isset-function.png');

//    $_SESSION['picasaUpload'] =$filename;

    session_destroy();
    echo "<script>alert('Album successfully uploaded')</script>";


//header("Location: https://picasaweb.google.com/home");

?>