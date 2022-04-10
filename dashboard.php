<?php require_once 'includes/header.php'; ?>

<?php 

$sql = "SELECT * FROM product WHERE status = 1";
$query = $connect->query($sql);
$countProduct = $query->num_rows;

//$orderSql = "SELECT * FROM orders WHERE order_status = 1";
//$orderQuery = $connect->query($orderSql);
//$countOrder = $orderQuery->num_rows;
//revenue
$orderSql = "SELECT * FROM orders  WHERE order_status = 1 and order_date = CURDATE()";
$orderQuery = $connect->query($orderSql);
$countOrder = $orderQuery->num_rows;
$totalRevenue = 0;
while ($orderResult = $orderQuery->fetch_assoc()) {
	$totalRevenue += $orderResult['paid'];
}

/////////  nombre de produit qui rest dans le stock 
$lowStockSql = "SELECT * FROM product_stock WHERE quantity_total <= 10";
$lowStockQuery = $connect->query($lowStockSql);
$countLowStock = $lowStockQuery->num_rows;

////////////// quantite de produit vendu dans une journe
$qtSql = "SELECT * FROM order_item INNER JOIN orders ON orders.order_id = order_item.order_id  WHERE    order_date = CURDATE()";
$qtSqlQuery = $connect->query($qtSql);
$totalQt = 0;
while ($orderResult = $qtSqlQuery->fetch_assoc()) {
	$totalQt += $orderResult['quantity'];
}

///////////// qunatite et prix de vente total de la journe
$payementTotalSql = "SELECT * FROM orders WHERE   order_status = 1 and payment_status = 1 and  order_date = CURDATE()";
$payementTotalSqlQuery = $connect->query($payementTotalSql);
$PayementtotalQt = 0;
$grand_total = 0;
while ($orderResult = $payementTotalSqlQuery->fetch_assoc()) {
	$grand_total += $orderResult['paid'];
}

$payementTotalSql = "SELECT * FROM orders INNER JOIN order_item ON orders.order_id = order_item.order_id  WHERE   order_status = 1 and payment_status = 1 and  order_date = CURDATE()";
$payementTotalSqlQuery = $connect->query($payementTotalSql);
while ($orderResult = $payementTotalSqlQuery->fetch_assoc()) {
	$PayementtotalQt += $orderResult['quantity'];
}

/////////////// quantite et prix de vente de produit dont le client on laisse une avance 
$payementAvanceSql = "SELECT * FROM orders  WHERE   order_status = 1 and payment_status = 2";
$payementAvanceQuery = $connect->query($payementAvanceSql);
$avance_total = 0;
$rest =0;
while ($orderResult = $payementAvanceQuery->fetch_assoc()) {
	$avance_total += $orderResult['paid'];
	$rest += $orderResult['grand_total'] - $orderResult['paid'];
}

$payementAvanceSql = "SELECT * FROM orders INNER JOIN order_item ON orders.order_id = order_item.order_id WHERE   order_status = 1 and payment_status = 2";
$payementAvanceQuery = $connect->query($payementAvanceSql);
$PayementAvanceQt=0;
while ($orderResult = $payementAvanceQuery->fetch_assoc()) {
	$PayementAvanceQt += $orderResult['quantity'];
}

//////////////////// quantite et credit donne au client
$payementCreditSql = "SELECT * FROM orders INNER JOIN order_item ON orders.order_id = order_item.order_id  WHERE   order_status = 1 and payment_status = 3";
$payementCreditQuery = $connect->query($payementCreditSql);
$restlQt = 0;
$credit_total = 0; //montant qui reste a peyer 
while ($orderResult = $payementCreditQuery->fetch_assoc()) {
	$credit_total += $orderResult['grand_total'];
}

$payementCreditSql = "SELECT * FROM orders INNER JOIN order_item ON orders.order_id = order_item.order_id  WHERE   order_status = 1 and payment_status = 3";
$payementCreditQuery = $connect->query($payementCreditSql);
while ($orderResult = $payementCreditQuery->fetch_assoc()) {
	$restlQt += $orderResult['quantity'];
}



