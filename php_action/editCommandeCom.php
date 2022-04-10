<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array(), 'depense_id' => '');
// print_r($valid);
if($_POST) {	

  // $date_commande 				= date('Y-m-d', strtotime($_POST['date_commande']));	
  	$prix_total_achatValue 			= $_POST['prix_total_achatValue'];
  //$quantite_total 				= $_POST['quantite_total'];
  	//$id_marque 				 	= $_POST['id_marque'];
	$id_commande = $_POST['id_commande'];

	$date_add = date("Y-m-d H:m:s");
  	$user_add = $_SESSION['userId'];

				
	$sql = "UPDATE  boncommande  SET 
	prix_total_achat 		= '$prix_total_achatValue',  
	user_edit				= $user_add, 
	date_edit 				= '$date_add' 

	WHERE id_commande = $id_commande";
	
	$depenseStatus = false;
	if($connect->query($sql) === true) {
		
		$depenseStatus = true;
		
	}
	
	// echo $_POST['id_produit'];
	$depenseItemStatus = false;

		for($x = 0; $x < count($_POST['productId']); $x++) {			
		$removeOrderSql = "DELETE FROM  boncommande_item WHERE id_commande = {$id_commande}";
		$connect->query($removeOrderSql);	
	} // /for quantity
if ($depenseStatus) {
	for($x = 0; $x < count($_POST['productId']); $x++) {			
		
				// add into order_item
				$commandeItemSql = "INSERT INTO boncommande_item (id_commande, id_produit, quantite, prix_achat, prix_achat_total) 
				VALUES ($id_commande, '".$_POST['productId'][$x]."', '".$_POST['quantite'][$x]."', '".$_POST['prix_achatValue'][$x]."', '".$_POST['prix_achat_totalValue'][$x]."')";

				
				$connect->query($commandeItemSql);		

				if($x == count($_POST['productId'])) {
					$depenseItemStatus = true;
				}		
			
	} // /for quantity
}
	

$connect->close();

	$valid['success'] = true;
	
	$valid['messages'] = "Votre depenses a été  bien modifier";
	

		
  
	

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);