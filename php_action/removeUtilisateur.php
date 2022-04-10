<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$utilisateurId = $_POST['utilisateurId'];

if($utilisateurId) { 

 $sql = "DELETE FROM users WHERE user_id = '$utilisateurId'";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "L'utlisateur a été suppri,e qvec successe";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST