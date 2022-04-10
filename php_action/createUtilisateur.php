<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$username 		= mysqli_real_escape_string($connect,$_POST['username']);
  	$email 			= $_POST['email'];
  	$id_agence 		= $_POST['id_agence'];
  	$telephone 		= $_POST['telephone']; 
  	$role 			= $_POST['role']; 
  	$status 		= $_POST['status'];
  	$password 		= md5("123");  

  	$selectSql = "SELECT * FROM users WHERE  username = '$username'";
  	$resquest  = $connect->query($selectSql);
  	if ($resquest->num_rows == 0) {
  		$sql = "INSERT INTO users (username, password, email, telephone, id_agence, role, status) 
		VALUES ('$username', '$password', '$email','$telephone', $id_agence, $role ,$status )";
		if($connect->query($sql) === TRUE) {
	 		$valid['success'] = true;
			$valid['messages'] = "Utlisateur crée avec successe";	
		}
		else {
		 	$valid['success'] = false;
		 	$valid['messages'] = "Error while adding the members";
		}
  	}else{
  		$valid['success'] = false;
		$valid['messages'] = "Cette Utlisateur existe déjà";
  	}
  	
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST