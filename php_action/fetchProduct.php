<?php 	



require_once 'core.php';

$sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
 		product.categories_id, product.rate,  product.active, product.status, 
 		brands.brand_name, categories.categories_name, product.prix_achat, product.benefice, product.produit_pieceCarton, product.produit_tva, rateTva FROM product 
		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id  
		WHERE product.status = 1 ORDER BY 	product_id DESC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_array()) {
 	$productId = $row[0];
 	// active 
 	if($row[7] == 1) {
 		// activate member
 		$active = "<label class='label label-success'>Available</label>";
 	} else {
 		// deactivate member
 		$active = "<label class='label label-danger'>Not Available</label>";
 	} // /else
 	$tva ="";
 	if ($row[13] == 1) {
 		$tva = "<label class='label label-primary'>Oui</label>";
 	}else{
 		$tva = "<label class='label label-danger'>Non</label>";
 	}

 	$button = '<!-- Single button -->
	  <a type="button" data-toggle="modal" id="editProductModalBtn" data-target="#productModalView" onclick="viewProduct('.$productId.')" class="btn btn-info btn-sm"> <i class="fa fa-eye"></i></a>

	    <a type="button" data-toggle="modal" id="editProductModalBtn" data-target="#editProductModal" onclick="editProduct('.$productId.')" class="btn btn-warning btn-sm"> <i class="fa fa-edit"></i></a>
	      
	
	    <a type="button" data-toggle="modal" data-target="#removeProductModal" id="removeProductModalBtn" onclick="removeProduct('.$productId.')" class="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>      
	  ';

	// $brandId = $row[3];
	// $brandSql = "SELECT * FROM brands WHERE brand_id = $brandId";
	// $brandData = $connect->query($sql);
	// $brand = "";
	// while($row = $brandData->fetch_assoc()) {
	// 	$brand = $row['brand_name'];
	// }

	$brand = $row[8];
	$category = $row[9];

	$imageUrl = substr($row[2], 3);
	$beneficie ="";
	if($_SESSION["userRole"] == 1 || $_SESSION["userRole"] == 5) {
		$beneficie = $row[11];
	}else{
		$beneficie = "";
	}
	$productImage = "<img class='img-round' src='".$imageUrl."' style='height:30px; width:50px;'  />";

 	$output['data'][] = array( 		
 		// image
 		//$productImage,
 		// product name
 		$row[1],
 		//piece/carton
 		$row[12],
 		
 		//PA
 		$row[10], 
 		// rate
 		$row[5] + $row[14],
 		//beneficie
 		$beneficie,
 				 	
 		// brand
 		$brand,
 		// tva
 		$tva,
 		
 		// button
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);