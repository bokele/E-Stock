<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());



if($_POST) {	

	$nif_client				= $_POST['nif_client'];
	$nom_client			 	= mysqli_real_escape_string($connect,$_POST['nom_client']);
	$prenom_client		 	= mysqli_real_escape_string($connect,$_POST['prenom_client']);
	$telephone_client 		= mysqli_real_escape_string($connect,$_POST['telephone_client']);
	$adresse_client 		= mysqli_real_escape_string($connect,$_POST['adresse_client']);
	$user_add_client	 	= $_SESSION['userId'];
	$date_add_client	 	= date("Y-m-d H:m:s"); 


  	$sql = "INSERT INTO client (nom_client, prenom_client, telephone_client, adresse_client, nif_client, user_add_client, date_add_client, status_client) 

  	VALUES ('$nom_client', '$prenom_client', '$telephone_client', '$adresse_client', '$nif_client',   $user_add_client, '$date_add_client', 1)";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Le client a été enregistre";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members ".mysqli_error($connect);
	}

	$connect->close();
 


	

	echo json_encode($valid);
 
} // /if $_POST