<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

	$quantiteNew 		= $_POST['quantiteNew'];
	$quantiteStockValue = $_POST['quantiteStockValue']; 
  	$product_idStock 	= $_POST['product_idStock']; 
  	$dateValue 	= $_POST['dateValue']; 

  	$rate = 0;
	$prix_achat = 0;
	$id_user 			= $_SESSION['userId'];
	$date_add = date("Y-m-d H:m:s");



  	$sqlproduit ="SELECT rate, prix_achat FROM product WHERE product_id=$product_idStock ";
  	$result = $connect->query($sqlproduit);
  	if($result->num_rows > 0) { 
		$row = $result->fetch_array();
		$rate = $row["0"];
		$prix_achat = $row["1"];
		



		$quantity_total		= $quantiteNew + $quantiteStockValue;
		$prix_achat_total	= $quantity_total * $prix_achat;
		$rate_total		 	= $quantity_total * $rate;
		$benefice_total 	= $rate_total - $prix_achat_total;


		$sql = "UPDATE product_stock SET 	
			quantity_total 		= '$quantity_total', 
			prix_achat_total 	= '$prix_achat_total', 
			rate_total 			= '$rate_total',
			benefice_total		= '$benefice_total',
			id_user 			= $id_user, 
			date_add 			= '$date_add'

		WHERE product_id = '$product_idStock'";

		if($connect->query($sql) === TRUE) {
		 	$valid['success'] = true;
			$valid['messages'] = "Le stock a été mise a jour";

			$sql = "INSERT INTO produit_history (product_id, date_add, prix_achat, prix_vente, pass_quantite, new_quantite, id_user) 
				VALUES ($product_idStock, '$dateValue', $prix_achat,  $rate , $quantiteStockValue, $quantiteNew, $id_user)";
			$connect->query($sql);

			$ageceArrive = "SELECT id_agence_arrive,id_agence,produitAgence_id,quantite,prix_vente,product_id,quantity_total_agence,prix_achat_agence, prix_total_vente, prix_total_achat, benefice_total, id_user, date_add FROM produit_agence WHERE id_agence_arrive = 1 AND product_id = $product_idStock";
			$result = $connect->query($ageceArrive);

			$row = $result->fetch_array();
			$produitAgence_id = $row["produitAgence_id"];
			$quantiteEncien = $row["quantity_total_agence"];

		##########  creation du history du produit dans une agence pour  facilite des rapport
		  	$id_agence 				= $row['id_agence'];
		 	$id_agence_arrive 		= $row['id_agence_arrive'];
		  	$product_id 			= $row['product_id'];
		  	$quantite 				= $row['quantite'];
		  	$quantity_total_agence 	= $row['quantity_total_agence'];
		  	$prix_vente 			= $row['prix_vente'];
		  	$prix_achat_agence		= $row['prix_achat_agence'];
		  	$prix_total_vente 		= $row['prix_total_vente'];
		  	$prix_total_achat 		= $row['prix_total_achat'];
		  	$benefice_total 		= $row['benefice_total'];
		  	$id_user 				= $row['id_user'];
		  	$date_add 				= $row['date_add'];
		  	$id_user_edit 			= $id_user; 
			$date_edit 				= '$date_add';

			$sql_history = "INSERT INTO produit_history_agence (produitAgence_id,id_agence,id_agence_arrive, product_id, quantity_total_agence, quantite, prix_vente, prix_achat_agence, prix_total_vente, prix_total_achat, benefice_total, id_user, date_add, id_user_edit,date_edit )
						VALUES ($produitAgence_id, $id_agence, $id_agence_arrive, $product_id, $quantite, $quantite, $prix_vente, $prix_achat_agence, $prix_total_vente, $prix_total_achat, $benefice_total, $id_user, '$date_add', $id_user_edit, '$date_edit' )";

				$connect->query($sql_history);

			// le meme produit dans les agence	
				$ageceArrive = "SELECT quantity_total_agence  FROM produit_agence WHERE id_agence_arrive = 1 AND product_id = $product_idStock";
			$result = $connect->query($ageceArrive);
			$row = $result->fetch_array();
			$quantiteEncien = $row["quantity_total_agence"];

			$quantity_total		= $quantiteNew + $quantiteEncien;
			$prix_achat_total	= $quantity_total * $prix_achat;
			$rate_total		 	= $quantity_total * $rate;
			$benefice_total 	= $rate_total - $prix_achat_total;

			$sql = "UPDATE produit_agence SET 	
			quantity_total_agence 	= '$quantity_total', 
			quantite 				= '$quantity_total', 
			prix_vente 				= '$rate',
			prix_achat_agence		= '$prix_achat',
			prix_total_vente 		= '$rate_total', 
			prix_total_achat 		= '$prix_achat_total',
			benefice_total			= '$benefice_total'

		WHERE product_id = '$product_idStock' AND id_agence_arrive=1";

		$connect->query($sql);

		} else {
		 	$valid['success'] = false;
		 	$valid['messages'] = "Error while adding the members ".mysqli_error($connect);
		}
		 
		
	} else{
		$valid['success'] = false;
		$valid['messages'] = "Error while adding the members ".mysqli_error($connect);
	}

	$connect->close();

		echo json_encode($valid);
  	
 
} // /if $_POST