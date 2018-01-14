<?php
session_start();

$data = file_get_contents('php://input');
$r = json_decode($data);
$_SESSION['album'] = $r;

$path = shell_exec("whereis php");
$output = shell_exec(sprintf("%s downloadAllAlbum.php", $path));

echo json_encode($path);

?>