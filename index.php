<?php

session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '120783235172145', // Replace {app-id} with your app id
  'app_secret' => '2af58b7080bcb06278ad922a787f27a2',
  'default_graph_version' => 'v2.9',
  ]);

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
                           <div class="header">
                           <p style="font-size:2.2em">PHP Web Engineer Assignment</p>
                           <p style="font-size:1.7em; padding-left: 12%">Facebook-Albumn Challenge</p>
                           </div>
            </div>
                       <br/>
                       <div class="row">
                            <div class="login">
                            <?php echo '<a  href="'.$loginUrl . '" class="loginText">';
                            echo '<p style="font-size:20px;">Sign in with Facebook</p>';
                            echo '</a>';
                            ?>
                            </div>
                       </div>

                      <div class="row">
                      			<div class="develop">
                      			<h4>Developed by bhautik gosai</h4>
                      			</div>
                      </div>
        </div>
    </body>
</html>