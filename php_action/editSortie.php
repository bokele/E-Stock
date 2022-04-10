<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array(), 'commande_id' => '');
// print_r($valid);
if($_POST) {	

  	$date_sortie 			= date('Y-m-d', strtotime($_POST['date_sortie']));
	$autorise_sortie 		= $_POST['autorise_sortie'];
	$observation_sortie 	= $_POST['observation_sortie'];
	$montantAfficheValue 	= $_POST['montantAfficheValue'];
	$id_bonSortie 			= $_POST['id_bonSortie'];

	$date_add = date("Y-m-d H:m:s");
  	$user_add = $_SESSION['userId'];

				
	$sql = "UPDATE bon_sortie  SET 
	montant 				= '$montantAfficheValue', 
	date_sortie 			= '$date_sortie', 
	autorise_sortie 		= '$autorise_sortie', 
	observation_sortie 		= '$observation_sortie', 
	user_add_sortie			= $user_add, 
	date_add_sortie 		= '$date_add' 

	WHERE id_bonSortie = $id_bonSortie";
	
	$depenseStatus = false;
	if($connect->query($sql) === true) {
		
		$depenseStatus = true;
		
	}
	
	// echo $_POST['id_produit'];
	$depenseItemStatus = false;

		for($x = 0; $x < count($_POST['libelle_sortie']); $x++) {			
		$removeOrderSql = "DELETE FROM bon_sortie_item WHERE id_bonSortie = {$id_bonSortie}";
		$connect->query($removeOrderSql);	
	} // /for quantity
if ($depenseStatus) {
	for($x = 0; $x < count($_POST['libelle_sortie']); $x++) {			
		
				// add into order_item
				$commandeItemSql = "INSERT INTO bon_sortie_item (id_bonSortie, libelle_sortie, quantite_sortie, prix_achat_sortie, prix_achat_total_sortie) 
				VALUES ($id_bonSortie, '".$_POST['libelle_sortie'][$x]."', '".$_POST['quantite_sortie'][$x]."', '".$_POST['prix_achat_sortie'][$x]."', '".$_POST['prix_achat_total_sortieValue'][$x]."')";

				
				$connect->query($commandeItemSql);		

				if($x == count($_POST['libelle_sortie'])) {
					$depenseItemStatus = true;
				}		
			
	} // /for quantity
}
	



	$valid['success'] = true;
	if ($x = 1) {
		$valid['messages'] = "La depenses a été  bien Creer";
	}else{
		$valid['messages'] = "Ces depenses ont été  bien Creer";
	}
	

		
  
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);