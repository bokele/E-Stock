<?php 	

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {	

  $id_Compte 					= $_POST['id_Compte'];
  $id_sous_compte 		= $_POST['id_sous_compte'];  
  $paymentType        = $_POST['paymentType'];
  $paymentStatus      = $_POST['paymentStatus'];
  $montant        		= $_POST['montant'];
  $observation 		    = $_POST['observation'];
  $id_bonSortie				= $_POST['depensePayementId'];
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


  $sql = "INSERT INTO bon_sortie_paye (id_bonSortie, code_compte, montant, type_paiement, status_paiement, date_paiement, observation, user_add, date_add) 

  VALUES ($id_bonSortie, '$compte',  '$montant',  '$paymentStatus', $paymentType, '$date_paiement', '$observation', '$user_add', '$date_add')";




	if($connect->query($sql) === TRUE) {
		$valid['success'] = true;
		$valid['messages'] = "L'enregistre du paiement se termine avec succès";	

      $sql = "UPDATE bon_sortie SET status_sortie = 2 WHERE id_bonSortie =$id_bonSortie";
      $connect->query($sql);
 
		

	} else {
		$valid['success'] = false;
		$valid['messages'] = "Erreur lors de la mise à jour des informations sur la commande ".mysqli_error($connect);
	}

	 
$connect->close();

echo json_encode($valid);
 
} // /if $_POST