<?php 	

require_once 'core.php';

$id_depense = $_POST['depenseId'];

$sql = "SELECT  id_depense, ref_depense, prix_total_depense, date_depense, demende_depense, autorisation_depense,depenses.status_payement, status FROM depenses WHERE status != 2 AND depenses.id_depense = $id_depense";

$depesneResult = $connect->query($sql);
$depenseData = $depesneResult->fetch_array();

$id_depense				= $depenseData[0];
$date_depense 			= new DateTime( $depenseData[3]);
$ref_depense 			= $depenseData[1];
$prix_total_depense 	= $depenseData[2];
$demende_depense		= $depenseData[4];
$autorisation_depense	= $depenseData[5]; 
$status_payement		= $depenseData[6]; 
$sql = "SELECT depense_paye.id_depense , code_compte, numero_facture_depense, montant, type_paiement, status_paiement, date_paiement, observation, pieceFacture  FROM depense_paye  INNER JOIN depenses ON depense_paye.id_depense = depenses.id_depense   WHERE status != 2 AND depenses.id_depense = $id_depense";

$depesneResult = $connect->query($sql);
$depensePayeLigne = $depesneResult->num_rows;

if ($depensePayeLigne > 0) {
	$depenseData = $depesneResult->fetch_array();

	$code_compte 			= $depenseData[1]; 
	$numero_facture_depense = $depenseData[2];
	$montant 				= $depenseData[3];
	$type_paiement 			= $depenseData[4]; 
	$status_paiement 		= $depenseData[5]; 
	$date_paiement 			= new DateTime($depenseData[6]);
	$observation 			= $depenseData[7];
	$pieceFacture 			= $depenseData[8];
}else{
	$code_compte 			= ""; 
	$numero_facture_depense = "";
	$montant 				= "";
	$type_paiement 			= "";; 
	$status_paiement 		= ""; 
	$date_paiement 			= "";
	$observation 			="";
	$pieceFacture			="";
}


$type ="";
if ($type_paiement == 1 ) {
 		$type = "<label class='label label-primary text-center'> Cheque</label>";

 	}else if ($type_paiement == 2) {
 		$type = "<label class='label label-success text-center'> Cash</label>";
 	}else if ($type_paiement == 3) {
 		$type = "<label class='label label-warning text-center'> Carte de Credit</label>";
 	}

 	if ($status_paiement == 1 ) {
 		$status = "<label class='label label-success text-center'> Payement Total</label>";

 	}else if ($status_paiement == 2) {
 		$status = "<label class='label label-warning text-center'> Avance</label>";
 	}else if ($status_paiement == 3) {
 		$status = "<label class='label label-danger text-center'> Credit</label>";
 	}


$compteSql = "SELECT comptabilite_sous_compte.code_sous_compte, comptabilite_sous_compte.libelle_sous_compte, comptabilite_compte_principal.code_compte, comptabilite_compte_principal.libelle_compte
 FROM comptabilite_sous_compte
	INNER JOIN comptabilite_compte_principal ON comptabilite_compte_principal.id_compte_principal = comptabilite_sous_compte.id_compte_principal 
 WHERE comptabilite_sous_compte.id_sous_compte = '$code_compte'";

 $compteResult = $connect->query($compteSql);

$row = $compteResult->fetch_array();

$compte = $row[0];



$depenseItemSql = "SELECT depense_item.id_depesne_item, depense_item.id_depense, depense_item.libelle_depense, depense_item.quantite_depense,
depense_item.prix_achat_depense,depense_item.prix_achat_total_depense FROM depense_item
	INNER JOIN depenses ON depense_item.id_depense = depenses.id_depense 
 WHERE depense_item.id_depense = '$id_depense'";



$depenseItemResult = $connect->query($depenseItemSql);

 $table = '
 <table  class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		
		<tr>
			<th colspan="5">

				<center>
					<center>Numéro du Bon de dépense : <span class="text-danger">'.$ref_depense.'</span></center>
					Date : '.$date_depense->format('d/m/Y').'


				</center>		
			</th>
				
		</tr>		
	</thead>
	<tbody>
		<tr>
			<td>
				<center>Demande par : '.$demende_depense.'</center>
					
			</td>
			<td>
				<center>Autorise par : '.$autorisation_depense.'</center>
					
			</td>
		</tr>';

		if ($code_compte != "") {
			$table .= '	<tr>
			<td>
				<center>Date Facture : '.$date_paiement->format('d/m/Y').'</center>
					
			</td>
			<td>
				<center>Numero Facture : '.$numero_facture_depense.'</center>
					
			</td>
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
			<th>PA</th>
			<th>PAT</th>
		</tr>';

		$x = 1;
		$total_pa=0;
		while($row = $depenseItemResult->fetch_array()) {			
						
			$table .= '<tr>
				<td>'.$x.'</td>
				<td>'.$row[2].'</td>
				<td>'.$row[3].'</td>
				<td>'.$row[4].'</td>
				<td>'.$row[5].'</td>
			</tr>
			';

			$total_pa +=$row[2]; 
		$x++;
		} // /while

		$table .= '
		<tr>
		
		<tr>
		<td colspan="5"></td>
		</tr>

		<tr>
			<th colspan="4" class="text-center">TOTAL GENERAL</th>
			<th colspan="" class="text-center">'.number_format($prix_total_depense,2).' bif</th>			
		</tr>	
	</tbody>
</table>
 ';

 if ($pieceFacture != "") {
 	 $type2 = explode('.', $pieceFacture);
 	$type2 = $type2[count($type2)-1];
 	if(in_array($type2, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))){
 		$table .='<img src="stock/'.$pieceFacture.'"/>';
 	}else{
 		$table .='<object data="stock/'.$pieceFacture.'" type="application/pdf" />';
 	}
 }


$connect->close();
echo json_encode($table);