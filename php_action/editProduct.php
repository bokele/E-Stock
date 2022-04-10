<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {
	$productId 			= $_POST['productId'];
	$productName 		= mysqli_real_escape_string($connect,$_POST['editProductName']); 
	//$quantityEnc 		= $_POST['quantityEnc'];
  	//$quantity 			= $_POST['editQuantity'];
  	$rate 				= $_POST['editRate'];
  	$brandName 			= $_POST['editBrandName'];
  	$categoryName 		= $_POST['editCategoryName'];
  	$productStatus 		= $_POST['editProductStatus'];
  	$pieceCarton 		= $_POST['editpieceCarton'];
  	$produit_tva 		= $_POST['editProduit_tva'];

  	$prix_achat 		= $_POST['editprix_achat'];
  	
  	$date_add = date("Y-m-d H:m:s");

  	if( $produit_tva == 1){
		$rateTva =  ($rate *18)/100;
		$rateTotal = $rateTva + $rate;
		$benefice  = $rateTotal-$prix_achat;
	}else{
		$rateTva = 0;
		$benefice  = $rate-$prix_achat;
	}
				
	$sql = "UPDATE product SET
	 	product_name 		= '$productName',
	 	produit_pieceCarton =  $pieceCarton, 
	 	brand_id 			= '$brandName', 
	 	categories_id 		= '$categoryName', 
	 	rate 				= '$rate', 
	 	rateTva				= $rateTva,
	 	prix_achat 			= '$prix_achat', 
	 	benefice 			= '$benefice', 
	 	produit_tva 		=  $produit_tva,
	  	active 				= '$productStatus', 
	  	status 				= 1, 
	  	date_add 			= '$date_add'
	  WHERE product_id = $productId ";

	if($connect->query($sql) === TRUE) {

		$productId = $productId;
		$valid['success'] = true;
		$valid['messages'] = "Le mise a jour du produit se termine avec success";	

	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while updating product info";
	}

} // /$_POST
	 
$connect->close();

echo json_encode($valid);
 
