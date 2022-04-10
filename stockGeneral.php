
<?php 

require_once 'includes/header.php'; 

$rate_total =0;
$benefice_total =0;
$quantite_total =0;
$rateSql = "SELECT sum(quantity_total) AS quantite, sum(rate_total) as rate_total, sum(benefice_total) as benefice_total, sum(prix_achat_total) as prix_total_achat FROM product_stock ";
$rateQuery = $connect->query($rateSql);
while ($rateResult = $rateQuery->fetch_assoc()) {
	$rate_total = $rateResult['rate_total'];
	$benefice_total = $rateResult['benefice_total'];
	$quantite_total = $rateResult['quantite'];
}

$rate_totalSavanor =0;
$benefice_totalSavonor =0;
$quantiteSavonor =0;

$rate_totalLiquids =0;
$benefice_totalLiquids =0;

	####### nombre total de marque 
?>
<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Tableau de Bord</a></li>		  
		  <li class="active">Stock Général</li>
		</ol>

		<div class="row">
			<div class="col-md-4">
		<div class="card">
		  <div class="cardHeader" style="background-color:#245540;">
		    <h1><?php if($quantite_total) {
		    	echo $quantite_total;
		    	} else {
		    		echo '0';
		    		} ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p> <i class="glyphicon glyphicon-ruble"></i> Quantité Général du stock</p>
		  </div>
		</div> <br>

	</div>

		<div class="col-md-4">
		<div class="card">
		  <div class="cardHeader">
		    <h1><?php echo number_format($rate_total,2) ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p><i class="fa fa-usd"></i> Valeur Général du stock</p>
		  </div>
		</div> 
	</div>
	<div class="col-md-4">
		<div class="card">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h1><?php
		    	if($_SESSION["userRole"] == 1 || $_SESSION["userRole"] == 5) {
					echo number_format($benefice_total,2);
				}else{
					echo "";
				}
		    	
		    	?></h1>
		  </div>
		  <div class="cardContainer">
		    <p> <i class="fa fa-usd"></i> Béneficie</p>
		  </div>
		</div> 
	</div>
	<div  class="col-md-12">
		<br><br>
		<div class="col-md-12">
			
			<div class="panel panel-primary">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:white;"  align="center">
					Resume du Stock
					<span class="badge pull pull-right"></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center"><br>
				<table class='table table-bordered table-striped  table-responsive' style="margin: auto;">
					<thead>
						<tr>
							<th class="text-center">Fornisseur</th>
							<th class="text-center">Quantité</th>
							<th class="text-center">Montant</th>
							<th class="text-center">Béneficie</th>
						</tr>
					</thead>
					<?php 
						$brandssql = "SELECT brand_id,brand_name FROM brands";
						$brandssqlQuery = $connect->query($brandssql);

						while ($brandsRestlQt = $brandssqlQuery->fetch_assoc()) {
							$rateSql = "SELECT sum(quantity_total) AS quantite, sum(rate_total) as rate_total, sum(benefice_total) as benefice_total, sum(prix_achat_total) as prix_total_achat FROM product_stock    INNER JOIN product ON product.product_id = product_stock.product_id WHERE brand_id = ".$brandsRestlQt["brand_id"];
							$rateQuery = $connect->query($rateSql);
							while ($rateResult = $rateQuery->fetch_assoc()) {?>

					<tbody>
						<tr>
							<td class="text-left"><?php echo $brandsRestlQt["brand_name"]; ?></td>
							<td class="text-right"><?php echo  $rateResult['quantite'];?></td>
							<td class="text-right"><?php echo number_format($rate_totalSavanor = $rateResult['rate_total'],2);?></td>
							<td class="text-right"><?php
								if($_SESSION["userRole"] == 1 || $_SESSION["userRole"] == 5) { echo number_format($rate_totalSavanor = $rateResult['benefice_total'],2);
								}else{
									echo "";
								}
								?>
								
							</td>
						</tr>

						
					</tbody>

					<?php
				}

			}
		    	?>
					
				</table>
			</div>
		</div> <!--/panel-->
		</div> <!--/col-md-4-->
					<div class="col-md-12">

			<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Valeur des stocks par agence </div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

			<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageValeurAgenceTable">
					<thead>
						<tr>						
							<th class="text-center">Nom Agence</th>						
							<th class="text-center">Valeur du Stock</th>
							<th class="text-center">beneficie du stock</th>
						</tr>
					</thead>
				</table>
			</div>

	       
				
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel --> <!--/panel-->
		</div> <!--/col-md-4-->


	</div>
		
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#navProduct').addClass('active');
		$('#navProductStock').addClass('active');

		// manage brand table
		var manageValeurAgenceTable;
	manageValeurAgenceTable = $("#manageValeurAgenceTable").DataTable({
		'order': [],
		'ajax': 'php_action/fetchAgenceProduit.php',
		"columnDefs":[  
                {  
                    "targets":[0],  
                    "orderable":false,    
                },  
           ],
	});

});
</script>