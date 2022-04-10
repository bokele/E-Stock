<?php 	

require_once 'core.php';

$id_compte = $_POST['id_compte'];


$sql = "SELECT id_compte_principal, id_classe, code_compte,libelle_compte, status, user_add, date_add FROM comptabilite_compte_principal WHERE id_compte_principal = $id_compte ";
$result = $connect->query($sql);
$row ="";
if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);

?>