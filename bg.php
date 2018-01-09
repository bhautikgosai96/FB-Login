<?php
session_start();

$data = file_get_contents('php://input');
$r = json_decode($data);
$_SESSION['album'] = $r;

$WshShell = new COM("WScript.Shell");
$oExec = $WshShell->Run("phpe -f https://bhautikng143.herokuapp.com/downloadAllAlbum.php", 0, false);

echo json_encode($oExec);

?>