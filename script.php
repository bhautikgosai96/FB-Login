<?php

 $somearg = escapeshellarg('blah');

 exec("php https://bhautikng143.herokuapp.com/downloadAllAlbumn.php > /dev/null 2>&1 &", $output);

 echo json_encode($output);
 ?>