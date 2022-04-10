<?php 	

require_once 'core.php';

$sql = "SELECT 	id_versement, versement.id_banque, nom_banque, montant_verse, numero_compte_banque, nom_personne_verse, 	numero_bordereau, date_bordereau, type_versement, user_add_verserment, date_add_versement FROM versement INNER JOIN banque ON   versement.id_banque = banque.id_banque ORDER BY id_versement DESC";
$result = $connect->query($sql);

$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeBrands = ""; 

 while($row = $result->fetch_array()) {
 	$id_versement = $row[0];
$type;
if ($row[8] == 1) {

	$type = "<label class='label label-success'>Cash</label>";
	
}else{
	$type = "<label class='label label-primary'>Chèque</label>";
}

 	$button = '<!-- Single button -->
	<a type="button" data-toggle="modal" data-target="#viewVersementModel" onclick="viewVersement('.$id_versement.')" class ="btn btn-info btn-sm"> <i class="fa fa-eye"></i> </a>   
	  ';
	  $versementDate = new DateTime($row[7]);
 	$output['data'][] = array( 	
 		$versementDate->format("d/m/Y"),
 		$row[2],
 		number_format(intval($row[3]),2),	
 		$row[4], 
 		$type,		
 		$button
 		); 	
 } // /while 

} // if num_rows

$connect->close();

echo json_encode($output);