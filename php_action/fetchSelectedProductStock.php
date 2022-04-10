<?php 	

require_once 'core.php';
 $row ="";
if ($_POST['productId']) {
	$productId = $_POST['productId'];

$sql = "SELECT productStock_id, product_stock.product_id, quantity_total, prix_achat_total, rate_total, benefice_total,  rate, produit_tva, 	product_name,produit_pieceCarton, product_image, prix_achat, benefice FROM product_stock INNER JOIN product ON product.product_id = product_stock.product_id  WHERE product_stock.product_id = {$productId}";
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