####### nombre total d'utilisateur 
$usersql = "SELECT * FROM users";
$usersqlQuery = $connect->query($usersql);

	$userRestlQt = $usersqlQuery->num_rows;

	####### nombre total de marque 
$brandssql = "SELECT * FROM brands";
$brandssqlQuery = $connect->query($brandssql);

	$brandsRestlQt = $brandssqlQuery->num_rows;

####### nombre total de Categorie 
$categoriesssql = "SELECT * FROM categories";
$categoriessqlQuery = $connect->query($categoriesssql);

	$categoriesRestlQt = $categoriessqlQuery->num_rows;

	####### nombre total d'agence 
$agencessql = "SELECT * FROM agence";
$agencesqlQuery = $connect->query($agencessql);

	$agenceRestlQt = $agencesqlQuery->num_rows;

	####### Valeur  total du stock 
$rate_total =0;
$benefice_total =0;
$rateSql = "SELECT sum(rate_total) as rate_total, sum(benefice_total) as benefice_total, sum(prix_achat_total) as prix_total_achat FROM product_stock";
$rateQuery = $connect->query($rateSql);
while ($rateResult = $rateQuery->fetch_assoc()) {
	$rate_total = $rateResult['rate_total'];
	$benefice_total = $rateResult['benefice_total'];
}


///////// benefici journaliere
/*$BeneficiePayementTotalSql = "SELECT * FROM order_item INNER JOIN product ON product.product_id = order_item.product_id   WHERE   order_status = 1 and payment_status = 1 and  order_date = CURDATE()";
$BeneficiePayementTotalQt = $connect->query($BeneficiePayementTotalSql);
$BeneficieTotalQt="";
while ($orderResult = $BeneficiePayementTotalQt->fetch_assoc()) {
	$BeneficieTotalQt = $orderResult['benefice']* $orderResult['quantity'];
}
$BeneficiePayementAvanceSql = "SELECT * FROM orders  WHERE   order_status = 1 and payment_status = 2 and  order_date = CURDATE()";
$BeneficiePayementAvanceQt = $connect->query($BeneficiePayementAvanceSql);
$BeneficieAvanceQt="";
while ($orderResult = $BeneficiePayementAvanceQt->fetch_assoc()) {
	$BeneficieAvanceQt += $orderResult['benefice'];
}

$BeneficiePayementCreditSql = "SELECT * FROM orders  WHERE   order_status = 1 and payment_status = 3 and  order_date = CURDATE()";
$BeneficiePayementCreditQt = $connect->query($BeneficiePayementCreditSql);
$BeneficieCreditQt="";
while ($orderResult = $BeneficiePayementCreditQt->fetch_assoc()) {
	$BeneficieCreditQt += $orderResult['benefice'];
}*/



?>


<style type="text/css">
	.ui-datepicker-calendar {
		display: none;
	}
</style>

<!-- fullCalendar 2.2.5-->
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.min.css">
    <link rel="stylesheet" href="assests/plugins/fullcalendar/fullcalendar.print.css" media="print">


<div class="row">
	
	
	<div class="col-md-4">
		<div class="panel panel-primary">
			<div class="panel-heading" align="center">
				<a href="agence.php?o=agence" style="text-decoration:none;color:white;" align="center">
					Valeur du stock
				</a>
				
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center"><h1><span ><?php echo number_format($rate_total,2); ?></span></h1></div>
		</div> <!--/panel-->
	</div> <!--/col-md-4-->
	<div class="col-md-4">
			<div class="panel panel-danger">
			<div class="panel-heading" align="center">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;" >
					Valeur cach des ventes  credit
				
				</a>
					
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center">


				 <h1><span ><?php echo number_format($credit_total,2); ?></span></h1></div>
		</div> <!--/panel-->
		</div> <!--/col-md-4-->
		<div class="col-md-4">
			<div class="panel panel-warning">
			<div class="panel-heading" align="center">
				<a href="orders.php?o=manord" style="text-decoration:none;color:black;">
					Valeur cach des ventes  avance
				
				</a>
					
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center">


				 <h1><span ><?php echo number_format($avance_total,2); ?></span></h1></div>
		</div> <!--/panel-->
		</div> <!--/col-md-4-->


	<div class="col-md-4">
		<div class="card">
		  <div class="cardHeader">
		    <h1><?php echo number_format($benefice_total,2); ?></h1>
		  </div>

		  <div class="cardContainer">
		    <p>Beneficie Total de la valeur du stock</p>
		  </div>
		</div> 
	</div>
	<div class="col-md-4">
		<div class="card">
		  <div class="cardHeader" style="background-color:#245580;">
		    <h1><?php
		    	echo number_format($totalRevenue,2);
		    	?></h1>
		  </div>
		  <div class="cardContainer">
		    <p> <i class="glyphicon glyphicon-usd"></i> Revenu Total / Jour</p>
		  </div>
		</div> 
	</div>
	<div class="col-md-4">
		<div class="card">
		  <div class="cardHeader" style="background-color:#245540;">
		    <h1><?php if($totalQt) {
		    	echo $totalQt;
		    	} else {
		    		echo '0';
		    		} ?></h1>
		  </div>
		  <div class="cardContainer">
		    <p> <i class="glyphicon glyphicon-ruble"></i> Quantité Vendue / Jour</p>
		  </div>
		</div> <br>

	</div>


	<div class="col-md-12">
			<div class="panel panel-primary">
			<div class="panel-heading"> <i class="glyphicon glyphicon-usd"></i> Resume de vente
				<div align="right" "><?php
					setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

				 echo ucwords(strftime('%A, %d %B %Y')); //date('l') .' '.date('d').' / '.date('m').' / '.date('Y'); ?></div>
			</div>
			<div class="panel-body">
				<table class='table table-bordered table-striped text-center table-responsive'>
					<thead>
						<tr>
							<th class="text-center">#</th>
							<th class="text-center">Quantité</th>
							<th class="text-center">Montant</th>
							<th class="text-center">Reste</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Payement Total</td>
							<td><?php echo $PayementtotalQt;  ?></td>
							<td><?php echo number_format($grand_total,2) ?></td>
							<td><?php echo number_format(0,2); ?></td>
						</tr>
						<tr>
							<td>Payement Avance</td>
							<td><?php echo $PayementAvanceQt; ?></td>
							<td><?php echo number_format($avance_total,2); ?></td>
							<td><?php echo number_format($rest,2); ?></td>
						</tr>
						<tr>
							<td>Credit</td>
							<td><?php echo $restlQt ?></td>
							<td><?php echo number_format($credit_total,2); ?></td>
							<td><?php echo number_format(0,2); ?></td>
						</tr>
						<tr>
							<td style="color: red;">TOTAL</td>
							<td style="color: red;"><?php echo ($PayementtotalQt+$PayementAvanceQt+$restlQt); ?></td>
							<td style="color: red;"><?php echo number_format(($grand_total+$avance_total+$credit_total),2); ?></td>
							<td style="color: red;"><?php echo number_format($rest,2); ?></td>
						</tr>
					</tbody>
					
				</table>
			</div>	
		</div>

		<!--<div class="panel panel-default">
			<div class="panel-heading"> <i class="glyphicon glyphicon-calendar"></i> Calendar</div>
			<div class="panel-body">
				<div id="calendar"></div>
			</div>	
		</div>-->
	
		
	</div>

	<div class="col-md-2">
			<div class="panel panel-primary">
			<div class="panel-heading">
				<a href="orders.php?o=manord" style="text-decoration:none;color:white;"  align="center">
					Ulisateurs
					<span class="badge pull pull-right"></span>
				</a>
					
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center"><h1><?php echo $userRestlQt; ?></h1></div>
		</div> <!--/panel-->
		</div> <!--/col-md-4-->
<div class="col-md-2">
		<div class="panel panel-info">
			<div class="panel-heading">
				<a href="agence.php?o=agence" style="text-decoration:none;color:black;"  align="center">
					Dépôts
					
				</a>
				
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center"><h1><span ><?php echo $agenceRestlQt; ?></span></h1></div>
		</div> <!--/panel-->
	</div> <!--/col-md-4-->
		<div class="col-md-2">
			<div class="panel panel-default">
			<div class="panel-heading">
				<a href="brand.php" style="text-decoration:none;color:black;" align="center">
					Fournisseurs
				
				</a>
					
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center">


				 <h1 align="center"><span ><?php echo $brandsRestlQt; ?></span></h1></div>
		</div> <!--/panel-->
		</div> <!--/col-md-4-->
		<div class="col-md-2">
			<div class="panel panel-warning">
			<div class="panel-heading">
				<a href="categories.php" style="text-decoration:none;color:black;" align="center">
					Categories
				
				</a>
					
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center">


				 <h1><span ><?php echo $categoriesRestlQt; ?></span></h1></div>
		</div> <!--/panel-->
		</div> <!--/col-md-4-->
	<div class="col-md-2">
		<div class="panel panel-success">
			<div class="panel-heading">
				
				<a href="product.php?o=stock" style="text-decoration:none;color:black;" align="center">
					Produits
						
				</a>
				
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center"><h1><span ><?php echo $countProduct; ?></span></h1></div>
		</div> <!--/panel-->
	</div> <!--/col-md-4-->

		

	<div class="col-md-2">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<a href="product.php" style="text-decoration:none;color:black;" align="center">
					Stock faible
					
				</a>
				
			</div> <!--/panel-hdeaing-->
			<div id="panel-body" align="center"><h1><span ><?php echo $countLowStock; ?></span></h1></div>
		</div> <!--/panel-->
	</div> <!--/col-md-4-->
</div> <!--/row-->
<div class="col-md-12">
	<div class="panel panel-danger">
		<div class="panel-heading">Brefs</div>
<div class="panel-body ">
	<table class='table table-bordered table-striped text-center table-responsive'>
		<thead>
			<tr>
				<th class="text-center">Fournisseurs</th>
				<th class="text-center">Categories</th>
				<th class="text-center">Produits</th>
			</tr>
		</thead>
		<tbody>
<?php ####### nombre total de marque 
$brandssql = "SELECT brand_id,brand_name FROM brands";
$brandssqlQuery = $connect->query($brandssql);

$brandsRestlQt = $brandssqlQuery->num_rows;
while ($resultBrand = $brandssqlQuery->fetch_assoc()) {
	$brandId = $resultBrand ["brand_id"];
	####### nombre total de Categorie 
	$categoriesssql = "SELECT * FROM categories WHERE idBrand = $brandId";
	$categoriessqlQuery = $connect->query($categoriesssql);
	$categoriesRestlQt = $categoriessqlQuery->num_rows;

	####### nombre total de Categorie 
	$productssql = "SELECT * FROM product WHERE brand_id = $brandId";
	$productsqlQuery = $connect->query($productssql);
	$productRestlQt = $productsqlQuery->num_rows;?>

		
				
						<tr>
							<td><?php echo $resultBrand ["brand_name"];  ?></td>
							<td><?php echo $categoriesRestlQt; ?></td>
							<td><?php echo $productRestlQt; ?></td>
						</tr>
			

	<?php
}

?>
			</tbody>
					
		</table>
	</div>	
</div>
</div>
<!-- fullCalendar 2.2.5 -->
<script src="assests/plugins/moment/moment.min.js"></script>
<script src="assests/plugins/fullcalendar/fullcalendar.min.js"></script>


<script type="text/javascript">
	$(function () {
			// top bar active
	$('#navDashboard').addClass('active');

      //Date for the calendar events (dummy data)
      var date = new Date();
      var d = date.getDate(),
      m = date.getMonth(),
      y = date.getFullYear();

      $('#calendar').fullCalendar({
        header: {
          left: '',
          center: 'title'
        },
        buttonText: {
          today: 'today',
          month: 'month'          
        }        
      });


    });
</script>

<?php require_once 'includes/footer.php'; ?>