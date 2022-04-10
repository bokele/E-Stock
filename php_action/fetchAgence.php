<?php 	

require_once 'core.php';



$valid = array('agenceData' => array());


$sql = "SELECT id_agence,agence, tele_agence, province_agence, commune_agence, quartier_agence, avenue_agence, numero_agence, resp_agence, tele_resp_agence FROM agence";

$result = $connect->query($sql);
  while($row = $result->fetch_array()){
 	$id_agence = $row[0];

 	$button = '<!-- Single button -->
 	<a type="button" data-toggle="modal" id="viewAgenceModalBtn" data-target="#agenceModalView" onclick="viewAgence('.$id_agence.')" class ="btn btn-info btn-sm"> <i class="btn-info  fa fa-eye"></i> </a>

	<a type="button" data-toggle="modal" id="editAgencModalBtn" data-target="#agenceModalEdit" onclick="editAgence('.$id_agence.')" class ="btn btn-warning btn-sm"> <i class="btn-warning  glyphicon glyphicon-edit"></i> </a>

	    <a type="button" data-toggle="modal" data-target="#removeAgenceModal" id="removeAgenceModalBtn" onclick="removeAgence('.$id_agence.')" class ="btn btn-danger btn-sm"> <i class="btn-danger  glyphicon glyphicon-trash"></i></a></li>       
	 ';
$addresse ="'". $row[3]." - ".$row[4]." - ".$row[5]." - ".$row[6]." - ".$row[7]." - ".$row[8]."'";
 	$valid['data'][] = array( 		
 		// agence
 		$row[1],
 		// telephone
 		$row[2],
 		// resposable
 		$row[9],
 		//PA
 		$addresse, 
 		
 		// button
 		$button 		
 		); 	
 } // /while

$connect->close();

echo json_encode($valid);

?>