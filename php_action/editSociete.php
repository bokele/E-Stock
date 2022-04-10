<?php 
require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
if($_POST) {	

		$nom_societe 		= mysqli_real_escape_string($connect,$_POST['nom_societeEdit']);
	  	$siegle_societe 	= mysqli_real_escape_string($connect,$_POST['siegle_societeEdit']);
	  	$tele_societe 		= $_POST['tele_societEdite']; 
	  	$tele_societeSecond = $_POST['tele_societeSecondEdit'];
	  	$bp 				= $_POST['bpEdit']; 
	  	$pays 				= mysqli_real_escape_string($connect,$_POST['paysEdit']); 
	  	$province 			= mysqli_real_escape_string($connect,$_POST['provinceEdit']); 
	  	$commune_societe 	= mysqli_real_escape_string($connect,$_POST['commune_societeEdit']); 
	  	$quartier 			= mysqli_real_escape_string($connect,$_POST['quartierEdit']); 
	  	$avenue 			= mysqli_real_escape_string($connect,$_POST['avenueEdit']); 
	  	$numero 			= mysqli_real_escape_string($connect,$_POST['numeroEdit']); 
	  	$email_societe 		= $_POST['email_societeEdit'];
	  	$assujetti_tva 		= $_POST['assujetti_tvaEdit'];
	  	$NIF_societe 		= $_POST['NIF_societeEdit'];
	  	$Registre_commerce 	= $_POST['Registre_commerceEdit']; 
	  	$centre_fiscal 		= mysqli_real_escape_string($connect,$_POST['centre_fiscalEdit']); 
	  	$forme_juridique 	= mysqli_real_escape_string($connect,$_POST['forme_juridiqueEdit']); 
	  	$secteur_activite 	= mysqli_real_escape_string($connect,$_POST['secteur_activiteEdit']);
	  	$id_user_add 		= $_SESSION['userId'];
	  	$date_add 			= date("Y-m-d H:m:s"); 

	  	$societeId 	= $_POST['societeId'];


	  		$sql = "UPDATE  societe SET 
	  				nom_societe 		= '$nom_societe',
	  		 		siegle_societe 		= '$siegle_societe', 
	  		 		tele_societe 		= '$tele_societe', 
	  		 		tele_societeSecond 	= '$tele_societeSecond',
	  		  		postBP 				= '$bp', 
	  		  		pays 				= '$pays', 
	  		  		province 			= '$province', 
	  		  		commune_societe 	= '$commune_societe', 
	  		  		quartier 			= '$quartier',
	  		   		avenue 				= '$avenue', 
	  		   		numero 				= '$numero', 
	  		   		email_societe 		= '$email_societe', 
	  		   		assujetti_tva 		= $assujetti_tva, 
	  		   		NIF_societe 		= '$NIF_societe', 
	  		  		Registre_commerce 	= '$Registre_commerce', 
	  		   		centre_fiscal 		= '$centre_fiscal', 
	  		   		forme_juridique 	= '$forme_juridique', 
	  		   		secteur_activite 	= '$secteur_activite', 
	  		   		id_user_edit 		= $id_user_add, 
	  		   		date_edit 			= '$date_add'

	  		   		WHERE societe_id	=$societeId

	  		   	";	
			
			
			if($connect->query($sql) === TRUE) {
		 		$valid['success'] = true;
				$valid['messages'] = "Information de la société  modifie avec successe";	
			}
			else {
			 	$valid['success'] = false;
			 	$valid['messages'] = "Erreur d'enregistrement des nformations de la société";
			}
	  	  	
		$connect->close();

		
	} // /if $_POST
	echo json_encode($valid);
	?>