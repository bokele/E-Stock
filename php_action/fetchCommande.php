<?php 	

require_once 'core.php';



$valid = array('commandeData' => array());


$sql = "SELECT id_commande, ref_commande, date_commande, id_marque, prix_total_achat,brand_name, status_paye, status, user_add, date_add FROM boncommande INNER JOIN brands ON brand_id = id_marque  WHERE status != 4 ORDER BY id_commande DESC";

$result = $connect->query($sql);
  while($row = $result->fetch_array()){
 	$id_commande = $row[0];
 	$status="";
 	if ($row[7] == 1 ) {
 		$status = "<label class='label label-primary text-center'> Envoyé</label>";

 	}else if ($row[7] == 2) {
 		$status = "<label class='label label-success text-center'> Livré</label>";
 	}else if ($row[7] == 3) {
 		$status = "<label class='label label-danger text-center'> Annullé</label>";
 	}

 	if ($row[7] == 2 ) {
 		$button = '<!-- Single button -->
 		<a href="php_action/printBonCommande.php?commandeId='.$id_commande.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>
 		<a type="button" data-toggle="modal" id="viewAgenceModalBtn" data-target="#commandeModalView" onclick="viewCommande('.$id_commande.')" class ="btn btn-info btn-sm"> <i class="btn-info  fa fa-eye"></i> </a> 

		<a type="button" data-toggle="modal" id="editAgencModalBtn" data-target="#attacheFactureCommandeModal" onclick="attacheFacture('.$id_commande.')" class ="btn-default   btn-sm"> <i class="fa fa-paperclip"></i> </a> 
 	 ';

 	}



 	else{
 		$button = '<!-- Single button -->
 		<a href="php_action/printBonCommande.php?commandeId='.$id_commande.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>
 	<a type="button" data-toggle="modal" id="viewAgenceModalBtn" data-target="#commandeModalView" onclick="viewCommande('.$id_commande.')" class ="btn btn-info btn-sm"> <i class="btn-info  fa fa-eye"></i> </a>
 	<a type="button" data-toggle="modal" id="payementDepenseModalBtn" data-target="#addPayementCommandeModal" onclick="payementCommnade('.$id_commande.')" class ="btn btn-primary btn-sm"> <i class="fa fa-usd"></i> </a>


	<a href="commande.php?BC='.$id_commande.'" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i> </a>

	<a type="button" data-toggle="modal" id="editAgencModalBtn" data-target="#attacheFactureCommandeModal" onclick="attacheFacture('.$id_commande.')" class ="btn-default   btn-sm"> <i class="fa fa-paperclip"></i> </a> 

	    <a type="button" data-toggle="modal" data-target="#removeCommnandeModal" id="removeCommandeModalBtn" onclick="removeCommande('.$id_commande.')" class ="btn btn-danger btn-sm"> <i class="btn-danger  glyphicon glyphicon-trash"></i></a></li>       
	 ';
 	}

 	$commandeDate = new DateTime($row[2]);
 	$valid['data'][] = array( 		
 		// date de la commande
 		$commandeDate->format('d/m/Y'),
 		// reference de la commande
 		$row[1],
 		// marque
 		$row[5],
 		//prix total
 		number_format($row[4],2),
 		$status,
 		//$row[6],
 		// button
 		$button 		
 		); 	
 } // /while

$connect->close();

echo json_encode($valid);

?>