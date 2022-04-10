<?php 	



require_once 'core.php';

$sql = "SELECT product.product_id,productStock_id, product.product_name, quantity_total, prix_achat_total, rate_total, benefice_total FROM product_stock 
		INNER JOIN product ON product.product_id = product_stock.product_id  ORDER BY 	product_name ASC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$product_id = $row[0];
 	$productStock_id = $row[1];
 	// active 

 	$button = '<!-- Single button -->
	  <a type="button" data-toggle="modal" id="stockViewModalBtn" data-target="#stockModalView" onclick="viewStockProduct('.$product_id.')" class="btn btn-info btn-sm"> <i class="fa fa-eye"></i></a>

	    <a type="button" data-toggle="modal" id="editProductQuantiteModalBtn" data-target="#editStockModalView" onclick="editProductStock('.$product_id.')" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i></a>
    
	  ';

	
	$beneficie ="";
	if($_SESSION["userRole"] == 1 || $_SESSION["userRole"] == 5) {
		$beneficie = $row[6];
	}else{
		$beneficie = "";
	}

 	$output['data'][] = array( 		
 		//produit
 		$row[2],
 		//quantite
 		$row[3],
 		
 		//prix_achat_total
 		$row[4], 
 		// rate_total
 		$row[5],
 		//beneficie
 		$beneficie,

 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);