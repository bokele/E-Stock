<?php 	

require_once 'core.php';



$valid = array('depenseData' => array());


$sql = "SELECT id_depense, ref_depense, prix_total_depense, date_depense, demende_depense, autorisation_depense,status_payement, status,  user_add, date_add FROM depenses  WHERE status != 2 ORDER BY id_depense DESC";

$result = $connect->query($sql);
  while($row = $result->fetch_array()){
 	$id_depense = $row[0];
 	$status="";
 	if ($row[6] == 1 ) {
 		$status = "<label class='label label-success text-center'> Payé</label>";

 	}else if ($row[6] == 2) {
 		$status = "<label class='label label-warning text-center'> Credit</label>";
 	}else if ($row[5] == 0) {
 		$status = "<label class='label label-danger text-center'> Non Payé</label>";
 	}

 	if ($row[6] == 1 ) {
 		$button = '<!-- Single button -->
 		<a href="php_action/printAutorisationDepense.php?depenseId='.$id_depense.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>
 		<a type="button" data-toggle="modal" id="viewAgenceModalBtn" data-target="#depenseModalView" onclick="viewDepense('.$id_depense.')" class ="btn btn-info btn-sm"> <i class="btn-info  fa fa-eye"></i> </a> 
 		<a type="button" data-toggle="modal" id="editAgencModalBtn" data-target="#attacheFactureDepenseDepenseModal" onclick="attacheFacture('.$id_depense.')" class ="btn-default   btn-sm"> <i class="fa fa-paperclip"></i> </a> 

 		
	 ';

 	}

		else if ($row[6] == 2 OR $row[6] == 3) {
 		$button = '<!-- Single button -->
 		<a href="php_action/printAutorisationDepense.php?depenseId='.$id_depense.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>
 		<a type="button" data-toggle="modal" id="viewAgenceModalBtn" data-target="#depenseModalView" onclick="viewDepense('.$id_depense.')" class ="btn btn-info btn-sm"> <i class="btn-info  fa fa-eye"></i> </a>  
 		

 		 <a href="depense.php?o=editDep&DP='.$id_depense.'" id="editDepenseModalBtn" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i></a></li>

 		<a type="button" data-toggle="modal" id="editAgencModalBtn" data-target="#attacheFactureDepenseDepenseModal" onclick="attacheFacture('.$id_depense.')" class ="btn-default   btn-sm"> <i class="fa fa-paperclip"></i> </a>
 		
	 ';

 	} 
 	else{
 		$button = '<!-- Single button -->
 		<a href="php_action/printAutorisationDepense.php?depenseId='.$id_depense.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>
 		<a type="button" data-toggle="modal" id="payementDepenseModalBtn" data-target="#addPayementDepenseModal" onclick="payementDepense('.$id_depense.')" class ="btn btn-primary btn-sm"> <i class="fa fa-usd"></i> </a>
 		<a href="depense.php?DP='.$id_depense.'" id="editDepenseModalBtn" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i></a></li>

 		<a type="button" data-toggle="modal" id="viewAgenceModalBtn" data-target="#depenseModalView" onclick="viewDepense('.$id_depense.')" class ="btn btn-info btn-sm"> <i class="fa fa-eye"></i> </a>

		<a type="button" data-toggle="modal" id="editAgencModalBtn" data-target="#attacheFactureDepenseDepenseModal" onclick="attacheFacture('.$id_depense.')" class ="btn-default   btn-sm"> <i class="fa fa-paperclip"></i> </a>

	    <a type="button" data-toggle="modal" data-target="#removeDepenseModal" id="removeCommandeModalBtn" onclick="removeDepense('.$id_depense.')" class ="btn btn-danger btn-sm"> <i class="fa fa-trash"></i></a></li>       
	 ';
 	}

 	$date_depense = new DateTime($row[3]);
 	$valid['data'][] = array( 		
 		// date de la commande
 		$date_depense->format('d/m/Y'),
 		// reference 
 		$row[1],
 		// montant
 		$row[2],
 		//demande
 		$row[4],
 		//autorise
 		$row[5],

 		$status,
 		//$row[6],
 		// button
 		$button 		
 		); 	
 } // /while

$connect->close();

echo json_encode($valid);

?>