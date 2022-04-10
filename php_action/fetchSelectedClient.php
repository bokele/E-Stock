<?php 	

require_once 'core.php';

$clientId = $_POST['clientId'];


$sql = "SELECT id_client, nom_client, prenom_client, telephone_client, adresse_client,nif_client,user_add_client,date_add_client FROM client WHERE  id_client = '$clientId'";
$result = $connect->query($sql);
$row ="";
if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>