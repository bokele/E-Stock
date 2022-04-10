<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	
	$orderId = $_POST['orderId'];

  $orderDate 					= date('Y-m-d', strtotime($_POST['orderDate']));
  $subTotalValue 				= $_POST['subTotalValue'];
  $vatValue 					=	$_POST['vatValue'];
  $totalAmountValue     		= $_POST['totalAmountValue'];
  $discount 					= $_POST['discount'];
  $grandTotalValue 				= $_POST['grandTotalValue'];
  $paid 						= $_POST['paid'];
  $dueValue 					= $_POST['dueValue'];
  $paymentType 					= $_POST['paymentType'];
  $paymentStatus 				= $_POST['paymentStatus'];
  $agence						= $_POST['agence'];


				
if($agence == 1) {
	$sql = "UPDATE orders SET order_date = '$orderDate',  sub_total = '$subTotalValue', vat = '$vatValue', total_amount = '$totalAmountValue', discount = '$discount', grand_total = '$grandTotalValue', paid = '$paid', due = '$dueValue', payment_type = '$paymentType', payment_status = '$paymentStatus', order_status = 1 WHERE order_id = {$orderId}";	
	$connect->query($sql);
	
	$readyToUpdateOrderItem = false;
	// add the quantity from the order item to product table
	for($x = 0; $x < count($_POST['productName']); $x++) {
		$updateProductQuantitySql = "SELECT produit_agence.quantite, produit_agence.date_add FROM produit_agence WHERE id_agence_arrive = $agence  AND produit_agence.product_id = ".$_POST['productName'][$x]."";
		$updateProductQuantityData = $connect->query($updateProductQuantitySql);

		while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
			// order item table add product quantity
			$orderItemTableSql = "SELECT order_item.quantity FROM order_item WHERE order_item.order_id = {$orderId}";
			$orderItemResult = $connect->query($orderItemTableSql);
			$orderItemData = $orderItemResult->fetch_row();

			$editQuantity = $updateProductQuantityResult[0] + $orderItemData[0];

				/////////////// on sauvergarde l'historique du stock avant d'effectue le mise a jour
					
					$updateProductPrixSql = "SELECT rate, prix_achat, quantity_total, prix_achat_total, rate_total, benefice_total, product_stock.id_user, product_stock.date_add, rateTva FROM product_stock INNER JOIN product ON product.product_id = product_stock.product_id WHERE  product_stock.product_id = ".$_POST['productName'][$x]."";

					$updateProductPrixData = $connect->query($updateProductPrixSql);

					while ($updatePrixData = $updateProductPrixData->fetch_row() ) {
						$updatePrixVente[$x] 	= ($updatePrixData[0]+ $updatePrixData[8]) * $editQuantity[$x];
						$updatePrixAchat[$x] 	= $updatePrixData[1] * $editQuantity[$x];
						$updateBeneficie[$x] 	= $updatePrixVente[$x] - $updatePrixAchat[$x];
						$rate 					= $updatePrixData[0] + $updatePrixData[8];
						$prix_achat 			= $updatePrixData[1];
						$quantity_total 		= $updatePrixData[2];
						$prix_achat_total 		= $updatePrixData[3];
						$rate_total 			= $updatePrixData[4];
						$benefice_total 		= $updatePrixData[5];
						$id_user 				= $updatePrixData[6];
						$date_add 				= $updatePrixData[7];


						$sql = "INSERT INTO produit_history (product_id, prix_achat, prix_vente, date_add,  pass_quantite, new_quantite, id_user) 
						VALUES (".$_POST['productName'][$x].", $prix_achat, $rate , '$date_add',  $quantity_total, ".$editQuantity[$x].", $id_user)";

						$connect->query($sql);
						/////////////// on update le stock au niveau du stock generale
							$updatePrixTable = "UPDATE product_stock SET quantity_total = '".$editQuantity[$x]."', prix_achat_total = '".$updatePrixAchat[$x]."', rate_total = '".$updatePrixVente[$x]."', benefice_total = '".$updateBeneficie[$x]."' WHERE product_id = ".$_POST['productName'][$x]."";
							$connect->query($updatePrixTable);								

					if(count($_POST['productName']) == count($_POST['productName'])) {
						$readyToUpdateOrderItem = true;			
					}	
						// remove the order item data from order item table
				for($x = 0; $x < count($_POST['productName']); $x++) {			
					$removeOrderSql = "DELETE FROM order_item WHERE order_id = {$orderId}";
					$connect->query($removeOrderSql);	
				} // /for quantity


					if($readyToUpdateOrderItem) {
			// insert the order item data 
		for($x = 0; $x < count($_POST['productName']); $x++) {			
			$updateProductQuantitySql = "SELECT product_stock.quantity_total FROM product_stock WHERE product_stock.product_id = ".$_POST['productName'][$x]."";
			$updateProductQuantityData = $connect->query($updateProductQuantitySql);
			
			while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
				$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];

				$updatePrixVente[$x] = $updatePrixData[0] * $updateQuantity[$x];
				$updatePrixAchat[$x] = 	$updatePrixData[1] * $updateQuantity[$x];
				$updateBeneficie[$x] =  $updatePrixVente[$x] - $updatePrixAchat[$x];

				$updatePrixTable = "UPDATE product_stock SET quantity_total = '".$updateQuantity[$x]."', prix_achat_total = '".$updatePrixAchat[$x]."', rate_total = '".$updatePrixVente[$x]."', benefice_total = '".$updateBeneficie[$x]."' WHERE product_id = ".$_POST['productName'][$x]."";
							$connect->query($updatePrixTable);						
					// update product table
					$updateProductTable = "UPDATE produit_agence SET quantite = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]." AND id_agence_arrive = $agence";
								$connect->query($updateProductTable);

					// add into order_item
				$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
				VALUES ({$orderId}, '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";

				$connect->query($orderItemSql);		
			} // while	
		} // /for quantity
	}
		} // while	
	}}}
}else{
	$sql = "UPDATE orders SET order_date = '$orderDate', sub_total = '$subTotalValue', vat = '$vatValue', total_amount = '$totalAmountValue', discount = '$discount', grand_total = '$grandTotalValue', paid = '$paid', due = '$dueValue', payment_type = '$paymentType', payment_status = '$paymentStatus', order_status = 1 WHERE order_id = {$orderId}";	
	$connect->query($sql);
	
	$readyToUpdateOrderItem = false;

	for($x = 0; $x < count($_POST['productName']); $x++) {			
			$updateProductQuantitySql = "SELECT produit_agence.quantite, produit_agence.date_add FROM produit_agence WHERE id_agence_arrive = $agence  AND produit_agence.product_id = ".$_POST['productName'][$x]."";
			$updateProductQuantityData = $connect->query($updateProductQuantitySql);
			////////////////////// on parcours pour update la quantite de produit
			while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
				// order item table add product quantity
				$orderItemTableSql = "SELECT order_item.quantity FROM order_item WHERE order_item.order_id = {$orderId}";
				$orderItemResult = $connect->query($orderItemTableSql);
				$orderItemData = $orderItemResult->fetch_row();

				$editQuantity = $updateProductQuantityResult[0] + $orderItemData[0];

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
								$updateProductTable = "UPDATE produit_agence SET quantite = '".$editQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]." AND id_agence_arrive = $agence";
								$connect->query($updateProductTable);
							}// end if

									// remove the order item data from order item table
							for($x = 0; $x < count($_POST['productName']); $x++) {			
								$removeOrderSql = "DELETE FROM order_item WHERE order_id = {$orderId}";
								$connect->query($removeOrderSql);	
							} // /for quantity


	if($readyToUpdateOrderItem) {
			// insert the order item data 
		for($x = 0; $x < count($_POST['productName']); $x++) {			
			$updateProductQuantitySql = "SELECT product.quantity FROM product WHERE product.product_id = ".$_POST['productName'][$x]."";
			$updateProductQuantityData = $connect->query($updateProductQuantitySql);
			
			while ($updateProductQuantityResult = $updateProductQuantityData->fetch_row()) {
				$updateQuantity[$x] = $updateProductQuantityResult[0] - $_POST['quantity'][$x];							
					// update product table
					$updateProductTable = "UPDATE produit_agence SET quantite = '".$updateQuantity[$x]."' WHERE product_id = ".$_POST['productName'][$x]." AND id_agence_arrive = $agence";
								$connect->query($updateProductTable);

					// add into order_item
				// add into order_item
						$orderItemSql = "INSERT INTO order_item (order_id, product_id, quantity, rate, total, order_item_status) 
						VALUES ('$order_id', '".$_POST['productName'][$x]."', '".$_POST['quantity'][$x]."', '".$_POST['rateValue'][$x]."', '".$_POST['totalValue'][$x]."', 1)";
				$connect->query($orderItemSql);		

				if($x == count($_POST['productName'])) {
					$orderItemStatus = true;	


			}//end if	
			} // while	
		} // /for quantity
	}
			}


}

	

	$valid['success'] = true;
	$valid['messages'] = "La facture a été  bien Modifier";		
	
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);