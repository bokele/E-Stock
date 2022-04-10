<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array(), 'depense_id' => '');
// print_r($valid);
if($_POST) {	

  	$date_depense = date('Y-m-d', strtotime($_POST['date_depenseEdit']));
	$demende_depense = $_POST['demende_depenseEdit'];
	$autorisation_depense = $_POST['autorisation_depenseEdit'];
	$prix_total_depense = $_POST['prix_total_achatValue'];
	$id_depense = $_POST['id_depense'];

	$date_add = date("Y-m-d H:m:s");
  	$user_add = $_SESSION['userId'];

				
	$sql = "UPDATE depenses  SET 
	prix_total_depense 		= '$prix_total_depense', 
	date_depense 			= '$date_depense', 
	demende_depense 		= '$demende_depense', 
	autorisation_depense 	= '$autorisation_depense', 
	user_add				= $user_add, 
	date_add 				= '$date_add' 

	WHERE id_depense = $id_depense";
	
	$depenseStatus = false;
	if($connect->query($sql) === true) {
		
		$depenseStatus = true;
		
	}
	
	// echo $_POST['id_produit'];
	$depenseItemStatus = false;

		for($x = 0; $x < count($_POST['libelle_depense']); $x++) {			
		$removeOrderSql = "DELETE FROM depense_item WHERE id_depense = {$id_depense}";
		$connect->query($removeOrderSql);	
	} // /for quantity
if ($depenseStatus) {
	for($x = 0; $x < count($_POST['libelle_depense']); $x++) {			
		
				// add into order_item
				$commandeItemSql = "INSERT INTO depense_item (id_depense, libelle_depense, quantite_depense, prix_achat_depense, prix_achat_total_depense) 
				VALUES ($id_depense, '".$_POST['libelle_depense'][$x]."', '".$_POST['quantite'][$x]."', '".$_POST['prix_achat'][$x]."', '".$_POST['prix_achat_totalValue'][$x]."')";

				
				$connect->query($commandeItemSql);		

				if($x == count($_POST['libelle_depense'])) {
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