<?php 	

require_once 'core.php';


$output = '';
if($_POST["action"] == "factureTva")
{
	
	$tvaOuiNon1 = substr($_POST["tvaOuiNon1"], 0,1);
	$societe = substr($_POST["tvaOuiNon1"], -1,1);

	if (!isset($_POST["agence"])) {
		$agence = $_SESSION["agenceId"];
	}else{
		$agence = $_POST["agence"];
	}
	
	$sql = "SELECT produit_agence.product_id, product_name FROM produit_agence INNER JOIN product ON product.product_id = produit_agence.product_id WHERE status = 1 AND active = 1   AND produit_tva = $tvaOuiNon1 AND brand_id = $societe AND id_agence_arrive = $agence ORDER BY product_name";
	$result = $connect->query($sql);

	$output .= '<option value="">~~SELECT~~</option>';
		while ($row = $result->fetch_array() ) {
		$output .=  "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."'>".$row['product_name']." </option>";
	}


}

else if($_POST["action"] == "id_marque")
{
	$id_marque = $_POST["id_marque"];
	$output = '';
	$sql = "SELECT product_id, product_name FROM product WHERE status = 1 AND active = 1 AND brand_id = {$id_marque}  ORDER BY product_name";
	$result = $connect->query($sql);

	$output .= '<option value="">~~SELECT~~</option>';
		while ($row = $result->fetch_array() ) {

		$output .=  "<option value='".$row['product_id']."' id='id_produit".$row['product_id']."'>".mysqli_real_escape_string($connect,$row['product_name'])."</option>";
	}


}

else if($_POST["action"] == "id_classe")
{
	$id_classe = $_POST["id_classe"];
	$sql = "SELECT id_compte_principal,code_compte, libelle_compte FROM comptabilite_compte_principal WHERE id_classe = '$id_classe' AND status = 1  ORDER BY code_compte ASC ";
	$result = $connect->query($sql);

	$output .= '<option value="">~~SELECT~~</option>';
		while ($row = $result->fetch_array() ) {
		$output .=  "<option value='".$row['id_compte_principal']."' id='id_compte".$row['id_compte_principal']."'>".$row['code_compte']."-".$row['libelle_compte']." </option>";
	}


}

else if($_POST["action"] == "id_Compte")
{
	$id_Compte = $_POST["id_Compte"];
	$sql = "SELECT id_sous_compte, code_sous_compte,libelle_sous_compte FROM comptabilite_sous_compte WHERE id_compte_principal = '$id_Compte' AND status = 1  ORDER BY code_sous_compte ASC ";
	$result = $connect->query($sql);

	$output .= '<option value="">~~SELECT~~</option>';
		while ($row = $result->fetch_array() ) {
		$output .=  "<option value='".$row['id_sous_compte']."' id='id_compte".$row['id_sous_compte']."'>".$row['code_sous_compte']."-".$row['libelle_sous_compte']." </option>";
	}


}
else if($_POST["action"] == "categoryName")
{
	$categoryName = $_POST["categoryName"];
$sql = "SELECT product_id, product_name FROM product WHERE status = 1 AND active = 1  AND quantity != 0  AND categories_id = $categoryName  ORDER BY product_name";
	$result = $connect->query($sql);

	$output .= '<option value="">~~SELECT~~</option>';
		while ($row = $result->fetch_array() ) {
		$output .=  "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."'>".$row['product_name']." </option>";
	}


}

	$connect->close();
echo json_encode($output);

