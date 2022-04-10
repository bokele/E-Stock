<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$id_classe = $_POST['id_classe'];

if($id_classe) { 

	 $sql = "UPDATE comptabilite_classe_compte SET status = 2 WHERE id = {$id_classe}";


 if($connect->query($sql) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "La classe a été supprime avec successe";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Erreur de la suppression des nformations de la classe";
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST