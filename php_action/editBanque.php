<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$editnom_banque = mysqli_real_escape_string($connect,$_POST['editnom_banque']);
  $banqueId = $_POST['banqueId'];

	$sql = "UPDATE banque SET nom_banque = '$editnom_banque' WHERE id_banque = '$banqueId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Le modification ont été enregistre";
			$connect->close();	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}
	echo json_encode($valid);
 
} // /if $_POST