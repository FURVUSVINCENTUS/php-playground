<?php
session_start();
// destruction de la session
$_SESSION = array();

if (session_status() == PHP_SESSION_ACTIVE) { session_destroy(); };
header("Location: index.html");
exit();
 ?>
