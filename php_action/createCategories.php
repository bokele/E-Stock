<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$categoriesName 	= mysqli_real_escape_string($connect,$_POST['categoriesName']);
  	$categoriesStatus 	= $_POST['categoriesStatus'];
  	$brandName 			= $_POST['brandName'];  

	$sql = "INSERT INTO categories (categories_name, categories_active, categories_status,idBrand) 
	VALUES ('$categoriesName', '$categoriesStatus', 1,$brandName)";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST