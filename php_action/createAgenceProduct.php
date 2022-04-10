 <?php 	
date_default_timezone_set('Africa/Bujumbura');
require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

  $id_agence 			= $_POST['id_agence'];
  $id_agence_arrive 	= $_POST['id_agence_arrive'];
  $product_id 			= $_POST['produitName'];
  $quantite 			= $_POST['quantity'];
  $prix_vente 			= $_POST['prix_vente'];
  $quantiteStocksRest 	= $_POST['quantiteStocksRest'];
  $prix_achat 			= $_POST['prix_achat'];
  $prix_total_vente 	= $prix_vente  * $quantite ; // prix total de vente pour la primeire foi
  $prix_total_achant	= $prix_achat *  $quantite;  // prix achat total du la primier foi
  $benefice_total 		= $prix_total_vente - $prix_total_achant; // benificie total du stock pour la primier foi
 
  $id_user 				= $_SESSION['userId'];
  $date_add 			= date("Y-m-d H:m:s");
  $produitAgence_id		= $_POST['stockId'];


  if ($id_agence_arrive ==  $id_agence) {
  	
		$valid['success'] = false;
		$valid['messages'] = "l'agence d'arrive : ".$id_agence_arrive." est identique de celui de depart : ".$id_agence;
  }else{

$ageceArrive = "SELECT id_agence_arrive,id_agence,produitAgence_id,quantite,prix_vente,product_id,quantity_total_agence,prix_vente,prix_total_vente,benefice_total, id_user, date_add FROM produit_agence WHERE id_agence_arrive = $id_agence_arrive AND product_id = $product_id";
$result = $connect->query($ageceArrive);

if ($result->num_rows ==  0) {



	$sql = "INSERT INTO produit_agence (id_agence,id_agence_arrive, product_id, quantity_total_agence, quantite, prix_vente,prix_achat_agence, prix_total_vente,prix_total_achat, benefice_total, id_user, date_add)
				VALUES ($id_agence, $id_agence_arrive, $product_id, $quantite, $quantite, $prix_vente,  $prix_achat , $prix_total_vente,  $prix_total_achant, $benefice_total, $id_user, '$date_add')";
				$produitAgence_idNew;
				if($connect->query($sql) === TRUE) {
					$produitAgence_idNew = $connect->insert_id;

					$sql_history = "INSERT INTO produit_history_agence (produitAgence_id,id_agence,id_agence_arrive, product_id, quantity_total_agence, quantite, prix_vente, prix_total_vente, benefice_total, id_user, date_add )
				VALUES ($produitAgence_idNew, $id_agence, $id_agence_arrive, $product_id, $quantite, $quantite, $prix_vente, $prix_total_vente, $benefice_total, $id_user, '$date_add')";

				$connect->query($sql_history);

				$quantity_total_agenceRest			= $quantiteStocksRest -  $quantite;
  					$prix_achat_totalNew			= $quantity_total_agenceRest * $prix_achat;
  					$rate_totalNew					= $quantity_total_agenceRest * $prix_vente;
  					$benefice_totalNew				= $rate_totalNew - $prix_achat_totalNew;

				$updateStockTable = "UPDATE produit_agence SET quantity_total_agence = $quantity_total_agenceRest , quantite = '$quantity_total_agenceRest' , prix_total_vente = '$rate_totalNew' ,prix_total_achat = '$prix_achat_totalNew' , benefice_total = '$benefice_totalNew' WHERE produitAgence_id = $produitAgence_id";
					$connect->query($updateStockTable);

					$valid['success'] = true;
					$valid['messages'] = "Le produit est bien transfert";	

				} else {
					$valid['success'] = false;
					$valid['messages'] = "EErreur de faire le transfert ".mysqli_error($connect);
				}
}

  	else{

	$ageceArrive = "SELECT id_agence_arrive,id_agence,produitAgence_id,quantite,prix_vente,product_id,quantity_total_agence,prix_vente,prix_total_vente,benefice_total, id_user, date_add FROM produit_agence WHERE id_agence_arrive = $id_agence_arrive AND product_id = $product_id";
	$result = $connect->query($ageceArrive);
	$row = $result->fetch_assoc();

	$produitAgence_id 	= $row["produitAgence_id"];
	$quantiteEncien 	= $row["quantite"];

##########  creation du history du produit dans une agence pour la facilite des rapport
  	$id_agence 				= $row['id_agence'];
 	$id_agence_arrive 		= $row['id_agence_arrive'];
  	$product_id 			= $row['product_id'];
  	$quantity_total_agence 	= $row['quantity_total_agence'];
  	$prix_vente 			= $row['prix_vente'];
  	$prix_total_vente 		= $row['prix_total_vente'];
  	$benefice_total 		= $row['benefice_total'];
  	$id_user 				= $row['id_user'];
  	$date_add 				= $row['date_add'];
  	$id_user_edit 			= $id_user; 
	$date_edit 				= '$date_add';

	$sql_history = "INSERT INTO produit_history_agence (produitAgence_id,id_agence,id_agence_arrive, product_id, quantity_total_agence, quantite, prix_vente, prix_total_vente, benefice_total, id_user, date_add)
				VALUES ($produitAgence_id, $id_agence, $id_agence_arrive, $product_id, $quantity_total_agence, $quantiteEncien, $prix_vente, $prix_total_vente, $benefice_total, $id_user, '$date_add' )";

				$connect->query($sql_history);

				################# fin historique ###########################################################
	$quantity_total_agenceStock = $quantiteEncien + $quantite;
	$quantity_total_agence = $quantiteEncien + $quantite; // quantite total encien quantite + l nouveau quantite
	$prix_total_vente = $row["prix_vente"] * $quantity_total_agence; // prix total de vente du nouveau stock

	$prix_total_achant	= $prix_achat *  $quantity_total_agence; // prix total du nouveau stock en totalite
	$benefice_total = $prix_total_vente - $prix_total_achant; // benificie total du nouveau stock

	$stockId		= $_POST['stockId'];
///////////////////// update agence arrive ////////////////////////////////
	$sql = "UPDATE  produit_agence SET 
	
	quantity_total_agence 	= $quantity_total_agence , 
	quantite 				= $quantity_total_agence,  
	prix_total_vente 		= $prix_total_vente, 
	benefice_total 			= $benefice_total, 
	id_user_edit 			= $id_user, 
	date_edit 				= '$date_add'

	WHERE produitAgence_id = $produitAgence_id AND id_agence_arrive = $id_agence_arrive
	";


	if($connect->query($sql) === TRUE) {
		$produitAgence_idNew = $produitAgence_id;
		$connect->query($sql_history);

		$quantity_total_agence		= $quantiteStocksRest -  $quantite;
		$prix_achat_total			= $quantity_total_agence * $prix_achat;
		$rate_total					= $quantity_total_agence * $prix_vente;
		$benefice_total				= $rate_total - $prix_achat_total;
///////////////////  update agence de depart ////////////////////
		$updateStockTable = "UPDATE produit_agence SET 
		quantity_total_agence = $quantity_total_agence , 
		quantite = '$quantity_total_agence' ,
		prix_total_vente = '$rate_total' ,
		benefice_total = '$benefice_total' 

		WHERE produitAgence_id = $stockId AND id_agence = $id_agence";


		if($connect->query($updateStockTable) === TRUE) { 
			$product_id 			= $_POST['produitName'];
/////////////////////// update stock ////////////////////////////////
			/*if ($id_agence == 1) {
				$sql = "SELECT rate, prix_achat FROM product WHERE product_id = $product_id";
		  		$result = $connect->query($sql);
				$row = $result->fetch_array();
				$rate			=	$row[0];
				$prix_achat		=	$row[1];
				$sqlStock = "SELECT * FROM product_stock WHERE product_id =  $product_id";
				$result = $connect->query($sqlStock);
				$row = $result->fetch_assoc();
				$quantity_totalOld 		= $row['quantity_total'];
			 	$prix_achat_totalOld  	= $row['prix_achat_total'];
			  	$rate_totalOld  		= $row['rate_total'];
			  	$benefice_totalOld  	= $row['benefice_total'];
			  	$id_userOld  			= $row['id_user'];
			  	$date_addOld 	 		= $row['date_add'];

			  	$sqlProduct = "INSERT INTO produit_history (product_id, date_add, prix_achat, prix_vente, pass_quantite, new_quantite, total_quantity, id_user) 
				VALUES ($product_id, '$date_addOld', $prix_achat,  $rate , quantiteStocksRest, $quantity_total_agence, $quantity_total_agence, $id_userOld)";
				$connect->query($sqlProduct);

				$updateStockTable = "UPDATE product_stock SET quantity_total = $quantity_total_agenceStock , prix_achat_total = '$prix_achat_total' ,rate_total = '$rate_total' , benefice_total = '$benefice_total' WHERE product_id = $product_id";
				$connect->query($updateStockTable);
			}else{
				$sql = "SELECT rate, prix_achat FROM product WHERE product_id = $product_id";
		  		$result = $connect->query($sql);
				$row = $result->fetch_array();
				$rate			=	$row[0];
				$prix_achat		=	$row[1];
				$sqlStock = "SELECT * FROM product_stock WHERE product_id =  $product_id";
				$result = $connect->query($sqlStock);
				$row = $result->fetch_assoc();
				$quantity_totalOld 		= $row['quantity_total'];
			 	$prix_achat_totalOld  	= $row['prix_achat_total'];
			  	$rate_totalOld  		= $row['rate_total'];
			  	$benefice_totalOld  	= $row['benefice_total'];
			  	$id_userOld  			= $row['id_user'];
			  	$date_addOld 	 		= $row['date_add'];

			  	$sqlProduct = "INSERT INTO produit_history (product_id, date_add, prix_achat, prix_vente, pass_quantite, new_quantite, total_quantity, id_user) 
				VALUES ($product_id, '$date_addOld', $prix_achat,  $rate , quantiteStocksRest, $quantity_total_agence, $quantity_total_agence, $id_userOld)";
				$connect->query($sqlProduct);

				$updateStockTable = "UPDATE product_stock SET quantity_total = $quantity_total_agence , prix_achat_total = '$prix_achat_total' ,rate_total = '$rate_total' , benefice_total = '$benefice_total' WHERE product_id = $product_id";
				$connect->query($updateStockTable);
			}// if  stock update*/

			$valid['success'] = true;
			$valid['messages'] = "Le produit est bien transfert";	
		}else {
			$valid['success'] = false;
			$valid['messages'] = "EErreur de faire le transfert ".mysqli_error($connect);
		}
		

	
	} 

}
					

	$connect->close();
  }

				
				

	echo json_encode($valid);
			
	}else{
		echo json_encode(mysqli_error($connect));
	} // if in_array 		

	
 
// /if $_POST