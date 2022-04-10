<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());



if($_POST) {	

	$nom_banque = mysqli_real_escape_string($connect,$_POST['nom_banque']);
		$user_add_banque 		= $_SESSION['userId'];
	  	$date_add_banque 			= date("Y-m-d H:m:s"); 

  $sql = "SELECT * FROM brands WHERE brand_name = '$nom_banque'";
  $ligne = $connect->query($sql);

  $ligneback = $ligne->num_rows;

  if ( $ligneback == 0) {
  	$sql = "INSERT INTO banque (nom_banque, banque_status, user_add_banque, date_add_banque) VALUES ('$nom_banque', 1,$user_add_banque, '$date_add_banque')";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "La Banque a été ajouter";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}

	$connect->close();
  }else{
  		$valid['success'] = false;
	 	$valid['messages'] = "Cette Banque existe déjà";
  }


	

	echo json_encode($valid);
 
} // /if $_POST