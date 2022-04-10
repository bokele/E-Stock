<?php 	

require_once 'core.php';

$sql = "SELECT categories_id, categories_name, categories_active, categories_status, idBrand FROM categories WHERE categories_status = 1  ORDER BY categories_name ASC";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeCategories = ""; 

 while($row = $result->fetch_array()) {
 	$categoriesId = $row[0];
 	// active 
 	if($row[2] == 1) {
 		// activate member
 		$activeCategories = "<label class='label label-success'>Disponible</label>";
 	} else {
 		// deactivate member
 		$activeCategories = "<label class='label label-danger'>Indisponible</label>";
 	}
 	// marque
 	if($row[4] == 1) {
 		
 		$marque = "<label class='label label-info'>Savonor</label>";
 	} else {
 		
 		$marque = "<label class='label label-primary'>Liquids</label>";
 	}
 	$button = '<!-- Single button -->
	<a type="button" data-toggle="modal" id="editCategoriesModalBtn" data-target="#editCategoriesModal" onclick="editCategories('.$categoriesId.')" class ="btn btn-warning btn-sm"> <i class="btn-warning  glyphicon glyphicon-edit"></i> </a>

	    <a type="button" data-toggle="modal" data-target="#removeCategoriesModal" id="removeCategoriesModalBtn" onclick="removeCategories('.$categoriesId.')" class ="btn btn-danger btn-sm"> <i class="btn-danger  glyphicon glyphicon-trash"></i></a></li>       
	 ';

 	$output['data'][] = array( 		
 		$row[1], 
 		$marque,		
 		$activeCategories,
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);