<?php 	

require_once 'core.php';

$sortieId = $_POST['sortieId'];
$sql = "SELECT bon_sortie.id_bonSortie, bon_sortie.ref_sortie, bon_sortie.montant, date_sortie, autorise_sortie, status_sortie, status,  observation_sortie FROM bon_sortie  WHERE bon_sortie.status != 2 AND bon_sortie.id_bonSortie =  $sortieId";

$sortieResult = $connect->query($sql);
$sortieData = $sortieResult->fetch_array();

$id_bonSortie			= $sortieData[0];
$date_sortie 			= new DateTime( $sortieData[3]);
$ref_sortie 			= $sortieData[1];
$montant 				= $sortieData[2];
$autorise_sortie		= $sortieData[4]; 
$status_sortie 			= $sortieData[5]; 
$observation_sortie		= $sortieData[7];


$sql = "SELECT code_compte, bon_sortie_paye.montant, type_paiement, status_paiement, date_paiement, bon_sortie_paye.observation FROM  bon_sortie_paye INNER JOIN bon_sortie  ON bon_sortie.id_bonSortie = bon_sortie_paye.id_bonSortie WHERE  bon_sortie_paye.id_bonSortie =  $id_bonSortie";
$sortiePayeResult = $connect->query($sql);

$vide="";
$code_compte 			= $vide;
$montantPaye 			= $vide;
$type_paiement 			= $vide;
$status_paiement 		= $vide;
$date_paiement 			= $vide;
$observation 			= $vide;
$status_payement		= $vide; 

if ($sortiePayeResult->num_rows > 0) {
	$sortiePayeData = $sortiePayeResult->fetch_array();
	$code_compte 			= $sortiePayeData[0];
	$montantPaye 			= $sortiePayeData[1];
	$type_paiement 			= $sortiePayeData[2];
	$status_paiement 		= $sortiePayeData[3];
	$date_paiement 			= new DateTime($sortiePayeData[4]);
	$observation 			= $sortiePayeData[5];
	//$status_payement		= $sortiePayeData[6]; 
}else{
	$code_compte 			= $vide;
	$montantPaye 			= $vide;
	$type_paiement 			= $vide;
	$status_paiement 		= $vide;
	$date_paiement 			= $vide;
	$observation 			= $vide;
	$status_payement		= $vide; 
}


$type ="";
if ($type_paiement == 1 ) {
 		$type = " Cheque";
 	}else if ($type_paiement == 2) {
 		$type = " Cash</label>";
 	}else if ($type_paiement == 3) {
 		$type = " Carte de Credit";
 	}
$status = "";
 	if ($status_paiement == 1 ) {
 		$status = "Non payé";

 	}else if ($status_paiement == 2) {
 		$status = " payé";
 	}


$compte ="";
if ($code_compte != "") {
	$compteSql = "SELECT comptabilite_sous_compte.code_sous_compte, comptabilite_sous_compte.libelle_sous_compte, comptabilite_compte_principal.code_compte, comptabilite_compte_principal.libelle_compte
 FROM comptabilite_sous_compte
	INNER JOIN comptabilite_compte_principal ON comptabilite_compte_principal.id_compte_principal = comptabilite_sous_compte.id_compte_principal 
 WHERE comptabilite_sous_compte.id_sous_compte = '$code_compte'";

 $compteResult = $connect->query($compteSql);

$row = $compteResult->fetch_array();
	$compte = $row[0];
	
}else{
	$compte = "...............";
}



$depenseItemSql = "SELECT bon_sortie_item.id_bonSortie, bon_sortie_item.quantite_sortie, bon_sortie_item.prix_achat_sortie, bon_sortie_item.prix_achat_total_sortie, bon_sortie_item.libelle_sortie FROM bon_sortie_item
	INNER JOIN bon_sortie ON bon_sortie_item.id_bonSortie = bon_sortie.id_bonSortie 
 WHERE bon_sortie_item.id_bonSortie ='$id_bonSortie'";



$depenseItemResult = $connect->query($depenseItemSql);

 $table = '
 <table  class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		
		<tr>
			<th colspan="5">

				<center>
					<center>Numéro du Bon de sortie : <span class="text-danger">'.$ref_sortie.'</span></center>
					Date : '.$date_sortie->format('d/m/Y').'


				</center>		
			</th>
				
		</tr>		
	</thead>
	<tbody>
		<tr>
			<td>
				<center>Autorise par : '.$autorise_sortie.'</center>
					
			</td>
			<td> Motif : '.$observation_sortie.'</td>
		</tr>';

		if ($code_compte != "") {
			$table .= '	<tr>
			<td>
				<center>Date Facture : '.$date_paiement->format('d/m/Y').'</center>
					
			</td>
			<td></td>
		</tr>

			<td>
				<center>Type de paiement : '.$type.'</center>
					
			</td>
			<td>
				<center> Observation : '.$observation.'</center>
					
			</td>
		</tr>
		</tr>

			<td>
				<center>Status de paiement : '.$status.'</center>
					
			</td>
			<td>
				<center> Compte : '.$compte.'</center>
					
			</td>
		</tr>

		';
		}

	$table .= '</tbody>
</table>
<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" border="" width="100%;" cellpadding="5">

	<tbody>
		<tr>
			<th>N°</th>
			<th>Libelle</th>
			<th>Quantité</th>
			<th>Montant</th>
			<th>Montant Total</th>
		</tr>';

		$x = 1;
		$total_pa=0;
		while($row = $depenseItemResult->fetch_array()) {			
						
			$table .= '<tr>
				<td>'.$x.'</td>
				<td>'.$row[4].'</td>
				<td>'.$row[1].'</td>
				<td>'.number_format($row[2],2).'</td>
				<td>'.$row[3].'</td>
			</tr>
			';

			//$total_pa +=$row[2]; 
		$x++;
		} // /while

		$table .= '
		<tr>
		
		<tr>
		<td colspan="5"></td>
		</tr>

		<tr>
			<th colspan="4" class="text-center">TOTAL GENERAL</th>
			<th colspan="" class="text-center">'.$montant.' bif</th>			
		</tr>	
	</tbody>
</table>
 ';


$connect->close();
echo json_encode($table);