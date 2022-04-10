<?php 	
date_default_timezone_set('Africa/Bujumbura');
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$editUsername = mysqli_real_escape_string($connect,$_POST['editUsername']);
  	$editEmail = $_POST['editEmail']; 
  	$editRole = $_POST['editRole'];
  	$editId_agence 	= $_POST['editId_agence'];
  	$editStatus = $_POST['editStatus'];
  	$editTelephone = $_POST['editTelephone']; 
  	$editUtilsateurId = $_POST['editUtilsateurId']; 
  	$editId_agence = $_POST['editId_agence']; 


  
  	$sql = "UPDATE users SET username = '$editUsername', email = '$editEmail' , id_agence=$editId_agence, telephone='$editTelephone', status=$editStatus, role=$editRole, id_agence=$editId_agence WHERE user_id = '$editUtilsateurId'";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Mise à jour termine avec success";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Erreur lors de mise a jour";
	}
  

	

	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST