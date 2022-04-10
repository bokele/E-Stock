<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());



if($_POST) {	

	$brandName = mysqli_real_escape_string($connect,$_POST['brandName']);
  $brandStatus = $_POST['brandStatus']; 

  $sql = "SELECT * FROM brands WHERE brand_name = '$brandName'";
  $ligne = $connect->query($sql);

  $ligneback = $ligne->num_rows;

  if ( $ligneback == 0) {
  	$sql = "INSERT INTO brands (brand_name, brand_active, brand_status) VALUES ('$brandName', '$brandStatus', 1)";

	if($connect->query($sql) === TRUE) {
	 	$valid['success'] = true;
		$valid['messages'] = "Successfully Added";	
	} else {
	 	$valid['success'] = false;
	 	$valid['messages'] = "Error while adding the members";
	}

	$connect->close();
  }else{
  		$valid['success'] = false;
	 	$valid['messages'] = "Cette Marque existe déjà";
  }


	

	echo json_encode($valid);
 
} // /if $_POST