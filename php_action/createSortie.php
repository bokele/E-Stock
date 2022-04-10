<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array(), 'sortie_id' => '');
// print_r($valid);
if($_POST) {	

  	$date_sortie = date('Y-m-d', strtotime($_POST['date_sortie']));
	$observation_sortie  = $_POST['observation_sortie'];
	$autorise_sortie 	 = $_POST['autorise_sortie'];
	$montantAfficheValue = $_POST['montantAfficheValue'];

 


 
  $SORTIE ="BS";
  $CHROM = "000000";
   $ANNEE = date("Y");
  $MOIS = date("m");
  $new_chrom = "";//parametre de facture
  $new_chromDP =  $SORTIE. $ANNEE.$MOIS."-".$CHROM;
function zerofill ($num, $zerofill = 6)
{
    return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}

  $ref_sortie=""; 
  $selectNumero = "SELECT prefix,annee,mois,last_fac FROM helper_chron WHERE prefix ='$SORTIE'";
  $selectNumeroFact = $connect->query($selectNumero);
  $selectNumeroRow = $selectNumeroFact->num_rows;

  	if($selectNumeroRow == 0){
  		 
  		$insert_helper_chrom="INSERT INTO helper_chron(prefix,annee,mois,last_fac) VALUES('$SORTIE',$ANNEE,$MOIS,'$new_chromDP')";
			$connect->query($insert_helper_chrom);
	}else{
				$numero = $selectNumeroFact->fetch_row();
				$numDP = $numero[0];
				$numAnne = $numero[1];
				$numMois = $numero[2];
				if($numAnne == intval(date("Y")) || $numMois == intval(date("m")) ){
					$num =substr($numero[3], -6) ;
					$new_numFat = intval($num) +1;
					$new_num_chrom = zerofill($new_numFat);
					$ref_sortie=$numDP."".$numAnne.$numMois."-".$new_num_chrom;
				}else{
					$updateAnneDP = "UPDATE helper_chron SET annee = '".date("Y")."', mois = '".date("m")."' ,last_fac='$new_chromDP' WHERE prefix='$SORTIE'";
					$connect->query($updateAnneDP);

					$selectNumero = "SELECT prefix,annee,mois, last_fac FROM helper_chron WHERE prefix='$SORTIE'";
					$resultSA = $connect->query($selectNumero);

					$numero = $resultSA->fetch_row();
					$numDP = $numero[0];
					$numAnne = $numero[1];
					$numMois = $numero[2];
					$num =substr($numero[3], -6) ;
					$new_numFat = intval($num)+1;
					$new_num_chrom = zerofill($new_numFat);
					$ref_sortie=$numDP."".$numAnne.$numMois."-".$new_num_chrom;
				}
				
			
		}
		

			
			
  	
	$date_add = date("Y-m-d H:m:s");
  	$user_add = $_SESSION['userId'];
			
	$sql = "INSERT INTO bon_sortie (date_sortie, ref_sortie, autorise_sortie, montant, observation_sortie, user_add_sortie, date_add_sortie, status_sortie,	status) 
	VALUES ('$date_sortie', '$ref_sortie', '$autorise_sortie', '$montantAfficheValue', '$observation_sortie',  $user_add, '$date_add',1, 1 )";

	

	$sortie_id="";
	
	$sortieStatus = false;
	if($connect->query($sql) === true) {
		$sortie_id = $connect->insert_id;
		$valid['sortie_id'] = $sortie_id;	

		$updateAnneDP = "UPDATE helper_chron SET last_fac='$ref_sortie' WHERE prefix='$SORTIE'";
			$connect->query($updateAnneDP);

		$sortieStatus = true;

		
	}
	
	// echo $_POST['id_produit'];
	$sortieItemStatus = false;

	for($x = 0; $x < count($_POST['libelle_sortie']); $x++) {			
		
				// add into order_item
				$commandeItemSql = "INSERT INTO bon_sortie_item (id_bonSortie, 	libelle_sortie, quantite_sortie, prix_achat_sortie, prix_achat_total_sortie, status_item_sortie) 
				VALUES ($sortie_id, '".$_POST['libelle_sortie'][$x]."', '".$_POST['quantite_sortie'][$x]."', '".$_POST['prix_achat_sortie'][$x]."', '".$_POST['prix_achat_total_sortieValue'][$x]."', 1)";

				$connect->query($commandeItemSql);		

				if($x == count($_POST['libelle_sortie'])) {
					$sortieItemStatus = true;
				}		
			
	} // /for quantity



	$valid['success'] = true;

	$valid['messages'] = "Votre bon de sortie a été  bien Creer";
	

		
  
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);