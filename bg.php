<?php
session_start();

//$data = file_get_contents('php://input');
//$r = json_decode(file_get_contents('php://input'));

$_SESSION['data'] = "hello";

$pass_album = escapeshellarg($_SESSION['data']);


//$command = "/usr/bin/php /home/[mydir]/send-mail-fork.php {$pass_subject} {$pass_message} {$pass_footer} 2> /dev/null &";
//$status = exec($command);

//$path = "/app/php/bin/php";
$output = shell_exec("php my.php {$pass_album} 2> /dev/null &");

echo json_encode($output);

?>