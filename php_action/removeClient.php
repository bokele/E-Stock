<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$clientId = $_POST['clientId'];

if($clientId) { 

 $sql = "UPDATE client SET status_client = 2 WHERE 	id_client = {$clientId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Le client a été supprimer";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST