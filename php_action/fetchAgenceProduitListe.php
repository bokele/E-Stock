

<?php 	
if ($_POST) {

	$id_agence_arriveTotal = $_POST["id_agence_arriveTotal"];


require_once 'core.php';

$rateSql = "SELECT agence,id_agence FROM agence where id_agence= $id_agence_arriveTotal";
	$query = $connect->query($rateSql);
	while ($rateResult = $query->fetch_assoc()) {

$sql = "SELECT product.product_id, product.product_name, product.rate,prix_total_achat, prix_total_vente, benefice_total, quantity_total_agence, quantite, product.prix_achat, product.benefice, product.produit_pieceCarton, product.produit_tva FROM product 
 
		INNER JOIN produit_agence ON product.product_id = produit_agence.product_id  
		WHERE product.status = 1 AND produit_agence.id_agence_arrive = ".$rateResult["id_agence"]." ORDER BY product_id DESC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

 while($row = $result->fetch_assoc()) {
 	$productId = $row["product_id"];

	$beneficie ="";
	if($_SESSION["userRole"] == 1 || $_SESSION["userRole"] == 5) {
		$beneficie = $row["benefice_total"];
	}else{
		$beneficie = "";
	}


 	$output['data'][] = array( 		
 		// image
 		//$productImage,
 		// product name
 		$row["product_name"],
 		
 		//PA
 		$row["quantite"], 
 		// rate
 		$row["quantity_total_agence"],
 		// rate
 		$row["prix_total_achat"],
 		// rate
 		$row["prix_total_vente"],
 		//beneficie
 		$beneficie,
 				
 		); 	
 } // /while 

}// if num_rows

}

$connect->close();

echo json_encode($output);

}