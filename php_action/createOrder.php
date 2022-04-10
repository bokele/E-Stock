<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array(), 'order_id' => '');
// print_r($valid);
if($_POST) {	

  $orderDate 					= date('Y-m-d', strtotime($_POST['orderDate']));	
  $client_id 					= $_POST['clientName'];
  
  $subTotalValue 				= $_POST['subTotalValue'];
  $vatValue 					= $_POST['vatValue'];
  $totalAmountValue    			= $_POST['totalAmountValue'];
  $discount 					= $_POST['discount'];
  $grandTotalValue 				= $_POST['grandTotalValue'];
  $paid 						= $_POST['paid'];
  $dueValue 					= $_POST['dueValue'];
  $paymentType 					= $_POST['paymentType'];
  $paymentStatus 				= $_POST['paymentStatus'];
  $factureTva					= $_POST['factureTva'];
  $agence						= $_POST['agence'];
  $facture = 0;

  $productTVA = substr($_POST["factureTva"], -1,1);
  $LIQUIDS ="LI";
  $SAVONOR = "SA";
  $ANNEE = date("Y");
  $MOIS = date("m");
  $CHROM = "000000";
 
  $new_chromSA =  $SAVONOR. $ANNEE.$MOIS."-".$CHROM;
  $new_chromLI =  $SAVONOR. $ANNEE.$MOIS."-".$CHROM;
function zerofill ($num, $zerofill = 6)
{
    return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}
$numeroFactureChrom=""; 
  $selectNumero = "SELECT prefix,annee,mois, last_fac FROM helper_chron";
  $selectNumeroFact = $connect->query($selectNumero);
  $selectNumeroRow = $selectNumeroFact->num_rows;

  	if($selectNumeroRow == 0){
  		 
  		$insert_helper_chrom="INSERT INTO helper_chron(prefix,annee,mois,last_fac) VALUES('$SAVONOR', $ANNEE, $MOIS, '$new_chromSA')";
			$connect->query($insert_helper_chrom);
		$insert_helper_chrom="INSERT INTO helper_chron(prefix,annee,mois,last_fac) VALUES('$LIQUIDS', $ANNEE, $MOIS, '$new_chromLI')";
			$connect->query($insert_helper_chrom);
	}else{
		if($productTVA == 1){
			$selectNumero = "SELECT prefix,annee, mois, last_fac FROM helper_chron WHERE prefix='$SAVONOR'";
			$resultSA = $connect->query($selectNumero);
			$selectNumeroRow = $resultSA->num_rows;
			if($selectNumeroRow == 0){
				$insert_helper_chrom="INSERT INTO helper_chron(prefix,annee,mois,last_fac) VALUES($SAVONOR,$ANNEE,$MOIS,'$new_chromSA')";
				$connect->query($insert_helper_chrom);
			}else{
				$selectNumero = "SELECT prefix,annee, mois, last_fac FROM helper_chron WHERE prefix='$SAVONOR'";
				$resultSA = $connect->query($selectNumero);
				$numero = $resultSA->fetch_row();
				$numSA = $numero[0];
				$numAnne = $numero[1];
				$numMois = $numero[2];
				if($numAnne == intval(date("Y")) || $numMois == intval(date("m"))) {
					$num =substr($numero[2], -6) ;
					$new_numFat = intval($num) +1;
					$new_num_chrom = zerofill($new_numFat);
					$numeroFactureChrom=$numSA."".$numAnne.$numMois."-".$new_num_chrom;
				}else{
					$updateAnneSA = "UPDATE helper_chron SET annee = '".date("Y")."',mois = '".date("m")."',last_fac='$new_chromSA' WHERE prefix='$SAVONOR'";
					$connect->query($updateAnneSA);

					$selectNumero = "SELECT prefix,annee, mois, last_fac FROM helper_chron WHERE prefix='$SAVONOR'";
					$resultSA = $connect->query($selectNumero);

					$numero = $resultSA->fetch_row();
					$numSA = $numero[0];
					$numAnne = $numero[1];
					$numMois = $numero[2];
					$num =substr($numero[2], -6) ;
					$new_numFat = intval($num)+1;
					$new_num_chrom = zerofill($new_numFat);
					$numeroFactureChrom=$numSA."".$numAnne.$numMois."-".$new_num_chrom;
				}
				
			}		
		}
		else{
			$selectNumero = "SELECT prefix,annee,mois,last_fac FROM helper_chron WHERE prefix='$LIQUIDS'";
			$resultSA = $connect->query($selectNumero);
			$selectNumeroRow = $resultSA->num_rows;
			if($selectNumeroRow == 0){
				 $new_chromLI =  $LIQUIDS.$ANNEE.$MOIS."-".$CHROM;
				$insert_helper_chrom="INSERT INTO helper_chron(prefix,annee,mois, last_fac) VALUES($LIQUIDS,$ANNEE,$MOIS,'$new_chromLI')";
				$connect->query($insert_helper_chrom);
			}else{
				$selectNumero = "SELECT prefix,annee,mois,last_fac FROM helper_chron WHERE prefix='$LIQUIDS'";
				$resultSA = $connect->query($selectNumero);
				$numero = $resultSA->fetch_row();
				$numSA = $numero[0];
				$numAnne = $numero[1];
				$numMois = $numero[2];
				if($numAnne == intval(date("Y")) || $numMois == intval(date("m"))) {
					$num =substr($numero[3], -6);
					$new_numFat = intval($num)+1;
					$new_num_chrom = zerofill($new_numFat);
					$numeroFactureChrom=$numSA.$numAnne.$numMois."-".$new_num_chrom;
				}else{
					$updateAnneSA = "UPDATE helper_chron SET annee = '".date("Y")."',mois = '".date("m")."', last_fac='$new_chromLI' WHERE prefix='$LIQUIDS'";
					$connect->query($updateAnneSA);

					$selectNumero = "SELECT prefix,annee,mois,last_fac FROM helper_chron WHERE prefix='$LIQUIDS'";
					$resultSA = $connect->query($selectNumero);

					$numero = $resultSA->fetch_row();
					$numSA = $numero[0];
					$numAnne = $numero[1];
					$numMois = $numero[2];
					$num =substr($numero[3], -6) ;
					$new_numFat = intval($num)+1;
					$new_num_chrom = zerofill($new_numFat);
					$numeroFactureChrom=$numSA."".$numAnne.$numMois."-".$new_num_chrom;

				}	
			}		
		}	
  	}

  $dateJour = date("Y-m-d H:m:s");
  $user_id = $_SESSION['userId'];
   $productTVA = substr($_POST["factureTva"], -1,1);
  $id_marque = $productTVA;
				
	$sql = "INSERT INTO orders (numeroFacture, order_date, client_id, sub_total, vat, total_amount, discount, grand_total, paid, due, payment_type, payment_status, order_status, factureTva, user_id, dateJour,agenceId, id_marque) 
	VALUES ('$numeroFactureChrom', '$orderDate', '$client_id', '$subTotalValue', '$vatValue', '$totalAmountValue', '$discount', '$grandTotalValue', '$paid', '$dueValue', $paymentType, $paymentStatus, 1, $factureTva, $user_id , '$dateJour', $agence, $id_marque)";
	
	$order_id;
	$orderStatus = false;
	if($connect->query($sql) === true) {
		$order_id = $connect->insert_id;
		$valid['order_id'] = $order_id;	

		$orderStatus = true;

		if ($productTVA == 1) {
		$updateAnneSA = "UPDATE helper_chron SET last_fac='$numeroFactureChrom' WHERE prefix='$SAVONOR'";
		$connect->query($updateAnneSA);
		}else{
			$updateAnneSA = "UPDATE helper_chron SET last_fac='$numeroFactureChrom' WHERE prefix='$LIQUIDS'";
			$connect->query($updateAnneSA);
		}
	}	
	// echo $_POST['productName'];
	$orderItemStatus = false;

	//if($agence == 1) {
		for($x = 0; $x < count($_POST['productName']); $x++) {			
		$updateProductQuantitySql = "SELECT produit_agence.quantite, produit_agence.date_add FROM produit_agence WHERE id_agence_arrive = $agence  AND produit_agence.product_id = ".$_POST['productName'][$x]."";
		$updateProductQuantityData = $connect->query($updateProductQuantitySql);

		////////////////////// on parcours pour update la quantite de produit
		while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()){
			$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];
			$updateDate[$x] 	= 	$updateProductQuantityResult[1];						

					/////////////// on sauvergarde l'historique du stock avant d'effectue le mise a jour
					
					$updateProductPrixSql = "SELECT rate, prix_achat, quantity_total, prix_achat_total, rate_total, benefice_total, product_stock.id_user, product_stock.date_add FROM product_stock INNER JOIN product ON product.product_id = product_stock.product_id WHERE  product_stock.product_id = ".$_POST['productName'][$x]."";

					$updateProductPrixData = $connect->query($updateProductPrixSql);

					while ($updatePrixData = $updateProductPrixData->fetch_row() ) {
						$updatePrixVente[$x] = $updatePrixData[0] * $updateQuantity[$x];
						$updatePrixAchat[$x] = 	$updatePrixData[1] * $updateQuantity[$x];
						$updateBeneficie[$x] =  $updatePrixVente[$x] - $updatePrixAchat[$x];

						$rate 					= $updatePrixData[0];
						$prix_achat 			= $updatePrixData[1];
						$quantity_total 		= $updatePrixData[2];
						$prix_achat_total 		= $updatePrixData[3];
						$rate_total 			= $updatePrixData[4];
						$benefice_total 		= $updatePrixData[5];
						$id_user 				= $updatePrixData[6];
						$date_add 				= $updatePrixData[7];


						$sql = "INSERT INTO produit_history (product_id, prix_achat, prix_vente, date_add,  pass_quantite, new_quantite, id_user) 
						VALUES (".$_POST['productName'][$x].", $prix_achat, $rate , '$date_add',  $quantity_total, ".$updateQuantity[$x].", $id_user)";

						$connect->query($sql);
							/////////////// on update le stock au niveau du stock generale
						$updateProductQuantitySql = "SELECT product_stock.quantity_total FROM product_stock WHERE product_stock.product_id = ".$_POST['productName'][$x]."";
						$updateProductQuantityData_product_stock = $connect->query($updateProductQuantitySql);
						$updateProductQuantityResult_product_stock = $updateProductQuantityData_product_stock->fetch_row();


						$updateQuantityStock[$x] = $updateProductQuantityResult_product_stock[0] - $_POST['quantity'][$x];
						$updatePrixVenteStock[$x] = $updatePrixData[0] * $updateQuantityStock[$x];
						$updatePrixAchatStock[$x] = $updatePrixData[1] * $updateQuantityStock[$x];
						$updateBeneficieStock[$x] =  $updatePrixVenteStock[$x] - $updatePrixAchatStock[$x];

						$updatePrixTable = "UPDATE product_stock SET quantity_total = '".$updateQuantityStock[$x]."', prix_achat_total = '".$updatePrixAchatStock[$x]."', rate_total = '".$updatePrixVenteStock[$x]."', benefice_total = '".$updateBeneficieStock[$x]."' WHERE product_id = ".$_POST['productName'][$x]."";
							$connect->query($updatePrixTable);
						

						/////////////// on sauvergarde l'historique du stock_agence avant d'effectue le mise a jour
							$ageceArrive = "SELECT produitAgence_id, id_agence, id_agence_arrive, product_id, quantity_total_agence, quantite, prix_vente, prix_total_vente, benefice_total, id_user, date_add, prix_achat_agence, prix_total_achat FROM produit_agence WHERE id_agence_arrive = $agence AND product_id = ".$_POST['productName'][$x]."";
							$result = $connect->query($ageceArrive);

							while ( $row = $result->fetch_array()) {
								$id_user 			= $_SESSION['userId'];
    							$date_add 			= date("Y-m-d H:m:s");

	    						$produitAgence_id		= $row[0];
								$id_agence 				= $row[1];
							 	$id_agence_arrive 		= $row[2];
							  	$product_id 			= $row[3];
							  	$quantity_total_agence 	= $row[4];
							  	$quantite 				= $row[5]; 	
							  	$prix_vente 			= $row[6];
							  	$prix_total_vente 		= $row[7];
							  	$benefice_total 		= $row[8];
							  	$id_user 				= $row[9];
							  	$date_add 				= $row[10];
							  	$prix_achat_agence		= $row[11];
							  	$prix_total_achat 		= $row[12];
							  	
								$sql_history = "INSERT INTO produit_history_agence (produitAgence_id,id_agence, id_agence_arrive, product_id, quantity_total_agence, quantite, new_quantite_agence, prix_vente,prix_achat_agence, prix_total_vente, prix_total_achat, benefice_total, id_user, date_add)

										VALUES ($produitAgence_id, $id_agence, $id_agence_arrive, $product_id, '$quantity_total_agence', '$quantite', ".$updateQuantity[$x].", '$prix_vente', '$prix_achat_agence', '$prix_total_vente', '$prix_total_achat', '$benefice_total', $id_user, '$date_add')";

								$connect->query($sql_history);
								// update product_agence table

								$updateProductTable = "UPDATE produit_agence SET quantite = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]." AND id_agence_arrive =".$agence;
								$connect->query($updateProductTable);
							}

					}//while

					// add into order_item
						$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
						VALUES ('$order_id', '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

						$connect->query($orderItemSql);		

						if($x == count($_POST['productName'])) {
							$orderItemStatus = true;	


					}//if
					
				
			} // while	
		} // /for quantity
	/*}else{

		for($x = 0; $x < count($_POST['productName']); $x++) {			
			$updateProductQuantitySql = "SELECT produit_agence.quantite, produit_agence.date_add FROM produit_agence WHERE id_agence_arrive = $agence  AND produit_agence.product_id = ".$_POST['productName'][$x]."";
			$updateProductQuantityData = $connect->query($updateProductQuantitySql);

			////////////////////// on parcours pour update la quantite de produit
			while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
				$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];
				$updateDate[$x] = 	$updateProductQuantityResult[1];	

				/////////////// on sauvergarde l'historique du stock_agence avant d'effectue le mise a jour
							$ageceArrive = "SELECT id_agence_arrive,id_agence,produitAgence_id,quantite,prix_vente,product_id,quantity_total_agence,prix_vente,prix_total_vente,benefice_total, id_user, date_add FROM produit_agence WHERE id_agence_arrive = $agence  AND product_id = ".$_POST['productName'][$x]."";
							$result = $connect->query($ageceArrive);

							$row = $result->fetch_array();
								$id_user 			= $_SESSION['userId'];
    							$date_add = date("Y-m-d H:m:s");

							$id_agence 				= $row['id_agence'];
						 	$id_agence_arrive 		= $row['id_agence_arrive'];
						  	$product_id 			= $row['product_id'];
						  	$quantite 				= $row['quantite'];
						  	$quantity_total_agence 	= $row['quantity_total_agence'];
						  	$prix_vente 			= $row['prix_vente'];
						  	$prix_total_vente 		= $row['prix_total_vente'];
						  	$benefice_total 		= $row['benefice_total'];
						  	$id_user 				= $row['id_user'];
						  	$date_add 				= $row['date_add'];
						  	$id_user_edit 			= $id_user; 
							$date_edit 				= '$date_add';

							$sql_history = "INSERT INTO produit_history_agence (produitAgence_id,id_agence,id_agence_arrive, product_id, quantity_total_agence, quantite, prix_vente, prix_total_vente, benefice_total, id_user, date_add, id_user_edit,date_edit )
										VALUES ($produitAgence_id, $id_agence, $id_agence_arrive, $product_id, $quantite, $quantite, $prix_vente, $prix_total_vente, $benefice_total, $id_user, '$date_add', $id_user_edit, '$date_edit' )";


							if ($connect->query($sql_history) === TRUE ) {
								// update product_agence table
								$updateProductTable = "UPDATE produit_agence SET quantite = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]." AND id_agence_arrive = $agence";
								$connect->query($updateProductTable);
							}// end if

				// add into order_item
				$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
				VALUES ('$order_id', '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

				$connect->query($orderItemSql);		

				if($x == count($_POST['productName'])) {
					$orderItemStatus = true;	


			}//end if

		}//end whille 

	}//end for

//}// end else*/


	$valid['success'] = true;
	$valid['messages'] = "La facture a été  bien Enregistre";	
	
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);