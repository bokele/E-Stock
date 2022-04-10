<?php 	

require_once 'core.php';

$valid['success'] = array('success' => false, 'messages' => array());

if($_POST['depense_id']) {

$depense_id = $_POST['depense_id'];
$SERVERFILEPATH = '../assests/images/bordereau/';
if (!file_exists($SERVERFILEPATH)) {
    mkdir($SERVERFILEPATH);
 }

	$type = explode('.', $_FILES['Fichier_1']['name']);
	$type = $type[count($type)-1];		
	$url = $SERVERFILEPATH.uniqid(rand()).'.'.$type;
	if(in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG','PDF', 'pdf','docx','doc'))) {
		if(is_uploaded_file($_FILES['Fichier_1']['tmp_name'])) {			
			if(move_uploaded_file($_FILES['Fichier_1']['tmp_name'], $url)) {


				$sql = "UPDATE depense_paye SET pieceFacture = '$url' WHERE id_depense = $depense_id";				

				if($connect->query($sql) === TRUE) {									
					$valid['success'] = true;
					$valid['messages'] = "Mise a jour du bordereau";	
				} else {
					$valid['success'] = false;
					$valid['messages'] = "Erreur de  Mise a jour du bordereau".mysqli_error($connect);
				}
			}	else {
				return false;
			}	// /else	
		} // if
	} // if in_array 

	$connect->close();
 
} // /if $_PO

//header('location: http://localhost/stock/depense.php');
echo json_encode($valid);