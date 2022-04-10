<?php 	

require_once 'core.php';

$sql = "SELECT id_banque, nom_banque, banque_status, user_add_banque, date_add_banque FROM banque WHERE banque_status = 1 ORDER BY nom_banque ASC";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeBrands = ""; 

 while($row = $result->fetch_array()) {
 	$id_banque = $row[0];


 	$button = '<!-- Single button -->
	<a type="button" data-toggle="modal" data-target="#editBrandModel" onclick="editBanque('.$id_banque.')" class ="btn btn-warning btn-sm"> <i class="glyphicon glyphicon-edit"></i> </a>
	<a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeBanque('.$id_banque.')" class ="btn btn-danger btn-sm"> <i class="glyphicon glyphicon-trash"></i> </a>     
	  ';

 	$output['data'][] = array( 		
 		$row[1], 		
 		$button
 		); 	
 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);