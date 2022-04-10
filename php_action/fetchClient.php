<?php 	

require_once 'core.php';

$sql = "SELECT 	id_client, nom_client, prenom_client, telephone_client, adresse_client,nif_client FROM client WHERE status_client = 1  ORDER BY id_client DESC";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeBrands = ""; 

 while($row = $result->fetch_array()) {
 	$id_client = $row[0];
$type;


 	$button = '<!-- Single button -->
	<a type="button" data-toggle="modal" data-target="#viewVersementModel" onclick="editClient('.$id_client.')" class ="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i> </a> 
	<a type="button" data-toggle="modal" data-target="#removeClientModal" onclick="removeClient('.$id_client.')" class ="btn btn-danger btn-sm"> <i class="fa fa-trash"></i> </a>   
	  ';

 	$output['data'][] = array( 	

 		$row[1]." ".$row[2],
 		$row[3],
 		$row[5], 
 		$row[4],
 				
 		$button
 		); 	
 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);