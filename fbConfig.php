<?php

    $app_id='120783235172145';
    $app_sec='2af58b7080bcb06278ad922a787f27a2';
    $g_v='v2.7';
    $callBack='https://bhautikng143.herokuapp.com/fb-callback.php';

    $fb = new Facebook\Facebook([
    'app_id' => $app_id, // Replace {app-id} with your app id
    'app_secret' =>$app_sec ,
    'default_graph_version' =>$g_v

    ]);

?>