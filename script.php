<?php

 $somearg = escapeshellarg('blah');

 exec("php https://bhautikng143.herokuapp.com/downloadAllAlbumn.php $somearg > /dev/null &");

 echo json_encode($somearg);
 ?>