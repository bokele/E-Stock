<?php 	

require_once 'core.php';



$valid = array('classeData' => array());


$sql = "SELECT id,libelle_classe, user_add, date_add FROM comptabilite_classe_compte WHERE status = 1";

$result = $connect->query($sql);
 $x=1;
  while($row = $result->fetch_array()){
  	$id =$row[0];
 	$button = '<!-- Single button -->
 	

	<a type="button" data-toggle="modal" id="editAgencModalBtn" data-target="#classeEditModal" onclick="editClasse('.$id.')" class ="btn btn-warning btn-sm"> <i class="btn-warning  fa fa-pencil"></i> </a>

	    <a type="button" data-toggle="modal" data-target="#removeClasseModal" id="removeAgenceModalBtn" onclick="removeClasse('.$id.')" class ="btn btn-danger btn-sm"> <i class="btn-danger  fa fa-trash"></i></a></li>       
	 ';
	
 	$valid['data'][] = array( 
 		//$x,		
 		// classe
 		$row[1],
 		
 		// button
 		$button 		
 		); 

 		//$x++;	
 } // /while

$connect->close();

echo json_encode($valid);

?>