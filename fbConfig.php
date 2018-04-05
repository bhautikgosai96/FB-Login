  <?php

      //$app_id='120783235172145';
      $app_id='1856677094625240';
      //$app_sec='2af58b7080bcb06278ad922a787f27a2';
      $app_sec='76febd3c42e0621fb8560055b56869e0';

      $g_v='v2.9';
      $callBack='https://bhautikng143.herokuapp.com/fb-callback.php';

      $fb = new Facebook\Facebook([
      'app_id' => $app_id, // Replace {app-id} with your app id
      'app_secret' =>$app_sec ,
      'default_graph_version' =>$g_v

      ]);

  ?>