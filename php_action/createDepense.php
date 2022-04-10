<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array(), 'id_depense' => '');
// print_r($valid);
if( !empty($_POST) AND $_POST['date_depense'] !="") {	

  	$date_depense 			= date('Y-m-d', strtotime($_POST['date_depense']));
	$demende_depense 		= $_POST['demende_depense'];
	$autorisation_depense 	= $_POST['autorisation_depense'];
	$prix_total_depense 	= $_POST['prix_total_achatValue'];

 
  $DEPENSE ="DP";
  $CHROM = "000000";
   $ANNEE = date("Y");
  $MOIS = date("m");
  $new_chrom = "";//parametre de facture
  $new_chromDP =  $DEPENSE. $ANNEE.$MOIS."-".$CHROM;
function zerofill ($num, $zerofill = 6)
{
    return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}

  $ref_depense=""; 
  $selectNumero = "SELECT prefix,annee,mois,last_fac FROM helper_chron WHERE prefix ='$DEPENSE'";
  $selectNumeroFact = $connect->query($selectNumero);
  $selectNumeroRow = $selectNumeroFact->num_rows;

  	if($selectNumeroRow == 0){
  		 
  		$insert_helper_chrom="INSERT INTO helper_chron(prefix,annee,mois,last_fac) VALUES('$DEPENSE',$ANNEE,$MOIS,'$new_chromDP')";
			$connect->query($insert_helper_chrom);
	}else{
				
				$selectNumero = "SELECT prefix,annee,mois,last_fac FROM helper_chron WHERE prefix ='$DEPENSE'";
  				$selectNumeroFact = $connect->query($selectNumero);
				$numero = $selectNumeroFact->fetch_row();
				$numDP = $numero[0];
				$numAnne = $numero[1];
				$numMois = $numero[2];
				if($numAnne == intval(date("Y")) || $numMois == intval(date("m")) ){
					$num =substr($numero[3], -6) ;
					$new_numFat = intval($num) +1;
					$new_num_chrom = zerofill($new_numFat);
					$ref_depense=$numDP."".$numAnne.$numMois."-".$new_num_chrom;
				}else{
					$updateAnneDP = "UPDATE helper_chron SET annee = '".date("Y")."', mois = '".date("m")."' ,last_fac='$new_chromDP' WHERE prefix='$DEPENSE'";
					$connect->query($updateAnneDP);

					$selectNumero = "SELECT prefix,annee,mois, last_fac FROM helper_chron WHERE prefix='$DEPENSE'";
					$resultSA = $connect->query($selectNumero);

					$numero = $resultSA->fetch_row();
					$numDP = $numero[0];
					$numAnne = $numero[1];
					$numMois = $numero[2];
					$num =substr($numero[3], -6) ;
					$new_numFat = intval($num)+1;
					$new_num_chrom = zerofill($new_numFat);
					$ref_depense=$numDP."".$numAnne.$numMois."-".$new_num_chrom;
				}
				
			
		}

	$date_add = date("Y-m-d H:m:s");
  	$user_add = $_SESSION['userId'];

  	$sql = "INSERT INTO depenses(ref_depense, prix_total_depense, date_depense, demende_depense, autorisation_depense, status_payement, user_add, date_add, status)

  	 VALUES ('$ref_depense', '$prix_total_depense', '$date_depense', '$demende_depense', '$autorisation_depense', 0,$user_add, '$date_add',1)";

	$id_depense="";
	
	$depenseStatus = false;
	if($connect->query($sql) === TRUE) {
		$id_depense = $connect->insert_id;
		$valid['id_depense'] = $id_depense;	

		$updateAnneDP = "UPDATE helper_chron SET last_fac='$ref_depense' WHERE prefix='$DEPENSE'";
		$connect->query($updateAnneDP);
		$depenseStatus = true;
		
	}
	
	// echo $_POST['id_produit'];
	$depenseItemStatus = false;

	for($x = 0; $x < count($_POST['libelle_depense']); $x++) {			
		
				// add into order_item
				$commandeItemSql = "INSERT INTO depense_item (id_depense, libelle_depense, quantite_depense, prix_achat_depense, prix_achat_total_depense, status_item_depense) 
				VALUES ($id_depense, '".$_POST['libelle_depense'][$x]."', '".$_POST['quantite'][$x]."', '".$_POST['prix_achat'][$x]."', '".$_POST['prix_achat_totalValue'][$x]."',1)";

				$connect->query($commandeItemSql);		

				if($x == count($_POST['libelle_depense'])) {
					$sortieItemStatus = true;	
				}		
			
	} // /for quantity



	$valid['success'] = true;
	$valid['messages'] = "Votre bon de sortie a été  bien Creer". mysqli_error($connect);
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);