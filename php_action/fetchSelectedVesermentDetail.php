<?php 	

require_once 'core.php';

$versemntId = $_POST['versemntId'];


$sql = "SELECT 	id_versement, versement.id_banque, nom_banque, montant_verse, numero_compte_banque, nom_personne_verse, 	numero_bordereau, date_bordereau, type_versement, user_add_verserment, date_add_versement FROM versement INNER JOIN banque ON   versement.id_banque = banque.id_banque WHERE  id_versement = '$versemntId'";
$result = $connect->query($sql);
$row ="";
if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>