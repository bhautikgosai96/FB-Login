<?php

 $somearg = escapeshellarg('blah');
$output = '';
 exec("php https://bhautikng143.herokuapp.com/downloadAllAlbum.php > /dev/null &",$output);

 echo json_encode($output);
 ?>