<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$id_agence = $_POST['id_agence'];

if($id_agence) { 

 $sql = "DELETE FROM agence WHERE id_agence	=$id_agence";

 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "L'agence a été supprime avec successe";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Erreur de la suppression des nformations de l'agence";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST