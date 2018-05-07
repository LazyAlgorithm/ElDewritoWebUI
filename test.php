<?php
 $master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)  or die("Failed: socket_create()");
 $master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)  or die("Failed: socket_create()");
 socket_connect($master, 'localhost', 11776);
 $message = "Someone3";
 socket_send ( $master , $message , strlen($message) , MSG_DONTROUTE);
 $messages = "";
 socket_recv ( $master ,  $messages , 4000 , MSG_WAITALL );
 socket_close ( $master );
 echo ($messages[0]);
?>