<?php 	

require_once 'core.php';

$id_classe = $_POST['id_classe'];


$sql = "SELECT id,libelle_classe FROM comptabilite_classe_compte WHERE id = $id_classe ";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>