<?php 	

require_once 'core.php';

$commandeId = $_POST['commandeId'];

$sql = "SELECT id_commande, ref_commande, date_commande, brand_name, prix_total_achat, status,  user_add, date_add, pieceBonLivraisionCommande FROM boncommande INNER JOIN brands ON brand_id = id_marque WHERE id_commande = $commandeId";

$commandeResult = $connect->query($sql);
$CommandeData = $commandeResult->fetch_array();

$date_commande = new DateTime( $CommandeData[2]);
$id_commande = $CommandeData[0];
$ref_commande = $CommandeData[1];
$brand_name = $CommandeData[3]; 
$prix_total_achat = $CommandeData[4];
$status = $CommandeData[5]; 
$user_add = $CommandeData[6];
$date_add = $CommandeData[7];
$pieceBonLivraisionCommande = $CommandeData[8];

$sql = "SELECT code_compte, boncommande_paye.montant, type_paiement, status_paiement, date_paiement, boncommande_paye.observation,numero_facture_boncommande, pieceFacture_boncommande FROM  boncommande_paye INNER JOIN boncommande  ON boncommande.id_commande = boncommande_paye.id_boncommande WHERE  boncommande_paye.id_boncommande =  $id_commande";
$sortiePayeResult = $connect->query($sql);

$vide="";
$code_compte 			= $vide;
$montantPaye 			= $vide;
$type_paiement 			= $vide;
$status_paiement 		= $vide;
$date_paiement 			= $vide;
$observation 			= $vide;
$status_payement		= $vide;
$pieceFacture_boncommande = $vide;  

if ($sortiePayeResult->num_rows > 0) {
	$sortiePayeData = $sortiePayeResult->fetch_array();
	$code_compte 			= $sortiePayeData[0];
	$montantPaye 			= $sortiePayeData[1];
	$type_paiement 			= $sortiePayeData[2];
	$status_paiement 		= $sortiePayeData[3];
	$date_paiement 			= new DateTime($sortiePayeData[4]);
	$observation 			= $sortiePayeData[5];
	$numero_facture_boncommande		= $sortiePayeData[6]; 
	$pieceFacture_boncommande = $sortiePayeData[7]; 
}else{
	$code_compte 			= $vide;
	$montantPaye 			= $vide;
	$type_paiement 			= $vide;
	$status_paiement 		= $vide;
	$date_paiement 			= $vide;
	$observation 			= $vide;
	$status_payement		= $vide;
	$pieceFacture_boncommande = $vide;  
}



if ($type_paiement == 1 ) {
 		$type = " Cheque";
 	}else if ($type_paiement == 2) {
 		$type = " Cash</label>";
 	}else if ($type_paiement == 3) {
 		$type = " Carte de Credit";
 	}
$status = "";
 	if ($status_paiement == 1 ) {
 		$status = "Paiement Total";

 	}else if ($status_paiement == 2) {
 		$status = "Paiement avec Avance";
 	}else{
 		$status = "Paiement avec Credit";
 	}




$commandeItemSql = "SELECT boncommande_item.id_commande, boncommande_item.quantite, boncommande_item.prix_achat, boncommande_item.prix_achat_total,
product.product_name FROM boncommande_item
	INNER JOIN product ON boncommande_item.id_produit = product.product_id 
 WHERE boncommande_item.id_commande = $id_commande";
$commandeItemResult = $connect->query($commandeItemSql);

 $table = '
 <table  class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		
		<tr>
			<th colspan="5">

				<center>
					<center>Numéro du Bon de commande : <span class="text-danger">'.$ref_commande.'</span></center>
					Date : '.$date_commande->format('d/m/Y').'
					<center>Nom du Fournisseur : '.$brand_name.'</center>
				</center>		
			</th>
				
		</tr>		
	</thead>
	<tbody>';

		if ($code_compte != "") {
			$table .= '	<tr>
			<td>
				<center>Date Facture : '.$date_paiement->format('d/m/Y').'</center>
					
			</td>
			<td>
				<center>Numero Facture : '.$numero_facture_boncommande.'</center>
					
			</td>
		</tr>
		<tr>

			
			<td colspan="2">
				<center> Observation : '.$observation.'</center>
					
			</td>


		</tr>
		</tr>
		<td>
				<center>Type de paiement : '.$type.'</center>
					
			</td>

			<td>
				<center>Status de paiement : '.$status.'</center>
					
			</td>';
			$compteSql = "SELECT comptabilite_sous_compte.code_sous_compte, comptabilite_sous_compte.libelle_sous_compte, comptabilite_compte_principal.code_compte, comptabilite_compte_principal.libelle_compte
 FROM comptabilite_sous_compte
	INNER JOIN comptabilite_compte_principal ON comptabilite_compte_principal.id_compte_principal = comptabilite_sous_compte.id_compte_principal 
 WHERE comptabilite_sous_compte.id_sous_compte = '$code_compte'";

 $compteResult = $connect->query($compteSql);

$row = $compteResult->fetch_array();

$compte = $row[0];

if ($code_compte != "") {

	$table .= '
		</tr>
		<tr>
			<td>
				<center> Exercice Comptable : '.date("Y").'</center>
					
			</td>
			<td>
				<center>Imputation Budgétaire: '.$compte.'</center>
					
			</td>

		</tr>

		';
	


	
}
	
		}

	$table .= '</tbody>
</table>

<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" border="" width="100%;" cellpadding="5">

	<tbody>
		<tr>
			<th>No.</th>
			<th>Produit</th>
			<th>Quantité</th>
			<th>PA</th>
			<th>PAT</th>
		</tr>';

		$x = 1;
		$total_pa=0;
		while($row = $commandeItemResult->fetch_array()) {			
						
			$table .= '<tr>
				<td>'.$x.'</td>
				<td>'.$row[4].'</td>
				<td>'.$row[1].'</td>
				<td>'.number_format($row[2],2).'</td>
				<td>'.number_format($row[3],2).'</td>
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
			<th colspan="" class="text-center">'.number_format($prix_total_achat,2).' bif</th>			
		</tr>	
	</tbody>
</table>
 ';
 if ($pieceFacture_boncommande != "") {
 	 $type2 = explode('.', $pieceFacture_boncommande);
 	$type2 = $type2[count($type2)-1];
 	if(in_array($type2, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))){
 		$table .='<img src="stock/'.$pieceFacture_boncommande.'"/>';
 	}else{
 		$table .='<object data="stock/'.$pieceFacture_boncommande.'" type="application/pdf" />';
 	}
 }

  if ($pieceBonLivraisionCommande != "") {
 	 $type2 = explode('.', $pieceBonLivraisionCommande);
 	$type2 = $type2[count($type2)-1];
 	if(in_array($type2, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))){
 		$table .='<img src="stock/'.$pieceBonLivraisionCommande.'" width="200px"/>';
 	}else{
 		$table .='<object data="stock/'.$pieceBonLivraisionCommande.'" type="application/pdf" />';
 	}
 }

$connect->close();
echo json_encode($table);