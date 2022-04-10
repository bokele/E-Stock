<?php 	

require_once 'core.php';

$productId = $_POST['productId'];

$sql = "SELECT product.product_id, product.product_name, product.product_image, product.brand_id,
 		product.categories_id, product.rate,  product.active, product.status, 
 		brands.brand_name, categories.categories_name, product.prix_achat, product.benefice, product.produit_pieceCarton, product.produit_tva, product.id_user, product.date_add,users.username, rateTva FROM product 
		INNER JOIN brands ON product.brand_id = brands.brand_id 
		INNER JOIN categories ON product.categories_id = categories.categories_id  
		INNER JOIN users ON users.user_id = product.id_user 
		WHERE product.status = 1 AND product.product_id = $productId";

$productResult = $connect->query($sql);
$productData = $productResult->fetch_array();


$product_name 			= $productData[1];
$product_image 			= $productData[2];
$rate 					= $productData[5] + $productData["rateTva"]; 
$brand_name 			= $productData[8];
$categories_name 		= $productData[9];
$prix_achat 			= $productData[10]; 

$benefice 				= $productData[11];
$produit_pieceCarton 	= $productData[12]; 
$produit_tva 			= $productData[13]; 

$user_add 				= $productData[16];
$date_add 				= new DateTime( $productData[15]);

	$tva ="";
 	if ($produit_tva == 1) {
 		$tva = "<label class='label label-primary'>Oui</label>";
 	}else{
 		$tva = "<label class='label label-danger'>Non</label>";
 	}


 $table = '

<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" border="" width="100%;" cellpadding="5">

	<tbody>
		<tr>
			<th>TVA</th>
			<td>'.$tva .'</td>
		</tr>
		<tr>
			<th>Produit</th>
			<td>'.$product_name .'</td>
		</tr>
		<tr>
			<th>Pieces/Cartons </th>
			<td>'.$produit_pieceCarton.'</td>
		</tr>
		<tr>
			<th>Prix Achat</th>
			<td>'.$prix_achat.'</td>
		</tr>
		<tr>
			<th>Prix Vente</th>
			<td>'.$rate .'</td>
		</tr>
		<tr>
			<th>Fournisseur</th>
			<td>'.$brand_name.'</td>
		</tr>
		<tr>
			<th>Categorie</th>
			<td>'.$categories_name.'</td>
		</tr>
		<tr>
			<th>Enregistre par</th>
			<td>'.$user_add.'</td>
		</tr>
		<tr>
			<th>Date d\'enregistrement</th>
			<td>'.$date_add ->format("m/d/Y").'</td>
		</tr>
	
	</tbody>
</table>

 ';

  $table .= "<div align='center'><img class='img-round' src='stock/".$product_image."' style='height:150px; width:160px;'  /></div>";




$connect->close();
echo json_encode($table);