<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$id_sous_compte = $_POST['id_sous_compte'];

if($id_sous_compte) { 

	 $sql = "UPDATE comptabilite_sous_compte SET status = 2 WHERE id_sous_compte = {$id_sous_compte}";


 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Le sous compte a été supprime avec successe";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Erreur de la suppression des nformations du sous compte";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST