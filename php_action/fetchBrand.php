<?php 	

require_once 'core.php';

$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeBrands = ""; 

 while($row = $result->fetch_array()) {
 	$brandId = $row[0];
 	// active 
 	if($row[2] == 1) {
 		// activate member
 		$activeBrands = "<label class='label label-success'>Disponible</label>";
 	} else {
 		// deactivate member
 		$activeBrands = "<label class='label label-danger'>Indisponible</label>";
 	}

 	$button = '<!-- Single button -->
	<a type="button" data-toggle="modal" data-target="#editBrandModel" onclick="editBrands('.$brandId.')" class ="btn btn-warning btn-sm"> <i class="glyphicon glyphicon-edit"></i> </a>
	<a type="button" data-toggle="modal" data-target="#removeMemberModal" onclick="removeBrands('.$brandId.')" class ="btn btn-danger btn-sm"> <i class="glyphicon glyphicon-trash"></i> </a>     
	  ';

 	$output['data'][] = array( 		
 		$row[1],
 		 $activeBrands,		
 		$button
 		); 	
 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);