<?php 
require_once 'php_action/db_connect.php'; 
require_once 'includes/header.php';

$agence = $_SESSION["agenceId"]; 

if($_GET['o'] == 'add') { 
// add order
	echo "<div class='div-request div-hide'>add</div>";
} else if($_GET['o'] == 'manord') { 
	echo "<div class='div-request div-hide'>manord</div>";
} else if($_GET['o'] == 'editOrd') { 
	echo "<div class='div-request div-hide'>editOrd</div>";
} // /else manage order

?>

<ol class="breadcrumb">
  <li><a href="dashboard.php">Tableau de Bord</a></li>
  <li>Commandes</li>
  <li class="active">
  	<?php if($_GET['o'] == 'add') { ?>
  		Ajoute une commande
		<?php } else if($_GET['o'] == 'manord') { ?>
			Gestion des Commandes
		<?php } // /else manage order ?>
  </li>
</ol>


<div class="panel-body">
			
		<?php if($_GET['o'] == 'add') { 
			// add order
			?>			

			<div class="success-messages"></div> <!--/success-messages-->
			<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading">

					<h4>
						<i class='fa fa-plus'></i>
						<?php if($_GET['o'] == 'add') {
							echo "Créer une nouvelle facture";
						} else if($_GET['o'] == 'manord') { 
							echo "Gestion des factures";
						} else if($_GET['o'] == 'editOrd') { 
							echo "Modifier une facture";
						}
						?>	
					</h4>
				</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">	

  		<form class="form-horizontal" role="form" method="POST" action="php_action/createOrder.php" id="createOrderForm">
  			<div class="col-md-12"> 
  			<div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Facture Avec TVA</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="factureTva" id="factureTva">
			      	<option value="">~~SELECT~~</option>
		      		<option value="11" >Oui - Savonor</option>
		      		<option value="21">Non - Savonor</option>
		      		<option value="12">Oui - Liquids</option>
		      		<option value="22">Non - Liquids</option>
			      </select>
			    </div>
			</div> <!--/form-group-->
		</div>
  			<div class="col-md-6"> 
  				<div class="form-group">
			    <label for="orderDate" class="col-sm-5 control-label">Date</label>
			    <div class="col-sm-7">
			      <input type="text" class="form-control" id="orderDate" name="orderDate" autocomplete="off" />
			      <input type="hidden" class="form-control" id="agence" name="agence" value="<?php echo $agence?>" autocomplete="off" />
			    </div>
			  </div> <!--/form-group-->
			  </div> <!--/form-group-->	
	
  			<div class="col-md-6">
  				<div class="form-group">
			    <label for="clientContact" class="col-sm-5 control-label">Nom du client</label>
			    <div class="col-sm-7">
			      <select class="form-control" name="clientName" id="clientName">
			      	<option value="">~~SELECT~~</option>
			      	<?php 
				      	$sql = "SELECT id_client, nom_client, prenom_client FROM client WHERE status_client = 1  ORDER BY nom_client ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]." ".$row[2]."</option>";
								} // while
								
				      	?>
			      
				      </select>
			    </div>
			  </div> <!--/form-group-->	
			  
  			</div>
			 
			  
	 
			   		  
  			<div class="col-md-12 table-responsive">
			  <table class="table table-hover table-striped table-outline mb-0 nowrap" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;text-align: center;">Produit</th>
			  			<th style="width:15%;text-align: center;">Quantité</th>
			  			<th style="width:20%;text-align: center;">P.U</th>			  			
			  			<th style="width:15%;text-align: center;">THTVA</th>			  			
			  			<th style="width:10%;text-align: center;"></th>
			  			<th style="width:10%;text-align: center;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php
			  		$arrayNumber = 0;
			  		for($x = 1; $x < 4; $x++) { ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">

			  				<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  					<script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#factureTva', function(){
			  								factureTva = $(this).val();
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var tvaOuiNon1 = $(this).val();

										   		var agence = "<?php echo $agence ?>";
										   		var result = '';
										   		if(action == "factureTva")
											   {
											    result ="productName<?php echo $x; ?>";
											   }

											   	$.ajax({
													url:"php_action/fetchProductData.php",
											      	method:"POST",
													data:{tvaOuiNon1:tvaOuiNon1,action : action, agence : agence },
													dataType:"json",
													success:function(data){
														$('#'+result).html(data);
													}

												});
											}
			  							});
			  							
			  						});
			  						
			  					</script>

			  						<option value="">~~SELECT~~</option>
			  						<?php
			  						$factureTva = "<script type='text/javascript'> document.write(factureTva); </script>";
			  							$productSql = "SELECT * FROM product ORDER BY product_name";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {	
			  								
			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."'>".$row['product_name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
		  						<input type="hidden" name="tvaOuiNon[]" id="tvaOuiNon<?php echo $x; ?>" autocomplete="off" class="form-control" min="1" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" />	

			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />			  					
			  					<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" />	
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />

			  				</td>
			  			
			  				<td>

			  					<button class="btn btn-danger removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)" ><i class="glyphicon glyphicon-trash  "></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
			  		} // /for
			  		?>
			  	</tbody>			  	
			  </table>
			</div>
			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">PV-THTVA</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="vat" class="col-sm-3 control-label">TVA 18%</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vat" name="vat" disabled="true" />
				      <input type="hidden" class="form-control" id="vatValue" name="vatValue" />
				      <input type="hidden" class="form-control" id="tvaOuiNonTotal" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">PV-TVAC</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true"/>
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Réduction</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="grandTotal" class="col-sm-3 control-label">Total Général</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" />
				      <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" />
				    </div>
				  </div> <!--/form-group-->			  		  
			  </div> <!--/col-md-6-->

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Montant payé</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Reste à payer</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" />
				    </div>
				  </div> <!--/form-group-->		
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Type de payement</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentType" id="paymentType">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Cheque</option>
				      	<option value="2">Cash</option>
				      	<option value="3">Credit Card</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Status de payement</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentStatus" id="paymentStatus">
				      	<option value="">~~SELECT~~</option>
			      		<option value="1">Payement Total</option>
			      		<option value="2">Avance</option>
			      		<option value="3">Credit</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
			  </div> <!--/col-md-6-->


			  <div class="form-group submitButtonFooter " align="center">
			    <div class="col-sm-offset-2 col-sm-10">
			    <button type="button" class="btn btn-info" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="fa fa-plus addRowBtn"></i> Ajoute un autre produit </button>

			      <button type="reset" class="btn btn-danger" onclick="resetOrderForm()"><i class="fa fa-eraser"></i> ReInitialise</button>

			      <button type="submit" id="createOrderBtn" data-loading-text="Loading..." class="btn btn-primary"><i class="fa fa-save"></i> Enregistre le Payement</button>
			    </div>
			  </div>
			</form>
			</div>
	</div>
		<?php } else if($_GET['o'] == 'manord') { 
			// manage order
			?>

			<div id="success-messages"></div>
			<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading">

					<h4>
						<i class='fa fa-list'></i>
						<?php if($_GET['o'] == 'add') {
							echo "Ajoute une commande";
						} else if($_GET['o'] == 'manord') { 
							echo "Gestion des Commandes";
						} else if($_GET['o'] == 'editOrd') { 
							echo "Modifier une Commande";
						}
						?>	
					</h4>
				</div>
			</div> <!-- /panel-heading -->
			<!--  ---------------------------- tableau d'affichage ----------------------- -->
				<div class="panel-body">
					<div class="col-md-12 table-responsive">
						<table class="table text-center table-responsive table-bordered table-hover " id="manageOrderTable">
							<thead>
								<tr>
									<th>#</th>
									<th>N Fact.</th>
									<th>Date</th>
									<th>N. Client</th>
									<th>T. Item</th>
									<th>Qté</th>
									<th>M. Payé</th>
									<th>Status</th>
									<th>Option</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
		</div>

		<?php 
		// /else manage order
		} else if($_GET['o'] == 'editOrd') {
			// get order
			?>
			
			<div class="success-messages"></div> <!--/success-messages-->
			<div class="panel panel-warning">
			<div class="panel-heading">
				<div class="page-heading">

					<h4>
						<i class='fa fa-pencil'></i>
						<?php if($_GET['o'] == 'add') {
							echo "Ajoute une commande";
						} else if($_GET['o'] == 'manord') { 
							echo "Gestion des Commandes";
						} else if($_GET['o'] == 'editOrd') { 
							echo "Modifier une Commande";
						}
						?>	
					</h4>
				</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">
  		<form class="form-horizontal" method="POST" action="php_action/editOrder.php" id="editOrderForm">
  		
  			<?php 
  				$orderId = $_GET['i'];
  			$sql = "SELECT orders.order_id, orders.order_date, orders.client_id, client.nom_client, orders.sub_total, orders.vat, orders.total_amount, orders.discount, orders.grand_total, orders.paid, orders.due, orders.payment_type, orders.payment_status,client.nif_client,client.client_tva,client.adresse_client,orders.factureTva FROM orders INNER JOIN client ON id_client = client_id 	
					WHERE orders.order_id = {$orderId}";

				$result = $connect->query($sql);
				$data = $result->fetch_row();

  			?>
  				<div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Facture Avec TVA</label>
			    <div class="col-sm-8">
			      <select class="form-control" name="factureTva" id="factureTva" ">
			      	<option value="">~~SELECT~~</option>
		      		<option value="11" <?php if($data[16] == 11) {
				      		echo "selected";
				      	} ?> >Oui - Savonor</option>
		      		<option value="21"<?php if($data[16] == 21) {
				      		echo "selected";
				      	} ?>>Non - Savonor</option>
		      		<option value="12"<?php if($data[16] == 12) {
				      		echo "selected";
				      	} ?>>Oui - Liquids</option>
		      		<option value="22" <?php if($data[16] == 22) {
				      		echo "selected";
				      	} ?>>Non - Liquids</option>
			      </select>
			  </div>
			</div>
			  	<div class="col-md-6"> 
			  		<div class="form-group">
			    <label for="orderDate" class="col-sm-5 control-label">Date de la Commande</label>
			    <div class="col-sm-7">
			      <input type="text" class="form-control" id="orderDate" name="orderDate" value="<?php echo $data[1] ?>" autocomplete="off" />
			    </div>
			  </div> <!--/form-group-->
			 

			</div><!--/div form first-->
  			<div class="col-md-6">
  				 <div class="form-group">
			    <label for="clientName" class="col-sm-5 control-label">Nom du Client</label>
			    <div class="col-sm-7">
			    	<select class="form-control" name="clientName" id="clientName" >
			      	<option value="">~~SELECT~~</option>
			      	<?php 
				      	$sql = "SELECT id_client, nom_client, prenom_client FROM client WHERE status_client = 1  ORDER BY nom_client ASC";
								$result = $connect->query($sql);

								

								while($row = $result->fetch_array()) {
									$selected = "";
			  								if($data[2] == $row[0]) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}
									echo "<option value='".$row[0]."' ".$selected.">".$row[1]." ".$row[2]."</option>";
								} // while
								
				      	?>
			      
				      </select>
			      
			    </div>
			  </div> <!--/form-group-->
  			</div>


			  <table class="table" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;text-align: center;" algn="center">Produit</th>
			  			<th style="width:15%;text-align: center;">Quantite</th>
			  			<th style="width:20%;text-align: center;">P.U</th>			  			
			  			<th style="width:15%;text-align: center;">PV-HTVA</th>			  			
			  			<th style="width:10%;text-align: center;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php

			  		$orderItemSql = "SELECT order_item.order_item_id, order_item.order_id, order_item.product_id, order_item.quantity, order_item.rate, order_item.total FROM order_item INNER JOIN orders ON orders.order_id = order_item.order_id  WHERE  order_item.order_id = {$orderId}";
						$orderItemResult = $connect->query($orderItemSql);
						// $orderItemData = $orderItemResult->fetch_all();						
						
						// print_r($orderItemData);
			  		$arrayNumber = 0;
			  		// for($x = 1; $x <= count($orderItemData); $x++) {
			  		$x = 1;
			  		while($orderItemData = $orderItemResult->fetch_array()) { 
			  			// print_r($orderItemData); ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">
			  						<script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#factureTva', function(){
			  								factureTva = $(this).val();
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var tvaOuiNon1 = $(this).val();
										   		var result = '';
										   		if(action == "factureTva")
											   {
											    result ="productName<?php echo $x; ?>";
											   }

											   	$.ajax({
													url:"php_action/fetchProductData.php",
											      	method:"POST",
													data:{tvaOuiNon1:tvaOuiNon1,action : action},
													dataType:"json",
													success:function(data){
														$('#'+result).html(data);
													}

												});
											}
			  							});
			  							
			  						});
			  						
			  					</script>
			  					<select class="form-control" name="productName[]" id="productName<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  						<option value="">~~SELECT~~</option>
			  						<?php
			  							$productSql = "SELECT * FROM product   WHERE active = 1 AND status = 1";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['product_id'] == $orderItemData['product_id']) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}

			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
										 	} // /while 

			  						?>
		  						</select>
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  						

			  					<input type="number" name="quantity[]" id="quantity<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $orderItemData['quantity']; ?>" />		  					
			  				</td>
			  				<td style="padding-left:20px;">
			  					<div class="form-group">
			  						<input type="text" name="rate[]" id="rate<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />			  					
			  						<input type="hidden" name="rateValue[]" id="rateValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['rate']; ?>" />
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="text" name="total[]" id="total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $orderItemData['total']; ?>"/>			  					
			  					<input type="hidden" name="totalValue[]" id="totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $orderItemData['total']; ?>"/>			  					
			  				</td>
			  				<td>

			  					<button class="btn btn-danger removeProductRowBtn" type="button" id="removeProductRowBtn" onclick="removeProductRow(<?php echo $x; ?>)"><i class="fa fa-trash"></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
		  			$x++;
			  		} // /for
			  		?>
			  	</tbody>			  	
			  </table>

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="subTotal" class="col-sm-3 control-label">PV-HTVQ</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="subTotal" name="subTotal" disabled="true" value="<?php echo $data[4] ?>" />
				      <input type="hidden" class="form-control" id="subTotalValue" name="subTotalValue" value="<?php echo $data[4] ?>" />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="vat" class="col-sm-3 control-label">TVA 18%</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="vat" name="vat" disabled="true" value="<?php echo $data[5] ?>"  />
				      <input type="hidden" class="form-control" id="vatValue" name="vatValue" value="<?php echo $data[5] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="totalAmount" class="col-sm-3 control-label">PV-TVAC</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="totalAmount" name="totalAmount" disabled="true" value="<?php echo $data[6] ?>" />
				      <input type="hidden" class="form-control" id="totalAmountValue" name="totalAmountValue" value="<?php echo $data[6] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="discount" class="col-sm-3 control-label">Rédiction</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="discount" name="discount" onkeyup="discountFunc()" autocomplete="off" value="<?php echo $data[7] ?>" />
				    </div>
				  </div> <!--/form-group-->	
				  <div class="form-group">
				    <label for="grandTotal" class="col-sm-3 control-label"> Total Général</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="grandTotal" name="grandTotal" disabled="true" value="<?php echo $data[8] ?>"  />
				      <input type="hidden" class="form-control" id="grandTotalValue" name="grandTotalValue" value="<?php echo $data[8] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  		  
			  </div> <!--/col-md-6-->

			  <div class="col-md-6">
			  	<div class="form-group">
				    <label for="paid" class="col-sm-3 control-label">Montant payé</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="paid" name="paid" autocomplete="off" onkeyup="paidAmount()" value="<?php echo $data[9] ?>"  />
				    </div>
				  </div> <!--/form-group-->			  
				  <div class="form-group">
				    <label for="due" class="col-sm-3 control-label">Reste à payer</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="due" name="due" disabled="true" value="<?php echo $data[10] ?>"  />
				      <input type="hidden" class="form-control" id="dueValue" name="dueValue" value="<?php echo $data[10] ?>"  />
				    </div>
				  </div> <!--/form-group-->		
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Type de Payement</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentType" id="paymentType" >
				      	<option value="">~~SELECT~~</option>
				      	<option value="1" <?php if($data[11] == 1) {
				      		echo "selected";
				      	} ?> >Cheque</option>
				      	<option value="2" <?php if($data[11] == 2) {
				      		echo "selected";
				      	} ?>  >Cash</option>
				      	<option value="3" <?php if($data[11] == 3) {
				      		echo "selected";
				      	} ?> >Credit Card</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
				  <div class="form-group">
				    <label for="clientContact" class="col-sm-3 control-label">Status de Payement</label>
				    <div class="col-sm-9">
				      <select class="form-control" name="paymentStatus" id="paymentStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1" <?php if($data[12] == 1) {
				      		echo "selected";
				      	} ?>  >Payement Total</option>
				      	<option value="2" <?php if($data[12] == 2) {
				      		echo "selected";
				      	} ?> >Avance</option>
				      	<option value="3" <?php if($data[12] == 3) {
				      		echo "selected";
				      	} ?> >Credit</option>
				      </select>
				    </div>
				  </div> <!--/form-group-->							  
			  </div> <!--/col-md-6-->


			  <div class="form-group editButtonFooter " algn="center">
			    <div class="col-sm-offset-2 col-sm-10">
			    	 <input type="hidden" class="form-control" id="agence" name="agence" value="<?php echo $agence?>" autocomplete="off" />
			    <button type="button" class="btn btn-info" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="fa fa-plus"></i> Ajoute une commande </button>

			    <input type="hidden" name="orderId" id="orderId" value="<?php echo $_GET['i']; ?>" />

			    <button type="submit" id="editOrderBtn" data-loading-text="Loading..." class="btn btn-warning"><i class="fa fa-save"></i> Enregistre</button>
			      
			    </div>
			  </div>
			</form>
</div>
	</div>
			<?php
		} // /get order else  ?>


	</div> <!--/panel-->	
</div> <!--/panel-->	


<!-- edit order -->
<div class="modal fade" tabindex="-1" role="dialog" id="paymentOrderModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-edit"></i> Modifier le payement Facture No.  <span id="facturenumero"></span></h4>
      </div>      

      <div class="modal-body form-horizontal" style="max-height:500px; overflow:auto;" >

      	<div class="paymentOrderMessages"></div>

      	     	<div class="form-group">
			    <label for="due" class="col-sm-3 control-label">Total Général</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="total" name="" disabled="true" />					
			    </div>
			  </div> <!--/form-group-->			 				 
			  <div class="form-group">
			    <label for="due" class="col-sm-3 control-label">Montant payé</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="due" name="due" disabled="true" />					
			    </div>
			  </div> <!--/form-group-->		
			  <div class="form-group">
			    <label for="due" class="col-sm-3 control-label">Reste à payer</label>
			    <div class="col-sm-4">
			      <input type="text" class="form-control" id="payAmount" name="payAmount" disabled="true" />
			      <input type="hidden" class="form-control" id="payAmountRest" name="payAmountRest"  />	
			      <input type="hidden" class="form-control" id="payRest" name="payRest"  />					
			    </div>
			    	<label for="due" class="col-sm-1 control-label"> Sur </label>
			      <div class="col-sm-4">
			       <input type="text" class="form-control" id="payRestAffiche" name="payRestAffiche"  disabled="true"/>				
			    </div>
			  </div> <!--/form-group-->	
			  <div class="form-group">
			    <div class="col-sm-4">
			  
			     				
			    </div>
			  </div> <!--/form-group-->		
			  <div class="form-group">
			    <label for="payAmount" class="col-sm-3 control-label">Montant payé</label>
			    <div class="col-sm-9">
			      <input type="text" class="form-control" id="montantPaye" name="montantPaye" onkeyup="paidAmountRest()"/>					      
			    </div>
			  </div> <!--/form-group-->		
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Type de Payement</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentType" id="paymentType" >
			      	<option value="">~~SELECT~~</option>
			      	<option value="1">Cheque</option>
			      	<option value="2">Cash</option>
			      	<option value="3">Credit Card</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->							  
			  <div class="form-group">
			    <label for="clientContact" class="col-sm-3 control-label">Status de payement</label>
			    <div class="col-sm-9">
			      <select class="form-control" name="paymentStatus" id="paymentStatus">
			      	<option value="">~~SELECT~~</option>
			      	<option value="1">Payement Total</option>
			      	<option value="2">Avance</option>
			      	<option value="3">Credit</option>
			      </select>
			    </div>
			  </div> <!--/form-group-->							  				  
      	        
      </div> <!--/modal-body-->
      <div class="modal-footer">
      	<button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="updatePaymentOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>	
      </div>           
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /edit order-->

<!-- remove order -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeOrderModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Supprimer la commande Facture No. <span id="facturenumero"></span></h4>
      </div>
      <div class="modal-body">

      	<div class="removeOrderMessages"></div>

        <p>Do you really want to remove ?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeOrderBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove order-->
<!--  ------------------------------modal detail ----------------------------------------->

<div class="modal fade" id="datail_facture_modal" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center btn-info">
        <h5 class="modal-title " id="titre">DETAIL DE LA FACTURE</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
      		
 			<div id="tableDatail"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- --------------------------- fin modal detail --------------------------------------->

<script src="custom/js/order.js"></script>

<?php require_once 'includes/footer.php'; ?>


	