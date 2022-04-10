<?php 	

require_once 'core.php';

if($_POST["action"] == "brandName")
{
	$brandName = $_POST["brandName"];
	$sql = "SELECT categories_id, categories_name FROM categories  WHERE categories_status = 1 AND categories_active = 1 AND idBrand = $brandName  ORDER BY categories_name ASC";
	$result = $connect->query($sql);
	$output = '';
	$output .= '<option value="">~~SELECT~~</option>';
		while ($row = $result->fetch_array() ) {
		$output .=  "<option value='".$row['categories_id']."' id='changeProduct".$row['categories_id']."'>".$row['categories_name']." </option>";
	}

	
}
else if($_POST["action"] == "categoryName")
{
	$categoryName = $_POST["categoryName"];
	$sql = "SELECT product_id, product_name FROM product  WHERE status = 1 AND active = 1 AND categories_id = $categoryName  ORDER BY product_name ASC";
	$result = $connect->query($sql);
	$output = '';
	$output .= '<option value="">~~SELECT~~</option>';
		while ($row = $result->fetch_array() ) {
		$output .=  "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."'>".$row['product_name']." </option>";
	}

	
}
else if($_POST["action"] == "produitName")
{


	$produitName = $_POST["produitName"];
	$id_agence = $_POST["id_agence"];
	$sql = "SELECT produitAgence_id,quantity_total_agence, rate, prix_achat, produit_pieceCarton, product_image FROM produit_agence INNER JOIN product ON produit_agence.product_id = product.product_id  WHERE produit_agence.product_id = $produitName AND (produit_agence.id_agence = $id_agence OR produit_agence.id_agence_arrive = $id_agence )";
	$result = $connect->query($sql);
	$row = $result->fetch_array();
	$output = $row;
	
	

	
}
$connect->close();
echo json_encode($output);

?>