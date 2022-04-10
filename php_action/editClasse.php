<?php 
require_once 'core.php';
$valid['success'] = array('success' => false, 'messages' => array());
date_default_timezone_set('Africa/Bujumbura');
if($_POST) {	

		$libelle_classe = mysqli_real_escape_string($connect,$_POST['libelle_classeEdit']);
	  	$id 			= $_POST['id_classeEdit'];

	  	$id_user_edit		= $_SESSION['userId'];
	  	$date_edit			= date("Y-m-d H:m:s"); 





	  		$sql = "UPDATE  comptabilite_classe_compte SET 
	  				libelle_classe 	= '$libelle_classe',
	  		   		id_user_edit 	= $id_user_edit, 
	  		   		date_edit 		= '$date_edit'

	  		   		WHERE id ='$id'

	  		   	";	
			
			
			if($connect->query($sql) === TRUE) {
		 		$valid['success'] = true;
				$valid['messages'] = "la classe a été modifie avec successe";	
			}
			else {
			 	$valid['success'] = false;
			 	$valid['messages'] = "Erreur lors de modification de la classe ".mysqli_error($connect);
			}
	  	  	
		$connect->close();

		
	} // /if $_POST
	echo json_encode($valid);
	?>