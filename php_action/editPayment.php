<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	
	$orderId 				= $_POST['orderId'];
	$payAmountRest 			= $_POST['payAmountRest']; 
  	$paymentType 			= $_POST['paymentType'];
  	$paymentStatus 			= $_POST['paymentStatus'];  
  	$paidAmount        		= $_POST['paidAmount'];
  	$grandTotal        		= $_POST['grandTotal'];
  	$montantPaye        	= $_POST['montantPaye'];


  	$updatePaidAmount = $montantPaye + $paidAmount; // montant paye
  	$updateDue = $grandTotal - $updatePaidAmount; // montant qui reste a payer

	$sql = "UPDATE orders SET paid = '$updatePaidAmount', due = '$updateDue', payment_type = '$paymentType', payment_status = '$paymentStatus' WHERE order_id = {$orderId}";



	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "Mise à jour avec succès";	
		$sqlClient = "SELECT client_id FROM orders WHERE order_id = {$orderId} ";
		$result =$connect->query($sqlClient);
		$row = $result->fetch_assoc();

		$id_client = $row["client_id"];
		$date_remb = date("Y-m-d");

		$sql= "INSERT INTO remborsement(id_order_remb, id_client_remb, montant, date_remb) VALUES($orderId, $id_client, '$montantPaye', '$date_remb')";
		$connect->query($sql);
	} else {
		$valid['success'] = false;
		$valid['messages'] = "Erreur lors de la mise à jour des informations sur la commande";
	}

	 
$connect->close();

echo json_encode($valid);
 
} // /if $_POST