<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST['date_facture']) {	
	$date_paiement 				= date('Y-m-d', strtotime($_POST['date_facture']));
	$facture_depense 			= $_POST['facture_depense']; 
  $id_Compte 					  = $_POST['id_Compte'];
  $id_sous_compte 			= $_POST['id_sous_compte'];  
  $paymentType        	= $_POST['paymentType'];
  $paymentStatus        = $_POST['paymentStatusPayement'];
  $montant        			= $_POST['montant'];
  $observation 		      = $_POST['observation_depense'];
  $id_depense					  = $_POST['depensePayementId'];
 $user_add 					    = $_SESSION['userId'];
  $date_add 					  = date("Y-m-d H:m:s");
  $compte = "";
  if ($id_sous_compte == "") {
  	$compte = 	$id_Compte; 		
  }else{
  	$compte = $id_sous_compte;
  }

	$montant = number_format($montant,2);


  $sql = "INSERT INTO depense_paye (id_depense, code_compte, numero_facture_depense ,montant, type_paiement, status_paiement, date_paiement, observation, user_add, date_add) 

  VALUES ($id_depense, '$compte',  '$facture_depense',  '$montant',  '$paymentStatus', $paymentType, '$date_paiement', '$observation', '$user_add', '$date_add')";




	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "L'enregistre du paiement se termine avec succès";	

    if ($paymentStatus == 1) {
      $sql = "UPDATE depenses SET status_payement = 1 WHERE id_depense =$id_depense";
      $connect->query($sql);
    }elseif($paymentStatus == 2){
      $sql = "UPDATE depenses SET status_payement = 2 WHERE id_depense =$id_depense";
      $connect->query($sql);
    }else{
      $sql = "UPDATE depenses SET status_payement = 3 WHERE id_depense =$id_depense";
    $connect->query($sql);
    }
		

	} else {
		$valid['success'] = false;
		$valid['messages'] = "Erreur lors de l'enregistrement".mysqli_error($connect);
	}
	 
$connect->close();

} // /if $_POST

echo json_encode($valid);
