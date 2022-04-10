<?php 
require_once 'core.php';
$valid['success'] = array('success' => false, 'messages' => array());
date_default_timezone_set('Africa/Bujumbura');
if($_POST) {	

		$libelle_sous_compte 			= ucfirst(mysqli_real_escape_string($connect,$_POST['libelle_sous_compteEdit']));
		$id_compte_principal 			= $_POST['id_CompteEdit'];
		$id_sous_compte 				= $_POST['id_compte_sousEdit'];
		$code_sous_compte 				= $_POST['code_sous_compteEdit'];
		
	  	
	  	$id_user_edit 			= $_SESSION['userId'];
	  	$date_edit 			= date("Y-m-d H:m:s");  





	  		$sql = "UPDATE  comptabilite_sous_compte SET 
	  				id_compte_principal 	= '$id_compte_principal',
	  				code_sous_compte 		= '$code_sous_compte',
	  				libelle_sous_compte 	= '$libelle_sous_compte',
	  		   		id_user_edit 			= $id_user_edit, 
	  		   		date_edit 				= '$date_edit'

	  		   		WHERE id_sous_compte	 = '$id_sous_compte'

	  		   	";	
			
			
			if($connect->query($sql) === TRUE) {
		 		$valid['success'] = true;
				$valid['messages'] = "le sous classe a été modifie avec successe";	
			}
			else {
			 	$valid['success'] = false;
			 	$valid['messages'] = "Erreur lors de modification du sous classe ".mysqli_error($connect);
			}

		
	} // /if $_POST
	$connect->close();
	echo json_encode($valid);
	?>