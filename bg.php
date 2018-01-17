<?php
session_start();

//$data = file_get_contents('php://input');
//$r = json_decode(file_get_contents('php://input'));

$myArray = [1,2,3,4];

$pass_album = escapeshellarg($myArray);

$data = "hello";

//$command = "/usr/bin/php /home/[mydir]/send-mail-fork.php {$pass_subject} {$pass_message} {$pass_footer} 2> /dev/null &";
//$status = exec($command);

//$path = "/app/php/bin/php";
$output = shell_exec("php my.php $data");

echo json_encode($output);

?>