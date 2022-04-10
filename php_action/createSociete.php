<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

$sqlSelect = "SELECT * FROM societe";
$sqlResult = $connect->query($sql);

$result = $sqlResult->row_muns;

if ($result > 0 ) {
	if($_POST) {	

		$nom_societe 		= mysqli_real_escape_string($connect,$_POST['nom_societe']);
	  	$siegle_societe 	= $_POST['siegle_societe'];
	  	$tele_societe 		= $_POST['tele_societe']; 
	  	$tele_societeSecond = $_POST['tele_societeSecond'];
	  	$bp 				= $_POST['bp']; 
	  	$pays 				= $_POST['pays']; 
	  	$province 			= $_POST['province']; 
	  	$commune_societe 	= $_POST['commune_societe']; 
	  	$quartier 			= $_POST['quartier']; 
	  	$avenue 			= $_POST['avenue']; 
	  	$numero 			= $_POST['numero']; 
	  	$email_societe 		= $_POST['email_societe'];
	  	$assujetti_tva 		= $_POST['assujetti_tva'];
	  	$NIF_societe 		= $_POST['NIF_societe'];
	  	$Registre_commerce 	= $_POST['Registre_commerce']; 
	  	$centre_fiscal 		= $_POST['centre_fiscal']; 
	  	$forme_juridique 	= $_POST['forme_juridique']; 
	  	$secteur_activite 	= $_POST['secteur_activite'];
	  	$id_user_add 		= $_SESSION['userId'];
	  	$date_add 			= date("Y-m-d H:m:s"); 


	  		$sql = "INSERT INTO societe (nom_societe, siegle_societe, tele_societe, tele_societeSecond, postBP, pays, province, commune_societe, quartier, avenue, numero, email_societe, assujetti_tva, NIF_societe, Registre_commerce, centre_fiscal, forme_juridique, secteur_activite, id_user_add, date_add) 
			VALUES ('$nom_societe', '$siegle_societe', '$tele_societe', '$tele_societeSecond', '$bp', '$pays', '$province', '$commune_societe', '$quartier', '$avenue', '$numero', '$email_societe' ,$assujetti_tva,'$NIF_societe', '$Registre_commerce', '$centre_fiscal','$forme_juridique', '$secteur_activite' ,$id_user_add, '$date_add')";
			
			if($connect->query($sql) === TRUE) {
		 		$valid['success'] = true;
				$valid['messages'] = "Information de la société  crée avec successe";	
			}
			else {
			 	$valid['success'] = false;
			 	$valid['messages'] = "Erreur d'enregistrement des nformations de la société";
			}
	  	  	
		$connect->close();

		
	} // /if $_POST
}else{
	$valid['success'] = false;
	$valid['messages'] = "Vous pouvez juste modifie les nformations de la société";
}

echo json_encode($valid);

