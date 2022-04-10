<?php 	

require_once 'core.php';

$productId = $_POST['productId'];

$sql = "SELECT history_id, produit_history.product_id, produit_history.prix_achat, produit_history.prix_vente, produit_history.date_add, pass_quantite, new_quantite, produit_history.id_user, product_name,product.produit_pieceCarton,product.prix_achat,product.rate,product.produit_tva FROM produit_history INNER JOIN product ON produit_history.product_id = product.product_id WHERE produit_history.product_id = $productId";

$stockHistoryResult = $connect->query($sql);
$stockHistoryData = $stockHistoryResult->fetch_array();
$id_user 				= $stockHistoryData[7];
$product_name 			= $stockHistoryData[8]; 
$produit_pieceCarton 	= $stockHistoryData[9];
$produit_tva 			= $stockHistoryData[12];

$tva ="";
if ($produit_tva == 1) {
	$tva = "<label class='label label-primary'>Oui</label>";
}else{
	$tva = "<label class='label label-danger'>Non</label>";
}

/*$commandeItemSql = "SELECT boncommande_item.id_commande, boncommande_item.quantite, boncommande_item.prix_achat, boncommande_item.prix_achat_total,
product.product_name FROM boncommande_item
	INNER JOIN product ON boncommande_item.id_produit = product.product_id 
 WHERE boncommande_item.id_commande = $id_commande";
$commandeItemResult = $connect->query($commandeItemSql);*/

 $table = '
 <table  class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		
		<tr>
			<th colspan="5">

				<center>
					<center>Produit : <span class="text-danger">'.$product_name.'</span></center>
					Pièce : '.$produit_pieceCarton.'
					<center>TVA : '.$tva.'</center>
				</center>		
			</th>
				
		</tr>		
	</thead>
</table>
<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" border="" width="100%;" cellpadding="5">

	<tbody>
		<tr>
			<th>N°</th>
			<th>Date</th>
			<th>Ancien Qt</th>
			<th>Nouveau Qt</th>
			<th>Total Qt</th>

			<th>Ancien Achat</th>
			<th>Nouveau Achat</th>
			<th>Total Achat</th>

			<th>Ancien Vente</th>
			<th>Nouveau Vente</th>
			<th>Total Vente</th>

		</tr>';

		$sql = "SELECT history_id, produit_history.product_id, produit_history.prix_achat, produit_history.prix_vente, produit_history.date_add, pass_quantite, new_quantite, produit_history.id_user, product_name,product.produit_pieceCarton,product.prix_achat,product.rate,product.produit_tva FROM produit_history INNER JOIN product ON produit_history.product_id = product.product_id WHERE produit_history.product_id = $productId";

		$stockHistoryResult = $connect->query($sql);

		$x = 1;
		while($row = $stockHistoryResult->fetch_array()) {	

			$date_add	 			= new DateTime( $row[4]);
			$historyprix_achat 		= $row[2];
			$historyprix_vente 		= $row[3];
			$pass_quantite		 	= $row[5]; 
			$new_quantite	 		= $row[6];
			$total_quantity 		= $pass_quantite + $new_quantite;
			
			$prix_achat 			= $row[2];
			$prix_vente				= $row[3];
					
						
			$table .= '<tr>
				<td>'.$x.'</td>
				<td>'.$date_add->format("d/m/Y").'</td>
				<td>'.$pass_quantite.'</td>
				<td>'.$new_quantite.'</td>
				<td>'.$total_quantity.'</td>

				<td>'.$pass_quantite*$prix_achat.'</td>
				<td>'.$new_quantite*$prix_achat.'</td>
				<td>'.$total_quantity*$prix_achat.'</td>

				<td>'.$pass_quantite*$prix_vente.'</td>
				<td>'.$new_quantite*$prix_vente.'</td>
				<td>'.$total_quantity*$prix_vente.'</td>
			</tr>
			';

			
		$x++;
		} // /while

		
	$table .= '</tbody>
</table>
 ';


$connect->close();
echo json_encode($table);