<?php 	

require_once 'core.php';

$id_sous_compte = $_POST['id_sous_compte'];

$sql = "SELECT id_sous_compte,  code_sous_compte, libelle_sous_compte, id_compte_principal, comptabilite_sous_compte.id_compte_principal, comptabilite_sous_compte.status, comptabilite_sous_compte.user_add, comptabilite_sous_compte.date_add FROM comptabilite_sous_compte 

WHERE id_sous_compte = $id_sous_compte ";
$result = $connect->query($sql);
$row ="";
$output ="";
$classe ="";
if($result->num_rows > 0) { 
 $row = $result->fetch_array();
 $id_compte_principal = $row["id_compte_principal"];

 $compte = "SELECT  id_classe,id_compte_principal,code_compte ,libelle_compte
		FROM comptabilite_compte_principal 
		WHERE id_compte_principal = $id_compte_principal ";
		$resultCompte = $connect->query($compte);

	 	/*$output .= '<option value="">~~SELECT~~</option>';
		while ($rowCompte = $resultCompte->fetch_array() ) {
		$output .=  "<option value='".$rowCompte['id_compte_principal']."' id='id_compte".$rowCompte['id_compte_principal']."'>".$rowCompte['code_compte']."-".$rowCompte['libelle_compte']." </option>";
	}*/

	$classe = $resultCompte->fetch_array();
	//$row +=$output;
	$row +=$classe;

} // if num_rows

$connect->close();

echo json_encode($row);

?>