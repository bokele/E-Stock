<?php 	

require_once 'core.php';

$id_sortie = $_POST['id_sortie'];


$sql = "SELECT id_bonSortie, ref_sortie, montant, date_sortie, autorise_sortie, status_sortie FROM bon_sortie WHERE id_bonSortie = $id_sortie ";
$result = $connect->query($sql);
$row ="";
if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>