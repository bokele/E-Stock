<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');

$valid['success'] = array('success' => false, 'messages' => array());

$id_commande = $_POST['editCommandeId'];
$editCommandeStatus = $_POST['editCommandeStatus'];

if($id_commande) { 

 $sql = "UPDATE boncommande SET status = $editCommandeStatus WHERE id_commande = {$id_commande}";

 $orderItem = "UPDATE boncommande_item SET status = $editCommandeStatus WHERE  id_commande = {$id_commande}";

 if($connect->query($sql) === TRUE && $connect->query($orderItem) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Le Bon de commande a été supprimer avec success";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand".mysqli_error($connect);
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST