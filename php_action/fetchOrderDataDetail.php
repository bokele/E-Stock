<?php 	

require_once 'core.php';

$orderId = $_POST['orderId'];

$sql = "SELECT order_date,  nom_client, prenom_client, sub_total, vat, total_amount, discount, grand_total, paid, due, numeroFacture, adresse_client, nif_client, client_tva,telephone_client FROM orders INNER JOIN client ON id_client = client_id WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate = new DateTime( $orderData[0]);
$clientName = $orderData[1]." ".$orderData[2];
$clientContact = $orderData[14]; 
$subTotal = $orderData[3];
$vat = $orderData[4];
$totalAmount = $orderData[5]; 
$discount = $orderData[6];
$grandTotal = $orderData[7];
$paid = $orderData[8];
$due = $orderData[9];



$numeroFacture = $orderData[10];
$client_residence = $orderData[11];
$client_nif = $orderData[12];
$client_tva = $orderData[13];

if ($client_tva = 0) {
	$client_tva_reponse = "Oui";
}else{
	$client_tva_reponse = "Non";
}


$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
product.product_name FROM order_item
	INNER JOIN product ON order_item.product_id = product.product_id 
 WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

 $table = '
 <table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" cellspacing="0" cellpadding="20" width="100%">
	<thead>
		
		<tr>
			<th colspan="5">

				<center>
					<center>Numéro de la facture : '.$numeroFacture.'</center>
					Date : '.$orderDate->format('d/m/Y').'
					<center>Nom du Client : '.$clientName.'</center>
					Téléphone : '.$clientContact.'<br/>
					NIF : '.$client_nif.'<br/>
					Assujetti à la TVA : '.$client_tva_reponse.'
				</center>		
			</th>
				
		</tr>		
	</thead>
</table>
<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap " border="" width="100%;" cellpadding="5">

	<tbody>
		<tr>
			<th class="text-center">N°</th>
			<th class="text-center">Produit</th>
			<th class="text-center">PV</th>
			<th class="text-center">Quantité</th>
			<th class="text-center">PV-HTVA</th>
		</tr>';

		$x = 1;
		while($row = $orderItemResult->fetch_array()) {			
						
			$table .= '<tr>
				<td class="text-center">'.$x.'</td>
				<td>'.$row[4].'</td>
				<td class="text-right">'.$row[1].'</td>
				<td class="text-right">'.$row[2].'</td>
				<td class="text-right">'.$row[3].'</td>
			</tr>
			';
		$x++;
		} // /while

		$table .= '
		
		<tr>
		<td colspan="5"></td>
		</tr>
		<tr>
			<th colspan="4" class="text-center">PVT-HTVA</th>
			<th class="text-right">'.$subTotal.'</th>			
		</tr>

		<tr>
			<th colspan="4" class="text-center">VAT (18%)</th>
			<th class="text-right">'.$vat.'</th>			
		</tr>

		<tr>
			<th colspan="4" class="text-center">PVT-TVAC</th>
			<th class="text-right">'.$totalAmount.'</th>			
		</tr>	

		<tr>
			<th colspan="4" class="text-center">Reduiction</th>
			<th class="text-right">'.$discount.'</th>			
		</tr>

		<tr>
			<th colspan="4" class="text-center">TOTAL GENERAL</th>
			<th class="text-right">'.$grandTotal.'</th>			
		</tr>

		<tr>
			<th colspan="4" class="text-center">PAYE</th>
			<th class="text-right">'.$paid.'</th>			
		</tr>

		<tr>
			<th colspan="4" class="text-center">RESTE A PAYE</th>
			<th class="text-right" bgcolor="red" style="text-color: red;">'.$due.'</th>			
		</tr>
	</tbody>
</table>

 ';


$connect->close();
echo json_encode($table);
