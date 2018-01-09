<?php
session_start();

$data = file_get_contents('php://input');
$r = json_decode($data);
$_SESSION['album'] = $r;


$oExec = exec("php https://bhautikng143.herokuapp.com/downloadAllAlbum.php > /dev/null &");

echo json_encode($oExec);

?>