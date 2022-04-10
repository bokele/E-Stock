<?php 	



require_once 'core.php';

if ($_POST) {
	
	$produitAgence_id = $_POST["produitAgence_id"];

	$sql = "SELECT produitAgence_id, product.product_name, product.produit_tva, product.produit_pieceCarton, prix_vente, quantite, quantity_total_agence, prix_total_vente, produit_agence.benefice_total, brand_name, categories_name, status, produit_agence.id_agence, agence ,quantity_total_agence,id_agence_arrive, rateTva
		FROM produit_agence 
		INNER JOIN product ON product.product_id = produit_agence.product_id 
		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id
		INNER JOIN agence ON agence.id_agence = produit_agence.id_agence  
		
 	WHERE  produit_agence.produitAgence_id = $produitAgence_id";

 	$result = $connect->query($sql);
 	$row ="";
 	if($result->num_rows > 0) { 
 		$row = $result->fetch_array();
 		$id_agence_arrive = $row["id_agence_arrive"];
 		$agenceArrive = "SELECT  agence AS nom_agence
		FROM agence 
		WHERE id_agence = $id_agence_arrive ";
		$resultAgence = $connect->query($agenceArrive);
	 	$rowAgence = $resultAgence->fetch_array();

	 	$row +=$rowAgence;
	} // if num_rows

	$connect->close();

	echo json_encode($row);


	

}

?>