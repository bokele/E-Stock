<?php 	



require_once 'core.php';

if ($_POST) {

	$id_agence_arriveTotal = $_POST["id_agence_arriveTotal"];
	$rateResult ="";
	$rateSql = "SELECT agence,id_agence FROM agence where id_agence= $id_agence_arriveTotal";
	$query = $connect->query($rateSql);
	while ($rateResult = $query->fetch_assoc()) {
		$sql = "SELECT sum(prix_total_vente) as prix_total_vente , sum(benefice_total) as benefice_total FROM produit_agence WHERE id_agence_arrive = ". $rateResult["id_agence"]."";
		$rateQuery = $connect->query($sql);
		while ($result = $rateQuery->fetch_assoc()) {
		

			$prix_total_vente = number_format($result['prix_total_vente'],2);
			$benefice_total ="";
			if($_SESSION["userRole"] == 1 || $_SESSION["userRole"] == 5) {
				$benefice_total	  = number_format($result['benefice_total'],2);
			}else{
				$benefice_total ="";
			}
			$output['data'][] = array( 
		 		// Agence
	 		$rateResult["agence"],		
	 		// prix_total_vente name
	 		$prix_total_vente,
	 		//$benefice_total	
	 		$benefice_total	
		);
	}

	 	
}


}else{
		$rateResult ="";
	$rateSql = "SELECT agence,id_agence FROM agence";
	$query = $connect->query($rateSql);
	while ($rateResult = $query->fetch_assoc()) {
		$sql = "SELECT sum(prix_total_vente) as prix_total_vente , sum(benefice_total) as benefice_total FROM produit_agence  WHERE id_agence_arrive = ". $rateResult["id_agence"]."";
		$rateQuery = $connect->query($sql);
		while ($result = $rateQuery->fetch_assoc()) {
		

			$prix_total_vente = number_format($result['prix_total_vente'],2);
			if($_SESSION["userRole"] == 1 || $_SESSION["userRole"] == 5) { 
				$benefice_total	  = number_format($result['benefice_total'],2);
			}else{
				$benefice_total	  = "";
			}

			$output['data'][] = array( 
		 		// Agence
	 		$rateResult["agence"],		
	 		// prix_total_vente name
	 		$prix_total_vente,
	 		//$benefice_total	
	 		$benefice_total	
		);
	}

	 	
}
}
$connect->close();

echo json_encode($output);


