<?php 	
date_default_timezone_set('Africa/Bujumbura');
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());


	if($_POST) {	
		

		$libelle_classe 	= mysqli_real_escape_string($connect,$_POST['libelle_classe']);
	  	
	  	$user_add 			= $_SESSION['userId'];
	  	$date_add 			= date("Y-m-d H:m:s"); 

		$sqlSelect = "SELECT * FROM comptabilite_classe_compte WHERE libelle_classe = '$libelle_classe'";
		$sqlResult = $connect->query($sqlSelect);
		$result = $sqlResult->num_rows;
	if ($result ==  0 ) {

		


  		$sql = "INSERT INTO comptabilite_classe_compte (libelle_classe, status , user_add, date_add)

		VALUES ('$libelle_classe', 1, $user_add, '$date_add')";
				
		if($connect->query($sql) === TRUE) {
	 		$valid['success'] = true;
			$valid['messages'] = "La classe est  crée avec success";	
		}
		else {
		 	$valid['success'] = false;
		 	$valid['messages'] = "Erreur lors de l'enregistrement ".mysqli_error($connect);
		}
		  	  	
		$connect->close();

			
	}else{
		$valid['success'] = false;
		$valid['messages'] = "Cette classe existe déjà".mysqli_error($connect);
	}
	
}// /if $_POST
echo json_encode($valid);