<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$nif_client				= $_POST['nif_clientEdit'];
	$nom_client			 	= mysqli_real_escape_string($connect,$_POST['nom_clientEdit']);
	$prenom_client		 	= mysqli_real_escape_string($connect,$_POST['prenom_clientEdit']);
	$telephone_client 		= mysqli_real_escape_string($connect,$_POST['telephone_clientEdit']);
	$adresse_client 		= mysqli_real_escape_string($connect,$_POST['adresse_clientEdit']);
	$user_add_client	 	= $_SESSION['userId'];
	$date_add_client	 	= date("Y-m-d H:m:s"); 
  	$clientId = $_POST['clientId'];

	$sql = "UPDATE client SET 
	nom_client = '$nom_client',
	prenom_client = '$prenom_client',
	telephone_client = '$telephone_client',
	adresse_client = '$adresse_client',
	nif_client = '$nif_client',
	user_add_client= '$user_add_client',
	date_add_client = '$date_add_client'

	 WHERE id_client = '$clientId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Le modification ont été enregistre";
			$connect->close();	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	echo json_encode($valid);
 
} // /if $_POST