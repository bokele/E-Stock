<?php 	

require_once 'core.php';

$sql = "SELECT order_id, order_date, nom_client, prenom_client, payment_status, paid, factureTva,numeroFacture  FROM orders INNER JOIN client ON id_client = client_id WHERE order_status = 1 ORDER BY order_id DESC";
$result = $connect->query($sql);



$output = array('data' => array());

if($result->num_rows > 0) { 
 
 $paymentStatus = ""; 
 $x = 1;

 while($row = $result->fetch_array()) {
 	$orderId = $row[0];

 	$countOrderItemSql = "SELECT count(*) FROM order_item WHERE order_id = $orderId";
 	$itemCountResult = $connect->query($countOrderItemSql);
 	$itemCountRow = $itemCountResult->fetch_row();

 	$QtcountOrderItemSql = "SELECT sum(quantity) FROM order_item WHERE order_id = $orderId";
 	$QtitemCountResult = $connect->query($QtcountOrderItemSql);
 	$QtitemCountRow = $QtitemCountResult->fetch_row();


 	// active 
 	if($row[4] == 1) { 		
 		$paymentStatus = "<label class='label label-success'>Payement Total</label>";
 	} else if($row[4] == 2) { 		
 		$paymentStatus = "<label class='label label-info'>Avance</label>";
 	} else { 		
 		$paymentStatus = "<label class='label label-danger'>Credit</label>";
 	} // /else

 	// active 
 	if($row[6] == 21) { 		
 		$tvaStatus = "<label class='label label-primary'>Sans TVA - Savonor</label>";
 	} else if($row[6] == 11) { 		
 		$tvaStatus = "<label class='label label-warning'>Avec TVA - Savonor</label>";
 	} else  if($row[6] == 22){ 		
 		$tvaStatus = "<label class='label label-primary'>Sans TVA - Liquids</label>";
 	} else{ 		
 		$tvaStatus = "<label class='label label-warning'>Avec TVA - Liquids</label>";
 	} // /else

 	if ($row[4] == 1) {
 		$button = '<!-- Single button -->
	

	    <a href="php_action/printOrder.php?orderId='.$orderId.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>  
	   <a type="button" class="btn btn-info btn-sm" data-toggle="modal" id="datail_facture_modalBtn" data-target="#datail_facture_modal" onclick="detailOrder('.$orderId.')" ><i class="fa fa-eye"></i></a> 
	  
	';	
 	}else if ($row[4] == 2) {
 		$button = '<!-- Single button -->
		<a href="php_action/printOrder.php?orderId='.$orderId.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>

		<a type="button" data-toggle="modal" id="datail_facture_modalBtn" data-target="#datail_facture_modal" onclick="detailOrder('.$orderId.')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> </a>  

	    <a href="orders.php?o=editOrd&i='.$orderId.'" id="editOrderModalBtn" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i></a></li>
	    
	    <a type="button" data-toggle="modal" id="paymentOrderModalBtn" data-target="#paymentOrderModal" onclick="paymentOrder('.$orderId.')" class="btn btn-primary btn-sm"> <i class="fa fa-money"></i></a>

	    
	        
	  ';
 	}else{
 		$button = '<!-- Single button -->
	
	 	 <a href="php_action/printOrder.php?orderId='.$orderId.'" class="btn btn-success btn-sm"> <i class="fa fa-print"></i> </a>

	 	 <a type="button" data-toggle="modal" id="datail_facture_modalBtn" data-target="#datail_facture_modal" onclick="detailOrder('.$orderId.')" class="btn btn-info btn-sm"><i class="fa fa-eye"></i> </a> 

	    <a href="orders.php?o=editOrd&i='.$orderId.'" id="editOrderModalBtn" class="btn btn-warning btn-sm"> <i class="fa fa-pencil"></i></a>
	    
	     

	    <a type="button" data-toggle="modal" id="paymentOrderModalBtn" data-target="#paymentOrderModal" onclick="paymentOrder('.$orderId.')" class="btn btn-primary btn-sm"> <i class="fa fa-money"></i></a>

	   
	        
	  ';
 	}

 			
	$orderDate = new DateTime($row[1]);
 	$output['data'][] = array( 		
 		// image
 		$x,
 		// order date
 		$orderDate->format('d/m/Y'),
 		// renference
 		$row[7],
 		
 		// client name
 		$row[2]." ".$row[3], 
 		// client contact
 		//$row[3], 		 	
 		$itemCountRow,
 		$QtitemCountRow, 
 		$row[5],		 	
 		$paymentStatus."<br/>".$tvaStatus,

 		// button
 		$button 		
 		); 	
 	$x++;
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);