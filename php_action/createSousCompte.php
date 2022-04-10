<?php 	
date_default_timezone_set('Africa/Bujumbura');
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());


	if($_POST) {	
		

		$libelle_sous_compte 	= ucfirst(mysqli_real_escape_string($connect,$_POST['libelle_sous_compte']));
		$id_compte_principal 	= $_POST['id_Compte'];
		$code_sous_compte 		= $_POST['code_sous_compte'];
	  	
	  	$user_add 			= $_SESSION['userId'];
	  	$date_add 			= date("Y-m-d H:m:s"); 

		$sqlSelect = "SELECT * FROM comptabilite_sous_compte WHERE libelle_sous_compte = '$libelle_sous_compte' OR code_sous_compte = '$code_sous_compte'";
		$sqlResult = $connect->query($sqlSelect);
		$result = $sqlResult->num_rows;
		//echo mysqli_error($connect);
	if ($result ==  0 ) {

		


  		$sql = "INSERT INTO comptabilite_sous_compte (id_compte_principal, code_sous_compte, libelle_sous_compte, status , user_add, date_add)

		VALUES ($id_compte_principal, $code_sous_compte, '$libelle_sous_compte', 1, $user_add, '$date_add')";
				
		if($connect->query($sql) === TRUE) {
	 		$valid['success'] = true;
			$valid['messages'] = "Le sous compte est  crée avec success";	
		}
		else {
		 	$valid['success'] = false;
		 	$valid['messages'] = "Erreur lors de l'enregistrement ".mysqli_error($connect);
		}
		  	  	
		$connect->close();

			
	}else{
		$valid['success'] = false;
		$valid['messages'] = "Ce sous compte existe déjà";
	}
	
}// /if $_POST
echo json_encode($valid);