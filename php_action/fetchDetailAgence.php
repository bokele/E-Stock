<?php 	



require_once 'core.php';

/*if ($_POST) {
	

	if (!isset($_POST["id_agenceSeach"])) {

		$sql = "SELECT produitAgence_id, product.product_name, product.produit_tva, product.produit_pieceCarton, prix_vente, quantity_total_agence, prix_total_vente, produit_agence.benefice_total, brand_name, categories_name, status, produit_agence.id_agence, agence , id_agence_arrive
 		FROM produit_agence 
 		INNER JOIN product ON product.product_id = produit_agence.product_id 
		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id
		INNER JOIN agence ON agence.id_agence = produit_agence.id_agence   
	 	ORDER BY 	produitAgence_id DESC";

		$result = $connect->query($sql);

		$output = array('data' => array());

		if($result->num_rows > 0) { 

		 // $row = $result->fetch_array();
		 $active = ""; 

	 while($row = $result->fetch_array()) {
		 	$produitAgence_id = $row[0];

	 	$id_agence_arrive = $row["id_agence_arrive"];
 		$agenceArrive = "SELECT  agence AS nom_agence
		FROM agence 
		WHERE id_agence = $id_agence_arrive ";
		$resultAgence = $connect->query($agenceArrive);
	 	$rowAgence = $resultAgence->fetch_array();

			$beneficie ="";
			$button ="";
			$prix_total_vente ="";
		
			$beneficie = $row[7];
			$prix_total_vente =$row[6];

			$button = '<!-- Single button -->
		
		   <a type="button" data-toggle="modal" id="editAgenceProductModalBtn" data-target="#viewAgenceProductModal"  onclick="viewAgeenceProduct('.$produitAgence_id.')" class="btn btn-info btn-sm"> <i class="fa fa-eye" ></i></a>';
		

	

		 	$output['data'][] = array(
		 		// Agence depart
		 		$row[12],
		 		// Agence arrive
		 	$rowAgence ["nom_agence"], 
		 				
		 		// product name
		 		$row[1],
		 		//quantite
		 		$row[5],
		 		// prix_vente
		 		$row[4],
		 		// prix_total_vente
		 		 $prix_total_vente,		 	
		 		// benefice_total
		 		$beneficie,
		 		// button
		 		$button 		
		 		); 	
	 	} // /while 

	}// if num_rows

}


else if(isset($_POST["id_agenceSeach"])){*/

		//$id_agenceSeach = $_POST["id_agenceSeach"];
/*$sql = "SELECT produitAgence_id, product.product_name, product.produit_tva, product.produit_pieceCarton, prix_vente, quantite, prix_total_vente, benefice_total, brand_name, categories_name, status, produit_agence.id_agence, agence 
 	FROM produit_agence 
 	INNER JOIN product ON product.product_id = produit_agence.product_id 
	INNER JOIN brands ON product.brand_id = brands.brand_id 
	INNER JOIN categories ON product.categories_id = categories.categories_id
	INNER JOIN agence ON agence.id_agence = produit_agence.id_agence  
	ORDER BY 	produitAgence_id DESC";

$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $active = ""; 

		 while($row = $result->fetch_array()) {
		 	$produitAgence_id = $row[0];
		 	
			$beneficie ="";
			$button ="";
			$prix_total_vente ="";
		
				$beneficie = $row[6];
				$prix_total_vente =$row[7];

				$button = '<!-- Single button -->
			
			   <a type="button" data-toggle="modal" id="editAgenceProductModalBtn" data-target="#viewAgenceProductModal" onclick="viewAgeenceProduct('.$produitAgence_id.')" class="btn btn-info btn-sm"> <i class="fa fa-eye" ></i></a>
		     
		  ';
			

		
			

		 	$output['data'][] = array( 
			
		 		// Agence
		 		$row[12],	
		 		// Agence
		 		$row[12],		
		 		// product name
		 		$row[1]." - ".$row[3],
		 		//produit_pieceCarton
		 		$row[3], 
		 		//quantite
		 		$row[5],
		 		// prix_vente
		 		$row[4],
		 		
		 		// prix_total_vente
		 		 $prix_total_vente,		 	
		 		// benefice_total
		 		$beneficie,
		 		// category 		
		 		$row[9],
		 		// button
		 		$button 
				
		 		); 	
		 } // /while 

		}// if num_rows*/
		
	$sql = "SELECT produitAgence_id, product.product_name, product.produit_tva, product.produit_pieceCarton, prix_vente, quantity_total_agence, prix_total_vente, produit_agence.benefice_total, brand_name, categories_name, status, produit_agence.id_agence, agence , id_agence_arrive, rateTva, quantite 
 		FROM produit_agence 
 		INNER JOIN product ON product.product_id = produit_agence.product_id 
		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id
		INNER JOIN agence ON agence.id_agence = produit_agence.id_agence   
	 	ORDER BY 	produitAgence_id DESC";

		$result = $connect->query($sql);

		$output = array('data' => array());

		if($result->num_rows > 0) { 

		 // $row = $result->fetch_array();
		 $active = ""; 

	 while($row = $result->fetch_array()) {
		 	$produitAgence_id = $row[0];

	 	$id_agence_arrive = $row["id_agence_arrive"];
 		$agenceArrive = "SELECT  agence AS nom_agence
		FROM agence 
		WHERE id_agence = $id_agence_arrive ";
		$resultAgence = $connect->query($agenceArrive);
	 	$rowAgence = $resultAgence->fetch_array();

			$beneficie ="";
			$button ="";
			$prix_total_vente ="";
		if ($_SESSION["userRole"] == 1 || $_SESSION["userRole"] == 5) {
			$beneficie = $row[7];
		}else{
			$beneficie ="";
		}
			
			$prix_total_vente =$row[6];

			$button = '<!-- Single button -->
		
		   <a type="button" data-toggle="modal" id="editAgenceProductModalBtn" data-target="#viewAgenceProductModal"  onclick="viewAgeenceProduct('.$produitAgence_id.')" class="btn btn-info btn-sm"> <i class="fa fa-eye" ></i></a>';
		

	

		 	$output['data'][] = array(
		 		// Agence depart
		 		$row[12],
		 		// Agence arrive
		 	$rowAgence ["nom_agence"], 
		 				
		 		// product name
		 		$row[1],
		 		//quantite
		 		$row["quantite"],
		 		// prix_vente
		 		$row[4] + $row["rateTva"],
		 		// prix_total_vente
		 		 $prix_total_vente,		 	
		 		// benefice_total
		 		$beneficie,
		 		// button
		 		$button 		
		 		); 	
	 	} // /while 

	}// if num_rows
	$connect->close();
	echo json_encode($output);

	
/*}*/

