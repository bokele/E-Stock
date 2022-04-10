<?php 	

require_once 'core.php';

$id_commande = $_POST['id_commande'];


$sql = "SELECT id_commande, ref_commande, date_commande, id_marque, prix_total_achat, status,  user_add, date_add FROM boncommande WHERE id_commande = $id_commande ";
$result = $connect->query($sql);
$row ="";
if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>