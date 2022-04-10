<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {

	$product_id 			= $_POST['produitNom'];
  	$quantity 				= $_POST['quantity'];

  	$id_user 			= $_SESSION['userId'];
    $date_add = date("Y-m-d H:m:s");


  	$sql = "SELECT product_id FROM product_stock WHERE product_id = {$product_id}";
  		$result = $connect->query($sql);

  	if($result->num_rows == 0) { 
  		$sql = "SELECT rate, prix_achat, rateTva FROM product WHERE product_id = $product_id";
  		$result = $connect->query($sql);
		$row = $result->fetch_array();
		$rate			=	$row[0] + $row[2];
		$prix_achat		=	$row[1];
		$quantity_total = $quantity;

		$prix_achat_total	= $prix_achat * $quantity;
		$rate_total 		= $rate * $quantity;
		$benefice_total		= $rate_total - $prix_achat_total;

		$sql = "INSERT INTO product_stock (product_id, quantity_total, prix_achat_total, rate_total, benefice_total, id_user, date_add) 
			VALUES ($product_id, $quantity_total, '$prix_achat_total', '$rate_total', '$benefice_total', $id_user, '$date_add')";

		$stock_id;
		if($connect->query($sql) === TRUE) {
			$stock_id = $connect->insert_id;

			$sql = "INSERT INTO produit_history (product_id, date_add, prix_achat, prix_vente, pass_quantite, new_quantite, id_user) 
						VALUES ($product_id, '$date_add', $prix_achat,  $rate , 0, $quantity, $id_user)";
			$connect->query($sql);
			$valid['success'] = true;
			$valid['messages'] = "Ajoute avec success";
			agence($product_id,$quantity, $quantity_total, $rate,$prix_achat,$connect);
				
		} else {
			$valid['success'] = false;
			$valid['messages'] = "Error while adding the members ".mysqli_error($connect);
		}

	} else{
		$sql = "SELECT product_id,quantity_total FROM product_stock WHERE product_id = {$product_id}";
  		$result = $connect->query($sql);
  		$result = $connect->query($sql);
		$row = $result->fetch_array();
		$quantity_total = $row[1];



		$sql = "SELECT rate, prix_achat,rateTva FROM product WHERE product_id = $product_id";
  		$result = $connect->query($sql);
		$row = $result->fetch_array();
		$rate			=	$row[0]+ $row[2];
		$prix_achat		=	$row[1];

		$quantity_total_new = $quantity + $quantity_total;

		$prix_achat_total	= $prix_achat * $quantity_total_new;
		$rate_total 		= $rate * $quantity_total_new;
		$benefice_total		= $rate_total - $prix_achat_total;

		$sql ="UPDATE product_stock SET 
			quantity_total 		= $quantity_total_new, 
			prix_achat_total 	= $prix_achat_total,
			rate_total 			= $rate_total , 
			benefice_total 		= $benefice_total, 
			id_user 			= $id_user, 
			date_add 			= '$date_add'

			WHERE product_id 	= $product_id 
		";

		if($connect->query($sql) === TRUE) {
			$sql = "INSERT INTO produit_history (product_id, date_add, prix_achat, prix_vente, pass_quantite, new_quantite, id_user) 
				VALUES ($product_id, '$date_add', $prix_achat,  $rate , $quantity_total, $quantity, $id_user)";
			$connect->query($sql);

			$valid['success'] = true;
			$valid['messages'] = "Ajoute avec success";
			agence($product_id,$quantity, $quantity_total, $rate,$prix_achat,$connect);

		}else {
			$valid['success'] = false;
			$valid['messages'] = "Error while adding the members ".mysqli_error($connect);
		}
	}
  	
}else{
	echo "string";
}

echo json_encode($valid);


