<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

  $productName 			= mysqli_real_escape_string($connect,$_POST['productName']);
  $pieceCarton 			= $_POST['pieceCarton'];
  $rate 				= $_POST['rate'];
  $prix_achat 			= $_POST['prix_achat'];
  $benefice 			=	$rate -  $prix_achat;
  $brandName 			= $_POST['brandName'];
  $categoryName 		= $_POST['categoryName'];
  $productStatus 		= $_POST['productStatus'];
  $produit_tva 			= $_POST['produit_tva'];
  $id_user 				= $_SESSION['userId'];
  $date_add 			= date("Y-m-d H:m:s");
  

  $SERVERFILEPATH = '../assests/images/stock/';
if (!file_exists($SERVERFILEPATH)) {
    mkdir($SERVERFILEPATH);
 }

	$type = explode('.', $_FILES['productImage']['name']);
	$type = $type[count($type)-1];		
	$url = $SERVERFILEPATH.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
		if(is_uploaded_file($_FILES['productImage']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['productImage']['tmp_name'], $url)) {
				if( $produit_tva == 1){
					$rateTva =  ($rate *18)/100;
					$rateTotal = $rateTva + $rate;
					$benefice  = $rateTotal-$prix_achat;
				}else{
					$rateTva = 0;
					$benefice  = $rate-$prix_achat;
				}
				
				$sql = "INSERT INTO product (product_name, produit_pieceCarton, product_image, brand_id, categories_id, rate, rateTva, prix_achat, benefice, produit_tva, active, status, id_user, date_add)VALUES ('$productName',  $pieceCarton, '$url', '$brandName', '$categoryName','$rate', $rateTva, '$prix_achat', '$benefice', $produit_tva,  '$productStatus', 1, $id_user, '$date_add')";

				if($connect->query($sql) === TRUE) {

					$valid['success'] = true;
					$valid['messages'] = "Le produit a éte bien à jouter";
				
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members".mysqli_error($connect);
				}
					


			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 		

	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST