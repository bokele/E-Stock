<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST['id_commande']) {


$id_commande = $_POST['id_commande'];
$SERVERFILEPATHL = '../assests/images/bordereauCommnade/';
if (!file_exists($SERVERFILEPATHL)) {
    mkdir($SERVERFILEPATHL);
}

 $SERVERFILEPATH = '../assests/images/livraison/';
if (!file_exists($SERVERFILEPATH)) {
    mkdir($SERVERFILEPATH);
}


$fichier2 = $_FILES['Fichier_2']['name'];
if ($fichier2 !="") {
					$type2 = explode('.', $_FILES['Fichier_2']['name']);
				$type2 = $type2[count($type2)-1];
				$url2 = $SERVERFILEPATHL.uniqid(rand()).'.'.$type2;
				if(in_array($type2, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG','PDF', 'pdf','docx'))) {
				if(is_uploaded_file($_FILES['Fichier_2']['tmp_name'])) {			
				if(move_uploaded_file($_FILES['Fichier_2']['tmp_name'], $url2)) {

					

				$sqlFacture = "UPDATE boncommande_paye SET pieceFacture_boncommande = '$url2' WHERE id_boncommande = '$id_commande'";			

				if($connect->query($sqlFacture) === TRUE) {	

					$valid['success'] = true;
					$valid['messages'] = "Mise a jour du bordereau ou facture";	
				} else {
					$valid['success'] = false;
					$valid['messages']= "Erreur de  Mise a jour du bordereau";
				}
			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array
}


$fichier1 = $_FILES['Fichier_1']['name'];
if ($fichier1 !="") {
	$type = explode('.', $_FILES['Fichier_1']['name']);
	$type = $type[count($type)-1];		
	$url = $SERVERFILEPATH.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG','PDF', 'pdf','docx'))) {
		if(is_uploaded_file($_FILES['Fichier_1']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['Fichier_1']['tmp_name'], $url)) {

				$sql = "UPDATE boncommande SET status = 2, pieceBonLivraisionCommande = '$url' WHERE id_commande = $id_commande";	

				if($connect->query($sql) === TRUE) {									
					$valid['success'] = true;
					$valid['messages'] .= " , Mise a jour du bon de livraison";	
				} else {
					$valid['success'] = false;
					$valid['messages'] .= ",  Erreur de  Mise a jour du bon de livraison ";
				}
			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 
}
	

	 
	$connect->close();


 
} // /if $_POST
header('location: http://localhost/stock/commande.php');
echo json_encode($valid);