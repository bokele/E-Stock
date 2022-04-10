<?php 	

require_once 'core.php';

$product_id = $_POST['product_id'];

$row ="";
$sql = "SELECT 	productStock_id, product_stock.product_id, quantity_total, product_name, product_stock.date_add  FROM product_stock INNER JOIN product ON product_stock.product_id = product.product_id  WHERE product_stock.product_id = {$product_id}";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>