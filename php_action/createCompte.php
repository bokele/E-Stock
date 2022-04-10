<?php 	
date_default_timezone_set('Africa/Bujumbura');
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());


	if($_POST) {	
		

		$libelle_compte 	= ucfirst(mysqli_real_escape_string($connect,$_POST['libelle_compte']));
		$id_classe 			= $_POST['id_classe'];
		$code_compte 		= $_POST['code_compte'];
	  	
	  	$user_add 			= $_SESSION['userId'];
	  	$date_add 			= date("Y-m-d H:m:s"); 

		$sqlSelect = "SELECT * FROM comptabilite_compte_principal WHERE libelle_compte = '$libelle_compte' OR code_compte = '$code_compte'";
		$sqlResult = $connect->query($sqlSelect);
		$result = $sqlResult->num_rows;
		//echo mysqli_error($connect);
	if ($result ==  0 ) {

		


  		$sql = "INSERT INTO comptabilite_compte_principal (id_classe, code_compte, libelle_compte, status , user_add, date_add)

		VALUES ($id_classe, $code_compte, '$libelle_compte', 1, $user_add, '$date_add')";
				
		if($connect->query($sql) === TRUE) {
	 		$valid['success'] = true;
			$valid['messages'] = "Le compte est  crée avec success";	
		}
		else {
		 	$valid['success'] = false;
		 	$valid['messages'] = "Erreur lors de l'enregistrement ".mysqli_error($connect);
		}
		  	  	
		$connect->close();

			
	}else{
		$valid['success'] = false;
		$valid['messages'] = "Ce compte existe déjà";
	}
	
}// /if $_POST
echo json_encode($valid);