<?php 	

require_once 'core.php';

$banqueId = $_POST['banqueId'];

$sql = "SELECT id_banque, nom_banque, banque_status, user_add_banque, date_add_banque FROM banque WHERE id_banque = $banqueId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);