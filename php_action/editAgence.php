<?php 
require_once 'core.php';
$valid['success'] = array('success' => false, 'messages' => array());
date_default_timezone_set('Africa/Bujumbura');
if($_POST) {	

		$agence 			= mysqli_real_escape_string($connect,$_POST['agenceEdit']);
	  	$tele_agence 		= $_POST['tele_agenceEdit'];
	  	$province_agence 	= $_POST['province_agencEdite']; 
	  	$commune_agence 	= $_POST['commune_agenceEdit'];
	  	$quartier_agence 	= $_POST['quartier_agenceEdit']; 
	  	$avenue_agence 		= $_POST['avenue_agenceEdit']; 
	  	$numero_agence 		= $_POST['numero_agenceEdit']; 
	  	$resp_agence 		= $_POST['resp_aganceEdit']; 
	  	$tele_resp_agence 	= $_POST['tele_resp_agenceEdit']; 
	  	$id_agence 			= $_POST['agenceIdEdit'];

	  	$id_user_edit_agence 		= $_SESSION['userId'];
	  	$date_edit_agence 			= date("Y-m-d H:m:s"); 





	  		$sql = "UPDATE  agence SET 
	  				agence 				= '$agence',
	  		 		tele_agence 		= '$tele_agence', 
	  		 		province_agence 	= '$province_agence', 
	  		 		commune_agence 		= '$commune_agence',
	  		  		quartier_agence 	= '$quartier_agence', 
	  		  		avenue_agence 		= '$avenue_agence', 
	  		  		numero_agence 		= '$numero_agence', 
	  		  		resp_agence 		= '$resp_agence', 
	  		  		tele_resp_agence 	= '$tele_resp_agence',
	  		   		id_user_edit_agence = $id_user_edit_agence, 
	  		   		date_edit_agence 	= '$date_edit_agence'

	  		   		WHERE id_agence	='$id_agence'

	  		   	";	
			
			
			if($connect->query($sql) === TRUE) {
		 		$valid['success'] = true;
				$valid['messages'] = "les informations de l'agence  onte été modifie avec successe";	
			}
			else {
			 	$valid['success'] = false;
			 	$valid['messages'] = "Erreur de modification des formations de l'agence";
			}
	  	  	
		$connect->close();

		
	} // /if $_POST
	echo json_encode($valid);
	?>