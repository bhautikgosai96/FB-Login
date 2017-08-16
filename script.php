<?php

 $somearg = escapeshellarg('blah');

 exec("php https://bhautikng143.herokuapp.com/downloadAllAlbumn.php", $output);

 echo json_encode($output);
 ?>