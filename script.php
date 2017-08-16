<?php

 $somearg = escapeshellarg('blah');

 exec("php https://bhautikng143.herokuapp.com/downloadAllAlbumn.php $output > /dev/null 2>&1 &");

 echo json_encode($output);
 ?>