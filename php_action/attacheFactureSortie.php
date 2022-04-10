<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST) {




$id_sortie = $_POST['id_sortie'];
$SERVERFILEPATH = '../assests/images/sortie/';
if (!file_exists($SERVERFILEPATH)) {
    mkdir($SERVERFILEPATH);
 }

	$type = explode('.', $_FILES['Fichier_1']['name']);
	$type = $type[count($type)-1];		
	$url = $SERVERFILEPATH.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG','PDF', 'pdf','docx'))) {
		if(is_uploaded_file($_FILES['Fichier_1']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['Fichier_1']['tmp_name'], $url)) {

				$sql = "UPDATE bon_sortie_paye SET pieceFacture = '$url' WHERE id_bonSortie = $id_sortie";				

				if($connect->query($sql) === TRUE) {									
					$valid['success'] = true;
					$valid['messages'] = "Mise a jour du bordereau";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Erreur de  Mise a jour du bordereau";
				}
			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 


 
		
	 
	$connect->close();

	echo json_encode($valid);
 
} // /if $_POST