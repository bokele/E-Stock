var manageOrderTable;

$(document).ready(function() {

	var divRequest = $(".div-request").text();

	// top nav bar 
	$("#navOrder").addClass('active');

	if(divRequest == 'add')  {
		// add order	
		// top nav child bar 
		$('#topNavAddOrder').addClass('active');	

		// order date picker
		$("#orderDate").datepicker();

		// create order form function
		$("#createOrderForm").unbind('submit').bind('submit', function() {
			var form = $(this);

			$('.form-group').removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove();
				
			var orderDate = $("#orderDate").val();
			var clientName = $("#clientName").val();
			var clientTVAOuiNon = $("#clientTVAOuiNon").val();
			var grandTotalValue = $("#grandTotalValue").val();
			var factureTva = $("#factureTva").val();

			var paid = $("#paid").val();
			var discount = $("#discount").val();
			var paymentType = $("#paymentType").val();
			var paymentStatus = $("#paymentStatus").val();	

			//expression reg. telephone
			
			// form validation 
			if(orderDate == "") {
				$("#orderDate").after('<p class="text-danger"> Obligatoire </p>');
				$('#orderDate').closest('.form-group').addClass('has-error');
			} else {
				$('#orderDate').closest('.form-group').addClass('has-success');
			} // /else
			if(clientName == "") {
				$("#clientName").after('<p class="text-danger"> Obligatoire</p>');
				$('#clientName').closest('.form-group').addClass('has-error');
			} else {
				$('#clientName').closest('.form-group').addClass('has-success');
			} // /else
			if(paid == "") {
				$("#paid").after('<p class="text-danger"> Obligatoire </p>');
				$('#paid').closest('.form-group').addClass('has-error');
			} else {
				$('#paid').closest('.form-group').addClass('has-success');
			} // /else

			if(discount == "") {
				$("#discount").after('<p class="text-danger"> Obligatoire </p>');
				$('#discount').closest('.form-group').addClass('has-error');
			} else {
				$('#discount').closest('.form-group').addClass('has-success');
			} // /else

			if(paymentType == "") {
				$("#paymentType").after('<p class="text-danger"> Obligatoire </p>');
				$('#paymentType').closest('.form-group').addClass('has-error');
			} else {
				$('#paymentType').closest('.form-group').addClass('has-success');
			} // /else

			if(paymentStatus == "") {
				$("#paymentStatus").after('<p class="text-danger"> Obligatoire </p>');
				$('#paymentStatus').closest('.form-group').addClass('has-error');
			} else {
				$('#paymentStatus').closest('.form-group').addClass('has-success');
			} // /else
			if(factureTva == "") {
				$("#factureTva").after('<p class="text-danger"> Obligatoire </p>');
				$('#factureTva').closest('.form-group').addClass('has-error');
			} else {
				$('#factureTva').closest('.form-group').addClass('has-success');
			} // /else



			// array validation
			var productName = document.getElementsByName('productName[]');				
			var validateProduct;
			for (var x = 0; x < productName.length; x++) {       			
				var productNameId = productName[x].id;	    	
		    if(productName[x].value == ''){	    		    	
		    	$("#"+productNameId+"").after('<p class="text-danger"> Obligatoire </p>');
		    	$("#"+productNameId+"").closest('.form-group').addClass('has-error');	    		    	    	
	      } else {      	
		    	$("#"+productNameId+"").closest('.form-group').addClass('has-success');	    		    		    	
	      }          
	   	} // for

	   	for (var x = 0; x < productName.length; x++) {       						
		    if(productName[x].value){	    		    		    	
		    	validateProduct = true;
	      } else {      	
		    	validateProduct = false;
	      }          
	   	} // for       		   	
	   	
	   	var quantity = document.getElementsByName('quantity[]');		   	
	   	var validateQuantity;
	   	for (var x = 0; x < quantity.length; x++) {       
	 			var quantityId = quantity[x].id;
		    if(quantity[x].value == ''){	    	
		    	//$("#"+quantityId+"").after('<p class="text-danger">  </p>');
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < quantity.length; x++) {       						
		    if(quantity[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for       	
	   	

			if(orderDate && clientName && paid && discount && paymentType && paymentStatus && factureTva) {
				if(validateProduct == true && validateQuantity == true) {
					// create order button
					// $("#createOrderBtn").button('loading');
					// verification du methode de payement avec status
			if(paid == 0 && paymentStatus != 3) {
				$("#paymentStatus").after('<p class="text-danger"> Le status n\'est pas correct! </p>');
				$('#paymentStatus').closest('.form-group').addClass('has-error');
				$(".success-messages").html('<div class="alert alert-success">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> Le status n\'est pas correct!'+
				            	
				   		       '</div>');
			} else if(paid != grandTotalValue && paymentStatus != 2){
				$("#paymentStatus").after('<p class="text-danger"> Le status n\'est pas correct! </p>');
				$('#paymentStatus').closest('.form-group').addClass('has-error');
				$(".success-messages").html('<div class="alert alert-success">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> Le status n\'est pas correct!'+
				            	
				   		       '</div>');
			} else {
				$.ajax({
						url : form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),					
						dataType: 'json',
						success:function(response) {
							console.log(response);
							// reset button
							$("#createOrderBtn").button('reset');
							
							$(".text-danger").remove();
							$('.form-group').removeClass('has-error').removeClass('has-success');

							if(response.success == true) {
								
									// create order button
								$(".success-messages").html('<div class="alert alert-success">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong ><i class="fa fa-check"></i></strong> '+ response.messages +
				            	' <br /><a href="php_action/printOrder.php?orderId='+response.order_id+'" class="btn btn-primary"> <i class="fa fa-print"></i> Print </a>'+
				            	'<a href="orders.php?o=add" class="btn btn-default" style="margin-left:10px;"> <i class="fa fa-plus"></i> Nouveau Facture </a>'+
				            	
				   		       '</div>');
									
								$("html, body, div.panel, div.pane-body").animate({scrollTop: '0px'}, 100);

								// disabled te modal footer button
								$(".submitButtonFooter").addClass('div-hide');
								// remove the product row
								$(".removeProductRowBtn").addClass('div-hide');
								
							} else {
										// create order button
								$(".success-messages").html('<div class="alert alert-danger">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong ><h3><i class="glyphicon glyphicon-ok-sign"></i></strong><h3 align="center"> '+ response.messages +
				            	
				            	'<a href="orders.php?o=add" class="btn btn-default" style="margin-left:10px;"> <i class="fa fa-plus"></i> Add New Order </a>'+
				            	
				   		       '</div>');
									
								$("html, body, div.panel, div.pane-body").animate({scrollTop: '0px'}, 100);
														
							}
						} // /response
					}); // /ajax
			} // /else

					
				} // if array validate is true
				return false;
			} // /if field validate is true
			

			return false;
		}); // /create order form function	
	
	} else if(divRequest == 'manord') {
		// top nav child bar 
		$('#topNavManageOrder').addClass('active');

		manageOrderTable = $("#manageOrderTable").DataTable({
			'ajax': 'php_action/fetchOrder.php',
			'order': [],
			"columnDefs":[  
                {  
                     "targets":[0,3,7,8],  
                     "orderable":false,  
                },  
           ]
		});		
					
	} else if(divRequest == 'editOrd') {
		$("#orderDate").datepicker();

		// edit order form function
		$("#editOrderForm").unbind('submit').bind('submit', function() {
			// alert('ok');
			var form = $(this);

			$('.form-group').removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove();
				
			var orderDate = $("#orderDate").val();
			var clientName = $("#clientName").val();
			var clientContact = $("#clientContact").val();
			var paid = $("#paid").val();
			var discount = $("#discount").val();
			var paymentType = $("#paymentType").val();
			var paymentStatus = $("#paymentStatus").val();	
			var grandTotalValue = $("#grandTotalValue").val();	
			var phoneno = /^\+?([0-9]{2})\)?[-. ]?([0-9]{4})[-. ]?([0-9]{4})$/;
			// form validation 
			if(orderDate == "") {
				$("#orderDate").after('<p class="text-danger">Obligatoire </p>');
				$('#orderDate').closest('.form-group').addClass('has-error');
			} else {
				$('#orderDate').closest('.form-group').addClass('has-success');
			} // /else

			if(clientName == "") {
				$("#clientName").after('<p class="text-danger"> Obligatoire </p>');
				$('#clientName').closest('.form-group').addClass('has-error');
			} else {
				$('#clientName').closest('.form-group').addClass('has-success');
			} // /else

			if(clientContact == "" || clientContact.match(phoneno)) {
				$("#clientContact").after('<p class="text-danger"> Obligatoire</p>');
				$('#clientContact').closest('.form-group').addClass('has-error');
			} else {
				$('#clientContact').closest('.form-group').addClass('has-success');
			} // /else
		
			if(paid == "") {
				$("#paid").after('<p class="text-danger"> Obligatoire</p>');
				$('#paid').closest('.form-group').addClass('has-error');
			} else {
				$('#paid').closest('.form-group').addClass('has-success');
			} // /else

			if(discount == "") {
				$("#discount").after('<p class="text-danger"> Obligatoire </p>');
				$('#discount').closest('.form-group').addClass('has-error');
			} else {
				$('#discount').closest('.form-group').addClass('has-success');
			} // /else

			if(paymentType == "") {
				$("#paymentType").after('<p class="text-danger"> Obligatoire </p>');
				$('#paymentType').closest('.form-group').addClass('has-error');
			} else {
				$('#paymentType').closest('.form-group').addClass('has-success');
			} // /else

			if(paymentStatus == "") {
				$("#paymentStatus").after('<p class="text-danger"> Obligatoire </p>');
				$('#paymentStatus').closest('.form-group').addClass('has-error');
			} else {
				$('#paymentStatus').closest('.form-group').addClass('has-success');
			} // /else


			// array validation
			var productName = document.getElementsByName('productName[]');				
			var validateProduct;
			for (var x = 0; x < productName.length; x++) {       			
				var productNameId = productName[x].id;	    	
		    if(productName[x].value == ''){	    		    	
		    	$("#"+productNameId+"").after('<p class="text-danger"> Obligatoire </p>');
		    	$("#"+productNameId+"").closest('.form-group').addClass('has-error');	    		    	    	
	      } else {      	
		    	$("#"+productNameId+"").closest('.form-group').addClass('has-success');	    		    		    	
	      }          
	   	} // for

	   	for (var x = 0; x < productName.length; x++) {       						
		    if(productName[x].value){	    		    		    	
		    	validateProduct = true;
	      } else {      	
		    	validateProduct = false;
	      }          
	   	} // for       		   	
	   	
	   	var quantity = document.getElementsByName('quantity[]');		   	
	   	var validateQuantity;
	   	for (var x = 0; x < quantity.length; x++) {       
	 			var quantityId = quantity[x].id;
		    if(quantity[x].value == ''){	    	
		    	$("#"+quantityId+"").after('<p class="text-danger"> Obligatoire </p>');
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < quantity.length; x++) {       						
		    if(quantity[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for       	
	   		zero =0;
	   		zero = zero.toFixed(2);
			if(orderDate && clientName && clientContact && paid && discount && paymentType && paymentStatus) {
				if(validateProduct == true && validateQuantity == true) {
					// create order button
					// $("#createOrderBtn").button('loading');
			if(paid == zero && paymentStatus != 3) {
				$("#paymentStatus").after('<p class="text-danger"> Le status n\'est pas correct! </p>');
				$('#paymentStatus').closest('.form-group').addClass('has-error');
				$(".success-messages").html('<div class="alert alert-success">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> Le status n\'est pas correct!'+
				            	
				   		       '</div>');
			} else if(paid != grandTotalValue && paymentStatus != 2){
				$('#paymentStatus').closest('.form-group').addClass('has-error');
				$(".success-messages").html('<div class="alert alert-success">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> Le status n\'est pas correct!'+
				            	
				   		       '</div>');
			}else {
				$.ajax({
						url : form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),					
						dataType: 'json',
						success:function(response) {
							console.log(response);
							// reset button
							$("#editOrderBtn").button('reset');
							
							$(".text-danger").remove();
							$('.form-group').removeClass('has-error').removeClass('has-success');

							if(response.success == true) {
								
								// create order button
								$(".success-messages").html('<div class="alert alert-success">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +	            		            		            	
				   		       '</div>');
								
								$("html, body, div.panel, div.pane-body").animate({scrollTop: '0px'}, 100);

								// disabled te modal footer button
								$(".editButtonFooter").addClass('div-hide');
								// remove the product row
								$(".removeProductRowBtn").addClass('div-hide');	
							} else {
								// create order button
								$(".success-messages").html('<div class="alert alert-danger">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +	            		            		            	
				   		       '</div>');
								//alert(response.messages);								
							}
						} // /response
					}); // /ajax
			}

					
				} // if array validate is true
				return false;
			} // /if field validate is true
			

			return false;
		}); // /edit order form function	
	} 	

}); // /documernt


// print order function
/*function printOrder(orderId = null) {
	if(orderId) {		
			
		$.ajax({
			url: 'php_action/printOrder.php',
			type: 'post',
			data: {orderId: orderId},
			dataType: 'text',
			success:function(response) {
				
				var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
        mywindow.document.write('<html><head><title>Order Invoice</title>');        
        mywindow.document.write('</head><body>');
        mywindow.document.write(response);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10

        mywindow.print();
        mywindow.close();
				
			}// /success function
		}); // /ajax function to fetch the printable order
	} // /if orderId
} */// /print order function

function addRow() {

	if ($("#id_marque").val() != "") {
		$("#addRowBtn").button("loading");

	var tableLength = $("#productTable tbody tr").length;

	var tableRow;
	var arrayNumber;
	var count;

	if(tableLength > 0) {		
		
		
		tableRow = $("#productTable tbody tr:last").attr('id');
		arrayNumber = $("#productTable tbody tr:last").attr('class');
		count = tableRow.substring(3);	
		count = Number(count) + 1;
		arrayNumber = Number(arrayNumber) + 1;
		
		if (tableLength == 10) {
		$("#addRowBtn").prop('disabled', true);
		//$("#addRowBtn").attr("disabled", "true");
						
	} 
	} else {
		// no table row
		count = 1;
		arrayNumber = 0;
	}


	var action = "factureTva";
	var tvaOuiNon1 =  $("#factureTva").val();
	$.ajax({
		url: 'php_action/fetchProductData.php',
		method:"POST",
		data:{tvaOuiNon1:tvaOuiNon1,action : action},
		dataType: 'json',
		success:function(response) {
			$("#addRowBtn").button("reset");			

			var tr = '<tr id="row'+count+'" class="'+arrayNumber+'">'+			  				
				'<td style="margin-left:20px;">'+
					'<div class="form-group">'+

					'<select class="form-control" name="productName[]" id="productName'+count+'" onchange="getProductData('+count+')" >';//+
						
						
							tr += response; 						
						
													
					tr += '</select>'+
					'<input type="hidden" name="tvaOuiNon[]" id="tvaOuiNon'+count+'" autocomplete="off" class="form-control" min="1" /></div>'+
				'</td>'+
				'<td style="padding-left:20px;">'+
					'<input type="number" name="quantity[]" id="quantity'+count+'" onkeyup="getTotal('+count+')" autocomplete="off" class="form-control" min="1" />'+
				'</td>'+
				'<td style="padding-left:20px;"">'+
					'<div class="form-group">'+
						'<input type="text" name="rate[]" id="rate'+count+'" autocomplete="off" disabled="true" class="form-control" />'+
						'<input type="hidden" name="rateValue[]" id="rateValue'+count+'" autocomplete="off" class="form-control" />'+
					'</div>'+
				'</td>'+

				
				'<td style="padding-left:20px;">'+
					'<input type="text" name="total[]" id="total'+count+'" autocomplete="off" class="form-control" disabled="true" />'+
					'<input type="hidden" name="totalValue[]" id="totalValue'+count+'" autocomplete="off" class="form-control" />'+
				'</td>'+
				'<td>'+
					'<button class="btn btn-danger removeProductRowBtn" type="button" onclick="removeProductRow('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
				'</td>'+
				
			'</tr>';
			if(tableLength > 0) {							
				$("#productTable tbody tr:last").after(tr);
			} else {				
				$("#productTable tbody").append(tr);
			}		

		} // /success
	});	// get the product data
}else{
	alert("Le champ Facture Avec TVA est obligatoire ");
}
	

} // /add row

function removeProductRow(row = null) {
	if(row) {
		$("#row"+row).remove();


		subAmount();
	} else {
		alert('Erreur ! Actualiser à nouveau la page');
	}
}

// select on product data
function getProductData(row = null) {
	if(row) {
		var productId = $("#productName"+row).val();
		//var tvaOuiNon = $("#tvaOuiNon"+row).val();
		var tvaOuiNon1 = $("#factureTva").val();		
		
		if(productId == "") {
			$("#rate"+row).val("");

			$("#quantity"+row).val("");						
			$("#total"+row).val("");
			$("#tvaOuiNon"+row).val("");

			// remove check if product name is selected
			// var tableProductLength = $("#productTable tbody tr").length;			
			// for(x = 0; x < tableProductLength; x++) {
			// 	var tr = $("#productTable tbody tr")[x];
			// 	var count = $(tr).attr('id');
			// 	count = count.substring(3);

			// 	var productValue = $("#productName"+row).val()

			// 	if($("#productName"+count).val() == "") {					
			// 		$("#productName"+count).find("#changeProduct"+productId).removeClass('div-hide');	
			// 		console.log("#changeProduct"+count);
			// 	}											
			// } // /for

		} else {
				$.ajax({
					url: 'php_action/fetchSelectedProduct.php',
					type: 'post',
					data: {productId : productId, tvaOuiNon1 : tvaOuiNon1},
					dataType: 'json',
					success:function(response) {
						// setting the rate value into the rate input field
				
						$("#rate"+row).val(response.rate);
						$("#rateValue"+row).val(response.rate);

						$("#tvaOuiNon"+row).val(response.produit_tva);

						$("#quantity"+row).val(1);

						var total = Number(response.rate) * 1;
						total = total.toFixed(2);
						$("#total"+row).val(total);
						$("#totalValue"+row).val(total);
						var tvaOuiNon = $("#tvaOuiNon"+row).val();
						 tvaOuiNon1 = tvaOuiNon1.substring(0,1);
						if (tvaOuiNon1 == tvaOuiNon) {
							subAmount();
							//orderTVA();
						}
					} // /success
				}); // /ajax function to fetch the product data	
				//tvaOuiNonTotal = $("#tvaOuiNonTotal").val(tvaOuiNon);
		}
				
	} else {
		alert('pas de rang !! veuillez rafraîchir la page');
	}
} // /select on product data

// table total
function getTotal(row = null) {
	if(row) {
		var total = Number($("#rate"+row).val()) * Number($("#quantity"+row).val());
		total = total.toFixed(2);
		$("#total"+row).val(total);
		$("#totalValue"+row).val(total); 
		subAmount();

	} else {
		alert('pas de rang !! veuillez rafraîchir la page');
	}
}

function subAmount() {
	var tableProductLength = $("#productTable tbody tr").length;
	var totalSubAmount = 0;
	var tvaOuiNon = "";
	for(x = 0; x < tableProductLength; x++) {
		var tr = $("#productTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);

		totalSubAmount = Number(totalSubAmount) + Number($("#total"+count).val());
	} // /for

	totalSubAmount = totalSubAmount.toFixed(2);

	// sub total
	$("#subTotal").val(totalSubAmount);
	$("#subTotalValue").val(totalSubAmount);

	//$("#tvaOuiNonTotal").val(tvaOuiNon);
	//function orderTVA(){
	// vat
	var vat = 0;
	var factureTva =$("#factureTva").val().substring(0,1);
	if( factureTva == 1){
		vat = (Number($("#subTotalValue").val())/100) * 18;
		vat = vat.toFixed(2);
		$("#vat").val(vat);
		$("#vatValue").val(vat);

	}else{
		$("#vat").val(vat);
		$("#vatValue").val(vat);
	}

//}
	
	
	// total amount
	var totalAmount = (Number($("#subTotal").val()) + Number($("#vat").val()));
	totalAmount = totalAmount.toFixed(2);
	$("#totalAmount").val(totalAmount);
	$("#totalAmountValue").val(totalAmount);

	var discount = $("#discount").val();
	if(discount) {
		var grandTotal = Number($("#totalAmount").val()) - Number(discount);
		grandTotal = grandTotal.toFixed(2);
		$("#grandTotal").val(grandTotal);
		$("#grandTotalValue").val(grandTotal);
	} else {
		$("#grandTotal").val(totalAmount);
		$("#grandTotalValue").val(totalAmount);
	} // /else discount	

	var paidAmount = $("#paid").val();
	if(paidAmount) {
		paidAmount =  Number($("#grandTotal").val()) - Number(paidAmount);
		paidAmount = paidAmount.toFixed(2);
		$("#due").val(paidAmount);
		$("#dueValue").val(paidAmount);
	} else {	
		$("#due").val($("#grandTotal").val());
		$("#dueValue").val($("#grandTotal").val());
	} // else

} // /sub total amount

function discountFunc() {
	var discount = $("#discount").val();
 	var totalAmount = Number($("#totalAmount").val());
 	totalAmount = totalAmount.toFixed(2);

 	var grandTotal;
 	if(totalAmount) { 	
 		grandTotal = Number($("#totalAmount").val()) - Number($("#discount").val());
 		grandTotal = grandTotal.toFixed(2);

 		$("#grandTotal").val(grandTotal);
 		$("#grandTotalValue").val(grandTotal);
 	} else {
 	}

 	var paid = $("#paid").val();

 	var dueAmount; 	
 	if(paid) {
 		dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
 		dueAmount = dueAmount.toFixed(2);

 		$("#due").val(dueAmount);
 		$("#dueValue").val(dueAmount);
 	} else {
 		$("#due").val($("#grandTotal").val());
 		$("#dueValue").val($("#grandTotal").val());
 	}

} // /discount function

function paidAmount() {
	var grandTotal = $("#grandTotal").val();

	if(grandTotal) {
		var dueAmount = Number($("#grandTotal").val()) - Number($("#paid").val());
		dueAmount = dueAmount.toFixed(2);
		$("#due").val(dueAmount);
		$("#dueValue").val(dueAmount);
	} // /if
} // /paid amoutn function


function paidAmountRest() {
	var grandTotal = $("#payRest").val();

	if(grandTotal) {
		var dueAmount = Number($("#payRest").val()) - Number($("#montantPaye").val());
		dueAmount = dueAmount.toFixed(2);
		$("#payAmount").val(dueAmount);
		$("#payAmountRest").val(dueAmount);
	} // /if
} // /paid amoutn function

function resetOrderForm() {
	// reset the input field
	$("#createOrderForm")[0].reset();
	// remove remove text danger
	$(".text-danger").remove();
	// remove form group error 
	$(".form-group").removeClass('has-success').removeClass('has-error');
} // /reset order form


// remove order from server
function removeOrder(orderId = null) {
	if(orderId) {
		$("#removeOrderBtn").unbind('click').bind('click', function() {
			$("#removeOrderBtn").button('loading');

			$.ajax({
				url: 'php_action/removeOrder.php',
				type: 'post',
				data: {orderId : orderId},
				dataType: 'json',
				success:function(response) {
					$("#removeOrderBtn").button('reset');

					if(response.success == true) {

						manageOrderTable.ajax.reload(null, false);
						// hide modal
						$("#removeOrderModal").modal('hide');
						// success messages
						$("#success-messages").html('<div class="alert alert-success">'+
	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
	          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          

					} else {
						// error messages
						$(".removeOrderMessages").html('<div class="alert alert-warning">'+
	            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
	            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
	          '</div>');

						// remove the mesages
	          $(".alert-success").delay(500).show(10, function() {
							$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert	          
					} // /else

				} // /success
			});  // /ajax function to remove the order

		}); // /remove order button clicked
		

	} else {
		alert('Erreur ! Actualiser à nouveau la page');
	}
}
// /remove order from server

// Payment ORDER
function paymentOrder(orderId = null) {
	if(orderId) {

		$("#orderDate").datepicker();

		$.ajax({
			url: 'php_action/fetchOrderData.php',
			type: 'post',
			data: {orderId: orderId},
			dataType: 'json',
			success:function(response) {				
				//facturenumero
				$("#facturenumero").text(response.order[14]);
				//  total general 
				$("#total").val(response.order[8]);
				// paye 
				$("#due").val(response.order[9]);				
				// pay amount // reste a paye
				$("#payAmount").val(response.order[10]);
				$("#payAmountRest").val(response.order[10]);
				$("#payRest").val(response.order[10]);
				$("#payRestAffiche").val(response.order[10]);
				//type de payement
				$("#paymentType").val(response.order[11]);
				// status de payement
				$("#paymentStatus").val(response.order[12]);

				var paidAmount = response.order[9] // paye 
				var dueAmount = response.order[10];		// reste a paye					
				var grandTotal = response.order[8]; //  total general 



				// update payment
				$("#updatePaymentOrderBtn").unbind('click').bind('click', function() {
					var paymentType 	= $("#paymentType").val();
					var paymentStatus 	= $("#paymentStatus").val();
					var montantPaye 	= $("#montantPaye").val();
					var payAmountRest 	= $("#payAmountRest").val();

					var paye = Number(montantPaye) + Number(paidAmount);

					if(montantPaye == "") {
						$("#montantPaye").after('<p class="text-danger">Le champ Montant à  payer est obligatoire</p>');
						$("#montantPaye").closest('.form-group').addClass('has-error');
					} else {
						$("#montantPaye").closest('.form-group').addClass('has-success');
					}

					if(paymentType == "") {
						$("#paymentType").after('<p class="text-danger">Le champ Type de paiement est obligatoire</p>');
						$("#paymentType").closest('.form-group').addClass('has-error');
					} else {
						$("#paymentType").closest('.form-group').addClass('has-success');
					}

					if(paymentStatus == "") {
						$("#paymentStatus").after('<p class="text-danger">Le champ Statut du paiement est obligatoire</p>');
						$("#paymentStatus").closest('.form-group').addClass('has-error');
					} else {
						$("#paymentStatus").closest('.form-group').addClass('has-success');
					}

					if(montantPaye && paymentType && paymentStatus) {
						$("#updatePaymentOrderBtn").button('loading');
						if(montantPaye == 0 &&  paymentStatus != 3 ) {
							$("#paymentStatus").after('<p class="text-danger"> Le status n\'est pas correct! </p>');
							$('#paymentStatus').closest('.form-group').addClass('has-error');
							$(".success-messages").html('<div class="alert alert-success">'+
							  	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
							    '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> Le status n\'est pas correct!'+
							    '</div>'
							);
						}else if(paye != grandTotal && paymentStatus != 2){
							$("#paymentStatus").after('<p class="text-danger"> Le status n\'est pas correct! </p>');
							$('#paymentStatus').closest('.form-group').addClass('has-error');
							$(".success-messages").html('<div class="alert alert-success">'+
								'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
								'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> Le status n\'est pas correct!'+
								'</div>'
							);
						}else{
							$.ajax({
								url: 'php_action/editPayment.php',
								type: 'post',
								data: {
									orderId: orderId,
									paymentType: paymentType,
									paymentStatus: paymentStatus,
									paidAmount: paidAmount,
									grandTotal: grandTotal,
									montantPaye: montantPaye,
									payAmountRest: payAmountRest
								},
								dataType: 'json',
								success:function(response) {
									$("#updatePaymentOrderBtn").button('loading');

									// remove error
									$('.text-danger').remove();
									$('.form-group').removeClass('has-error').removeClass('has-success');

									$("#paymentOrderModal").modal('hide');

									$("#success-messages").html('<div class="alert alert-success">'+
						            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
						          		'</div>'
						        	);

									// remove the mesages
			          				$(".alert-success").delay(500).show(10, function() {
										$(this).delay(3000).hide(10, function() {
										$(this).remove();
										});
									}); // /.alert	

			          				// refresh the manage order table
									manageOrderTable.ajax.reload(null, false);

								} //

							});
						}
						
					} // /if
						
					return false;
				}); // /update payment			

			} // /success
		}); // fetch order data
	} else {
		alert('Erreur ! Actualiser à nouveau la page');
	}
}

function detailOrder(orderId = null){
	var table='<thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Produit</th><th scope="col">Quantité</th><th scope="col">PU</th><th scope="col">PT-HTVA</th></tr></thead>';
	if(orderId) {
		$.ajax({
			url: 'php_action/fetchOrderDataDetail.php',
			type: 'post',
			data: {orderId: orderId},
			dataType: 'json',
			success:function(response){

				$("#tableDatail").html(response);
			}
		});
	}	
}


