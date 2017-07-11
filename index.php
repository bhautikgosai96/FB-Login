<?php

session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';
require_once 'fbConfig.php';

$helper = $fb->getRedirectLoginHelper();

$permissions = ['email','user_photos']; // Optional permissions
$loginUrl = $helper->getLoginUrl('https://bhautikng143.herokuapp.com/fb-callback.php', $permissions);

//echo '<a href="' . $loginUrl. '">Log in with Facebook!</a>';
session_write_close();
?>

<html>
    <head>
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="lib/css/index.css">
    </head>
    <body>
        <div>
            <div class="row ">
                <div class="col-md-offset-1 col-md-10 header">
                <h2>PHP Web Engineer Assignment</h2>
                <h3>Facebook-Albumn Challenge</h3>
                </div>
            </div>
            <br/>
            <div class="row">
                 <button class="col-md-offset-1 col-md-4 login"><?php echo' <a  href="'.$loginUrl . '" class="loginText" >';
                    echo ' <h4>Sign in with Facebook</h4>';
                    echo ' </a> '; ?>
                 </button>
            </div>
        </div>
    </body>
</html>