<?php 
require_once 'core.php';
$valid['success'] = array('success' => false, 'messages' => array());
date_default_timezone_set('Africa/Bujumbura');
if($_POST) {	

		$libelle_compte 			= ucfirst(mysqli_real_escape_string($connect,$_POST['libelle_compteEdit']));
		$id_classe 					= $_POST['id_classeEdit'];
		$code_compte 				= $_POST['code_compteEdit'];
		$id_compte_principal 	= $_POST['id_compte_principalEdit'];
	  	
	  	$id_user_edit 			= $_SESSION['userId'];
	  	$date_edit 			= date("Y-m-d H:m:s");  





	  		$sql = "UPDATE  comptabilite_compte_principal SET 
	  				id_classe 		= '$id_classe',
	  				code_compte 	= '$code_compte',
	  				libelle_compte 	= '$libelle_compte',
	  		   		id_user_edit 	= $id_user_edit, 
	  		   		date_edit 		= '$date_edit'

	  		   		WHERE id_compte_principal = '$id_compte_principal'

	  		   	";	
			
			
			if($connect->query($sql) === TRUE) {
		 		$valid['success'] = true;
				$valid['messages'] = "la classe a été modifie avec successe";	
			}
			else {
			 	$valid['success'] = false;
			 	$valid['messages'] = "Erreur lors de modification de la classe ".mysqli_error($connect);
			}

		
	} // /if $_POST
	$connect->close();
	echo json_encode($valid);
	?>