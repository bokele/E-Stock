<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$banqueId = $_POST['banqueId'];

if($banqueId) { 

 $sql = "UPDATE banque SET banque_status = 2 WHERE 	id_banque = {$banqueId}";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "La banque a été supprimer";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST