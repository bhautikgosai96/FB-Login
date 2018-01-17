<?php

session_start();
//$request= $_SESSION["album"];

$r = $argv[1];
echo $r;
print_r($r);
foreach($r as $i){
    echo $i;
}
echo "This is my.php";
echo $r;


?>