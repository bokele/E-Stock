<?php 	

require_once 'core.php';

$productId = $_POST['productId'];

$sql = "SELECT  product.product_id, product.product_name, product.product_image, product.brand_id,
 		product.categories_id, product.rate,  product.active, product.status, 
 		brands.brand_name, categories.categories_name, product.prix_achat, product.benefice, product.produit_pieceCarton, product.produit_tva FROM product
 		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id  
 		 WHERE product_id = $productId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);
