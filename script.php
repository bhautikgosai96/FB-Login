<?php

 $somearg = escapeshellarg('blah');

 exec("php https://bhautikng143.herokuapp.com/downloadAllAlbumn.php > /dev/null &", $output);

 echo json_encode($output);
 ?>