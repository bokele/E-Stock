<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());



if($_POST) {	

	$id_banque 				= $_POST['id_banque'];
	$numero_compte_banque 	= mysqli_real_escape_string($connect,$_POST['numero_compte_banque']);
	$nom_personne_verse 	= mysqli_real_escape_string($connect,$_POST['nom_personne_verse']);
	$montant_verse 			= $_POST['montant_verse'];
	$date_bordereau 		= date('Y-m-d', strtotime($_POST['date_bordereau']));
	$numero_bordereau 		= mysqli_real_escape_string($connect,$_POST['numero_bordereau']);
	$type_versement 		= $_POST['type_versement'];
	$user_add_verserment 	= $_SESSION['userId'];
	$date_add_versement 	= date("Y-m-d H:m:s"); 


  	$sql = "INSERT INTO versement (id_banque, montant_verse, numero_compte_banque, nom_personne_verse, numero_bordereau, date_bordereau, type_versement, user_add_verserment, date_add_versement) 

  	VALUES ($id_banque, '$montant_verse', '$numero_compte_banque', '$nom_personne_verse', '$numero_bordereau', '$date_bordereau', $type_versement,  $user_add_verserment, '$date_add_versement')";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Le versement a été enregistre";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members ".mysqli_error($connect);
	}

	$connect->close();
 


	

	echo json_encode($valid);
 
} // /if $_POST