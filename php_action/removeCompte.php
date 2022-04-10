<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$id_compte = $_POST['id_compte'];

if($id_compte) { 

	 $sql = "UPDATE comptabilite_compte_principal SET status = 2 WHERE id_compte_principal = {$id_compte}";


 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Le compte a été supprime avec successe";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Erreur de la suppression des nformations de la classe";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST