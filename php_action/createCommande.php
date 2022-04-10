<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array(), 'commande_id' => '');
// print_r($valid);
if($_POST) {	

  $date_commande 					= date('Y-m-d', strtotime($_POST['date_commande']));	
  $prix_total_achatValue 			= $_POST['prix_total_achatValue'];
  //$quantite_total 				 	= $_POST['quantite_total'];
  $id_marque 				 		= $_POST['id_marque'];
 


 
  $LIQUIDS ="BCLI";
  $SAVONOR = "BCSA";
  $ANNEE = date("Y");
  $MOIS = date("m");
  $CHROM = "000000";
  $new_chrom = "";//parametre de facture
  $new_chromSA =  $SAVONOR. $ANNEE.$MOIS."-".$CHROM;
  $new_chromLI =  $LIQUIDS. $ANNEE.$MOIS."-".$CHROM;
function zerofill ($num, $zerofill = 6)
{
    return str_pad($num, $zerofill, '0', STR_PAD_LEFT);
}

  $ref_commande=""; 
  $selectNumero = "SELECT prefix,annee,mois,last_fac FROM helper_chron";
  $selectNumeroFact = $connect->query($selectNumero);
  $selectNumeroRow = $selectNumeroFact->num_rows;

  	if($selectNumeroRow == 0){
  		 
  		$insert_helper_chrom="INSERT INTO helper_chron(prefix,annee,mois,last_fac) VALUES('$SAVONOR', $ANNEE, $MOIS, '$new_chromSA')";
			$connect->query($insert_helper_chrom);
		$insert_helper_chrom="INSERT INTO helper_chron,prefix,annee,mois,last_fac) VALUES('$LIQUIDS', $ANNEE, $MOIS, '$new_chromLI')";
			$connect->query($insert_helper_chrom);
	}else{

		if ($id_marque == 1) {
			$sqlMarque = "SELECT prefix,annee,mois,last_fac  FROM helper_chron WHERE prefix='$SAVONOR'";
		$resultSA = $connect->query($sqlMarque);
		$selectNumeroRow = $resultSA->num_rows;
			if($selectNumeroRow == 0){
				$insert_helper_chrom="INSERT INTO helper_chron(prefix,annee,mois,last_fac) VALUES('$SAVONOR', $ANNEE, $MOIS, '$new_chromSA')";
				$connect->query($insert_helper_chrom);
			}else{
				$sqlMarque = "SELECT prefix,annee,mois,last_fac  FROM helper_chron WHERE prefix='$SAVONOR'";
				$resultSA = $connect->query($sqlMarque);
				$numero = $resultSA->fetch_row();
				$numSA = $numero[0];
				$numAnne = $numero[1];
				$numMois = $numero[2];
				if($numAnne == intval(date("Y")) || $numMois == intval(date("m")) ){
					$num =substr($numero[3], -6) ;
					$new_numFat = intval($num) +1;
					$new_num_chrom = zerofill($new_numFat);
					$ref_commande=$numSA."".$numAnne.$numMois."-".$new_num_chrom;
				}else{
					$updateAnneSA = "UPDATE helper_chron SET annee = '".date("Y")."', mois = '".date("m")."' ,last_fac='$new_chromSA' WHERE prefix='$SAVONOR'";
					$connect->query($updateAnneSA);

					$selectNumero = "SELECT prefix,annee,mois, last_fac FROM helper_chron WHERE prefix='$SAVONOR'";
					$resultSA = $connect->query($selectNumero);

					$numero = $resultSA->fetch_row();
					$numSA = $numero[0];
					$numAnne = $numero[1];
					$numMois = $numero[2];
					$num =substr($numero[3], -6) ;
					$new_numFat = intval($num)+1;
					$new_num_chrom = zerofill($new_numFat);
					$ref_commande=$numSA."".$numAnne.$numMois."-".$new_num_chrom;
				}
				
			}
		}else{
			$sqlMarque = "SELECT prefix,annee,mois,last_fac  FROM helper_chron WHERE prefix='$LIQUIDS'";
		$resultLI = $connect->query($sqlMarque);
		$selectNumeroRow = $resultLI->num_rows;
		 if($selectNumeroRow == 0){
			
				 $new_chrom =  $LIQUIDS. $ANNEE."-".$CHROM;
				$insert_helper_chrom="INSERT INTO helper_chron(prefix,annee,mois,last_fac) VALUES('$LIQUIDS',$ANNEE,$MOIS,'$new_chromLI')";
				$connect->query($insert_helper_chrom);
			}else{
				$sqlMarque = "SELECT prefix,annee,mois,last_fac  FROM helper_chron WHERE prefix='$LIQUIDS'";
				$resultLI = $connect->query($sqlMarque);
				$numero = $resultLI->fetch_row();
				$numSA = $numero[0];
				$numAnne = $numero[1];
				$numMois = $numero[2];
				if($numAnne == intval(date("Y"))){
					$num =substr($numero[3], -6);
					$new_numFat = intval($num)+1;
					$new_num_chrom = zerofill($new_numFat);
					$ref_commande=$numSA."".$numAnne.$numMois."-".$new_num_chrom;
				}else{
					$updateAnneSA = "UPDATE helper_chron SET annee = '".date("Y")."', mois = '".date("m")."' ,last_fac='$new_chromLI' WHERE prefix='$LIQUIDS'";
					$connect->query($updateAnneSA);

					$selectNumero = "SELECT prefix,annee, moi,last_fac FROM helper_chron WHERE prefix='$LIQUIDS'";
					$resultLI = $connect->query($selectNumero);

					$numero = $resultLI->fetch_row();
					$numSA = $numero[0];
					$numAnne = $numero[1];
					$numMois = $numero[2];
					$num =substr($numero[3], -6) ;
					$new_numFat = intval($num)+1;
					$new_num_chrom = zerofill($new_numFat);
					$ref_commande=$numSA."".$numAnne.$numMois."-".$new_num_chrom;

				}
				
			}	
		}
		

			
			
  	}
$date_add = date("Y-m-d H:m:s");
  $user_add = $_SESSION['userId'];

				
	$sql = "INSERT INTO boncommande (ref_commande, date_commande, id_marque, prix_total_achat, status, 	user_add, date_add) VALUES ('$ref_commande', '$date_commande', $id_marque, $prix_total_achatValue, 1, $user_add, '$date_add')";

	$commande_id="";
	
	$commandeStatus = false;
	if($connect->query($sql) === true) {
		$commande_id = $connect->insert_id;
		$valid['commande_id'] = $commande_id;	

		$commandeStatus = true;
		if ($id_marque == 1) {
			$updateAnneSA = "UPDATE helper_chron SET last_fac='$ref_commande' WHERE prefix='$SAVONOR'";
			$connect->query($updateAnneSA);
		}else{
			$updateAnneLI = "UPDATE helper_chron SET last_fac='$ref_commande' WHERE prefix='$LIQUIDS'";
			$connect->query($updateAnneLI);
		}
		
	}
	
	// echo $_POST['id_produit'];
	$commandeItemStatus = false;

	for($x = 0; $x < count($_POST['productId']); $x++) {			
		
				// add into order_item
				$commandeItemSql = "INSERT INTO boncommande_item (id_commande, id_produit, quantite, prix_achat, prix_achat_total, status) 
				VALUES ($commande_id, '".$_POST['productId'][$x]."', '".$_POST['quantite'][$x]."', '".$_POST['prix_achatValue'][$x]."', '".$_POST['prix_achat_totalValue'][$x]."', 1)";

				$connect->query($commandeItemSql);		

				if($x == count($_POST['productId'])) {
					$commandeItemStatus = true;

					$valid['success'] = true;
					$valid['messages'] = "Le Bon des commande a été  bien Creer ";

				}else{
					$valid['success'] = true;
					$valid['messages'] = "Le Bon des commande a été  bien Creer ";
				}		
			
	} // /for quantity

	

			

	

		
  
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST
// echo json_encode($valid);