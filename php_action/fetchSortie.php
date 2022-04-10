<?php 	

require_once 'core.php';



$valid = array('depenseData' => array());


$sql = "SELECT id_bonSortie, date_sortie, ref_sortie, autorise_sortie, montant, observation_sortie,  user_add_sortie, date_add_sortie, status_sortie FROM bon_sortie  WHERE status != 2 ORDER BY id_bonSortie DESC";

$result = $connect->query($sql);
  while($row = $result->fetch_array()){
 	$id_bonSortie = $row[0];
 	$status="";
 

 	if ($row[8] == 1 ) {

 			$button = '<!-- Single button -->
 		<a href="php_action/printBonSortie.php?bonSortieId='.$id_bonSortie.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>
 		<a type="button" data-toggle="modal" id="payementDepenseModalBtn" data-target="#addPayementDepenseModal" onclick="payementSortie('.$id_bonSortie.')" class ="btn btn-primary btn-sm"> <i class="fa fa-usd"></i> </a>

 		<a href="sortie.php?bs='.$id_bonSortie.'" id="editDepenseModalBtn" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i></a></li>

 		<a type="button" data-toggle="modal" id="viewAgenceModalBtn" data-target="#depenseModalView" onclick="viewSortie('.$id_bonSortie.')" class ="btn btn-info btn-sm"> <i class="fa fa-eye"></i> </a>

		

	        
	 ';
 //<a type="button" data-toggle="modal" data-target="#removeDepenseModal" id="removeCommandeModalBtn" onclick="removeDepense('.$id_bonSortie.')" class ="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></a></li>   

 	} 
 	else{

 				$button = '<!-- Single button -->
 		<a href="php_action/printBonSortie.php?bonSortieId='.$id_bonSortie.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>
 		<a type="button" data-toggle="modal" id="viewAgenceModalBtn" data-target="#depenseModalView" onclick="viewSortie('.$id_bonSortie.')" class ="btn btn-info btn-sm"> <i class="btn-info  fa fa-eye"></i> </a> 
 		

 		<a type="button" data-toggle="modal" id="editAgencModalBtn" data-target="#attacheFactureDepenseDepenseModal" onclick="attacheFacture('.$id_bonSortie.')" class ="btn-default   btn-sm"> <i class="fa fa-paperclip"></i> </a>
 		
	 '; 	
 	}


 	$status ="";
 	if ($row[8] == 1 ) {
 		$status = "<label class='label label-danger text-center'> Non Validé</label>";
 	}else{
 		
 		$status = "<label class='label label-success text-center'> Validé</label>";
 	}

 	$date_sortie = new DateTime($row[1]);
 	$valid['data'][] = array( 		
 		// date de la commande
 		$date_sortie->format('d/m/Y'),
 		// reference 
 		$row[2],
 		// montant
 		number_format($row[4],2),
 		//demande
 		$row[3],

 		$status,
 		//$row[6],
 		// button
 		$button 		
 		); 	
 } // /while

$connect->close();

echo json_encode($valid);

?>