function agence($product_id =0, $quantity=0, $quantity_total=0, $rate=0, $prix_achat=0,$connect){
	$id_agence_arrive = $_SESSION["agenceId"];

	$id_agence 				= $id_agence_arrive;
	$product_id 			= $product_id;
	$quantite 				= $quantity;
	$quantity_total_agence 	= $quantity_total;
	$prix_vente 			= $rate;
	$prix_achat_agence 		= $prix_achat;
	$prix_total_vente 		= $prix_vente  *   $quantite ; // prix total de vente pour la primeire foi
	$prix_total_achat		= $prix_achat_agence *  $quantite;  // prix achat total du la primier foi
	$benefice_total 		= $prix_total_vente - $prix_total_achat; // benificie total du stock pour la primier foi
	 
	$id_user 				= $_SESSION['userId'];
	$date_add 				= date("Y-m-d H:m:s");


	$ageceArrive = "SELECT id_agence_arrive,id_agence,produitAgence_id,quantite,prix_vente,product_id,quantity_total_agence,prix_vente,prix_total_vente,benefice_total, id_user, date_add FROM produit_agence WHERE id_agence_arrive = $id_agence_arrive AND product_id = $product_id";
	$result = $connect->query($ageceArrive);
	if ($result->num_rows ==  0) {



	$sql = "INSERT INTO produit_agence (id_agence,id_agence_arrive, product_id, quantity_total_agence, quantite, prix_vente, prix_achat_agence, prix_total_vente, prix_total_achat, benefice_total, id_user, date_add)
				VALUES ($id_agence, $id_agence_arrive, $product_id, $quantity_total_agence, $quantite, $prix_vente, $prix_achat_agence, $prix_total_vente, $prix_total_achat,  $benefice_total, $id_user, '$date_add')";
				$produitAgence_id;
				if($connect->query($sql) === TRUE) {
					$produitAgence_id = $connect->insert_id;

					$sql_history = "INSERT INTO produit_history_agence (produitAgence_id,id_agence,id_agence_arrive, product_id, quantity_total_agence, quantite, prix_vente, prix_achat_agence, prix_total_vente, prix_total_achat,  benefice_total, id_user, date_add)
				VALUES ($produitAgence_id, $id_agence, $id_agence_arrive, $product_id, $quantity_total_agence, $quantite, $prix_vente, $prix_achat_agence, $prix_total_vente, $prix_total_achat, $benefice_total, $id_user, '$date_add' )";

				$connect->query($sql_history);

					$valid['success'] = true;
					$valid['messages'] = "Le produit est bien transfert";	

				} else {
					$valid['success'] = false;
					$valid['messages'] = "Error while adding the members";
				}
}else{
	$ageceArrive = "SELECT id_agence_arrive,id_agence,produitAgence_id,quantite,prix_vente,product_id,quantity_total_agence,prix_achat_agence, prix_total_vente, prix_total_achat, benefice_total, id_user, date_add FROM produit_agence WHERE id_agence_arrive = $id_agence_arrive AND product_id = $product_id";
	$result = $connect->query($ageceArrive);

	$row = $result->fetch_array();
	$produitAgence_id = $row["produitAgence_id"];
	$quantiteEncien = $row["quantity_total_agence"];

	$id_agence 					= $id_agence_arrive;
	$id_agence_arrive 			= $id_agence_arrive;
	$product_id 				= $product_id;
	$quantiteNew 				= $quantity;
	$quantity_total_agenceNew 	= $quantity_total;
	$prix_venteNew 				= $rate;
	$prix_achatNew 				= $prix_achat;

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

				################# fin historique ###########################################################

	$quantity_total_agence = $quantiteEncien + $quantiteNew; // quantite total encien quantite + l nouveau quantite
	$prix_total_vente = $prix_venteNew * $quantity_total_agence; // prix total de vente du nouveau stock

	$prix_total_achat	= $prix_achatNew *  $quantity_total_agence; // prix total du nouveau stock en totalite
	$benefice_total = $prix_total_vente - $prix_total_achat; // benificie total du nouveau stock

	$id_user 			= $_SESSION['userId'];
	$date_add 			= date("Y-m-d H:m:s");

	$sql = "UPDATE  produit_agence SET 
	
	quantity_total_agence 	= $quantity_total_agence , 
	quantite 				= $quantiteNew,  
	prix_total_vente 		= $prix_total_vente, 
	prix_total_achat 		= $prix_total_achat,
	benefice_total 			= $benefice_total, 
	id_user_edit 			= $id_user, 
	date_edit 				= '$date_add'

	WHERE produitAgence_id = $produitAgence_id
	";
	if($connect->query($sql) === TRUE) {
		
		$valid['success'] = true;
		$valid['messages'] = "Le produit est bien transfert";	

	} else {
		$valid['success'] = false;
		$valid['messages'] = "Error while adding the members";
	}

}

}