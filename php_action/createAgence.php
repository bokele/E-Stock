<?php 	
date_default_timezone_set('Africa/Bujumbura');
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());


	if($_POST) {	
		

		$agence 			= mysqli_real_escape_string($connect,$_POST['agence']);
	  	$tele_agence 		= $_POST['tele_agence'];
	  	$province_agence 	= $_POST['province_agence']; 
	  	$commune_agence 	= $_POST['commune_agence'];
	  	$quartier_agence 	= $_POST['quartier_agence']; 
	  	$avenue_agence 		= $_POST['avenue_agence']; 
	  	$numero_agence 		= $_POST['numero_agence']; 
	  	$resp_agence 		= $_POST['resp_agence']; 
	  	$tele_resp_agence 	= $_POST['tele_resp_agence']; 
	  	
	  	$id_user_add_agence 		= $_SESSION['userId'];
	  	$date_add_agence 			= date("Y-m-d H:m:s"); 

		$sqlSelect = "SELECT * FROM agence WHERE agence = '$agence'";
		$sqlResult = $connect->query($sqlSelect);
		$result = $sqlResult->num_rows;
	if ($result ==  0 ) {

		


  		$sql = "INSERT INTO agence (agence, tele_agence, province_agence, commune_agence, quartier_agence, avenue_agence, numero_agence, resp_agence, tele_resp_agence, id_user_add_agence, date_add_agence)

		VALUES ('$agence', '$tele_agence', '$province_agence', '$commune_agence', '$quartier_agence', '$avenue_agence', '$numero_agence', '$resp_agence', '$tele_resp_agence' ,$id_user_add_agence, '$date_add_agence')";
				
		if($connect->query($sql) === TRUE) {
	 		$valid['success'] = true;
			$valid['messages'] = "Information de l'agence  crée avec success";	
		}
		else {
		 	$valid['success'] = false;
		 	$valid['messages'] = "Erreur d'enregistrement des formations de l'agence";
		}
		  	  	
		$connect->close();

			
	}else{
		$valid['success'] = false;
		$valid['messages'] = "Cette agence existe déjà";
	}
	
}// /if $_POST
echo json_encode($valid);
