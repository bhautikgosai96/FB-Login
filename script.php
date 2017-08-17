<?php

 $somearg = escapeshellarg('blah');
$output = '';
 exec("php https://bhautikng143.herokuapp.com/downloadAllAlbumn.php $output > /dev/null &");

 echo json_encode($output);
 ?>