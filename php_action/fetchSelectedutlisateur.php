<?php 	

require_once 'core.php';

$utilisateurId = $_POST['utilisateurId'];

$sql = "SELECT user_id, username, email, telephone, role, status,id_agence FROM users WHERE user_id = $utilisateurId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);
?>