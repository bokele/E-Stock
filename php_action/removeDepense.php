<?php 	

require_once 'core.php';


$valid['success'] = array('success' => false, 'messages' => array());

$id_depense = $_POST['id_depense'];

if($id_depense) { 

 $sql = "UPDATE depenses SET status = 2 WHERE id_depense = {$id_depense}";

 $orderItem = "UPDATE depense_item SET status_item_depense = 2 WHERE  id_depense = {$id_depense}";

 if($connect->query($sql) === TRUE && $connect->query($orderItem) === TRUE) {
 	$valid['success'] = true;
	$valid['messages'] = "Le Bon de dépense a été supprimer avec success";		
 } else {
 	$valid['success'] = false;
 	$valid['messages'] = "Error while remove the brand".mysqli_error($connect);
 }
 
 $connect->close();

 echo json_encode($valid);
 
} // /if $_POST