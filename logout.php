<?php 

require_once 'php_action/core.php';
date_default_timezone_set('Africa/Cairo');
// remove all session variables
$lastId = $_SESSION['lastId'];
$date_close = date("Y-m-d H:m:s", STRTOTIME(date('h:i:sa')));
$online = "UPDATE user_online SET date_close = '$date_close' , status = 2 WHERE idOnline = '$lastId'";
$connect->query($online);
session_unset(); 

// destroy the session 
session_destroy(); 

header('location: http://localhost/stock/index.php');

?>