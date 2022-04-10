<?php 	

require_once 'core.php';

$id_depense = $_POST['id_depense'];


$sql = "SELECT id_depense, ref_depense, prix_total_depense, date_depense, demende_depense, autorisation_depense, status_payement FROM depenses WHERE id_depense = $id_depense ";
$result = $connect->query($sql);
$row ="";
if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>