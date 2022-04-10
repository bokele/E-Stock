<?php 	

require_once 'core.php';

$id_agence = $_POST['id_agence'];


$sql = "SELECT id_agence,agence, tele_agence, province_agence, commune_agence, quartier_agence, avenue_agence, avenue_agence, numero_agence, resp_agence, tele_resp_agence FROM agence WHERE id_agence = $id_agence ";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>