<table border="1" cellspacing="0" cellpadding="0" style="width:100%;">
				<thead>
				<tr>
					<th colspan="4">Listes des Commandes des Produits Liquids Avac TVA</th>
				</tr>
				<tr>
					<th>Order Date</th>
					<th>Client Name</th>
					<th>Contact</th>
					<th>Grand Total</th>
				</tr>

			</thead>
			<thbody>

				<tr>';
				<?php $totalAmount = "";
				while ($result = $query->fetch_assoc()) {
					?>
					<tr>
						<td><center><?php echo  $result['order_date']?></center></td>
						<td><center><?php echo $result['client_name']?></center></td>
						<td><center><?php echo $result['client_contact']?></center></td>
						<td><center><?php echo $result['grand_total']?></center></td>
					</tr>';	
					<?php $totalAmount += $result['grand_total']; 
				}
			?>
				</tr>

				<tr>
					<td colspan="3"><center>Total Amount</center></td>
					<td><center></tr> <?php echo $totalAmount?></center></td>
				</tr>
			</table>