<?php 	

require_once 'core.php';



$valid = array('classeData' => array());


$sql = "SELECT id_caisse,date_caisse, montant_caisse FROM caisse ORDER BY id_caisse DESC";

$result = $connect->query($sql);
 $x=1;
  while($row = $result->fetch_array()){
  	$id_caisse =$row[0];
 	$button = '<!-- Single button -->
 	

	<a href="php_action/printCaisseLivre.php?caisseId='.$id_caisse.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>
       
	 ';
	$date_caisse = new DateTime($row[1]);
 	$valid['data'][] = array( 

 		$date_caisse->format('d/m/Y'),
 		$row[2],
 		
 		// button
 		$button 		
 		); 

 		$x++;	
 } // /while

$connect->close();

echo json_encode($valid);

?>