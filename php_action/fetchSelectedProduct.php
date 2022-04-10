<?php 	

require_once 'core.php';
 $row ="";
if ($_POST['productId']) {
	$productId = $_POST['productId'];

$sql = "SELECT product_id, product_name, produit_pieceCarton, prix_achat, product_image, brand_id, categories_id, rate, produit_tva, active, status FROM product WHERE product_id = {$productId}  ORDER BY product_name";
$result = $connect->query($sql);

	if($result->num_rows > 0) { 
	 $row = $result->fetch_array();
	 $connect->close();

	echo json_encode($row);
	}else{
		echo json_encode(mysqli_error($connect));
	} // if num_rows

	
}else{
	echo json_encode();
}



?>