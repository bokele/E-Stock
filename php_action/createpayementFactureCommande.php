<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

  $id_Compte 					= $_POST['id_Compte'];
  $id_sous_compte 		= $_POST['id_sous_compte'];  
  $paymentType        = $_POST['paymentType'];
  $status_paiement    = $_POST['paymentStatus'];
  $montant        		= $_POST['montant'];
  $observation 		    = $_POST['observation'];
  $id_bon				      = $_POST['depensePayementId'];
  $facture_depense    = $_POST['facture_depense'];
  $user_add 					= $_SESSION['userId'];
  $date_add 					= date("Y-m-d H:m:s");
  $date_paiement      = date("Y-m-d");
  $compte = "";
  if ($id_sous_compte == "") {
  	$compte = 	$id_Compte;
  		
  }else{
  	$compte = $id_sous_compte;
  }

	$montant = number_format($montant,2);


  $sql = "INSERT INTO boncommande_paye (id_boncommande, code_compte, numero_facture_boncommande,  montant, type_paiement, status_paiement, date_paiement, observation, user_add, date_add) 

  VALUES ($id_bon, '$compte', '$facture_depense',  '$montant',  '$status_paiement', $paymentType, '$date_paiement', '$observation', '$user_add', '$date_add')";




	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "L'enregistre du paiement se termine avec succès";	

      $sql = "UPDATE boncommande SET status_paye = 2 WHERE id_commande = $id_bon";
      $connect->query($sql);
 
		

	} else {
		$valid['success'] = false;
		$valid['messages'] = "Erreur lors de la mise à jour des informations sur la commande ".mysqli_error($connect);
	}

	 
$connect->close();

 
} // /if $_POST
echo json_encode($valid);