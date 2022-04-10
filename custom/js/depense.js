
var manageDepenseTable;

$(document).ready(function() {

	$("#navDepense").addClass('active');
	$('#topNavManageDepense').addClass('active');
		// order date picker
		$("#date_depense").datepicker();

		var divRequest = $(".div-request").text();

		manageDepenseTable = $("#manageDepenseTable").DataTable({
		"processing":false,
		"serverSide":false,
		'order': [],
		'ajax': 'php_action/fetchDepense.php',
		"columnDefs":[  
                {  
                    "targets":[0,1,6],  
                    "orderable":false,  
                },  
           ],
	});
		if(divRequest != 'edit')  {
			// manage brand table
	

// create order form function
$("#addpenseModalBtn").unbind('click').bind('click', function() {

	// // product form reset
		$("#getdepenseForm")[0].reset();		

		// remove text-error 
		$(".text-danger").remove();
		// remove from-group error
		$(".form-group").removeClass('has-error').removeClass('has-success');

	$("#getdepenseForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

			var date_depense	 		= $("#date_depense").val();
			var demende_depense 		= $("#demende_depense").val();
			var autorisation_depense 	= $("#autorisation_depense").val();
			var prix_total_achatValue 	= $("#prix_total_achatValue").val();
			var prix_achat_totalValue 	= $("#prix_achat_totalValue").val();
	

		if(date_depense == "") {
			$("#date_depense").after('<p class="text-danger">obligatoire</p>');
			$('#date_depense').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#date_depense").find('.text-danger').remove();
			// success out for form 
			$("#date_depense").closest('.form-group').addClass('has-success');	  	
		}
		if(demende_depense == "") {
			$("#demende_depense").after('<p class="text-danger"> Obligatoire </p>');
			$('#demende_depense').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#demende_depense").find('.text-danger').remove();
			// success out for form 
			$("#demende_depense").closest('.form-group').addClass('has-success');	  	
		}
		if(autorisation_depense == "") {
			$("#autorisation_depense").after('<p class="text-danger"> Obligatoire</p>');
			$('#autorisation_depense').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#autorisation_depense").find('.text-danger').remove();
			// success out for form 
			$("#autorisation_depense").closest('.form-group').addClass('has-success');	  	
		}
		/*if(prix_achat_totalValue == "") {
			$("#prix_achat_totalValue").after('<p class="text-danger">Le NIF verse est obligatoire</p>');
			$('#prix_achat_totalValue').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#prix_achat_totalValue").find('.text-danger').remove();
			// success out for form 
			$("#prix_achat_totalValue").closest('.form-group').addClass('has-success');	  	
		}
		if(prix_total_achatValue == "") {
			$("#prix_total_achatValue").after('<p class="text-danger">L\'adresse est obligatoire</p>');
			$('#prix_total_achatValue').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#nom_baprix_total_achatValuenque").find('.text-danger').remove();
			// success out for form 
			$("#prix_total_achatValue").closest('.form-group').addClass('has-success');	  	
		}*/

		// array validation
			var libelle_depense = document.getElementsByName('libelle_depense[]');				
			var validateProduct;
			for (var x = 0; x < libelle_depense.length; x++) {       			
				var libelle_depenseId = libelle_depense[x].id;	    	
		    	if(libelle_depense[x].value == ''){	    		    	
		    		$("#"+libelle_depenseId+"").after('<p class="text-danger"> Obligatoire</p>');
		    		$("#"+libelle_depenseId+"").closest('.form-group').addClass('has-error');	    		    	    	
		      	} else {      	
			    	$("#"+libelle_depenseId+"").closest('.form-group').addClass('has-success');	    		    		    	
		      	}          
	   		} // for
	   			for (var x = 0; x < libelle_depense.length; x++) {       						
			    if(libelle_depense[x].value){	    		    		    	
			    	validateProduct = true;
		      } else {      	
			    	validateProduct = false;
		      }          
		   	} // for

		   	var quantite = document.getElementsByName('quantite[]');		   	
	   	var validateQuantity;
	   	for (var x = 0; x < quantite.length; x++) {       
	 			var quantityId = quantite[x].id;
		    if(quantite[x].value == ''){	    	
		    	$("#"+quantityId+"").after('<p class="text-danger"> Obligatoire</p>');
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < quantite.length; x++) {       						
		    if(quantite[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for

	   		var prix_achat = document.getElementsByName('prix_achat[]');		   	
	   	var validatePrix;
	   	for (var x = 0; x < prix_achat.length; x++) {       
	 			var prix_achatId = prix_achat[x].id;
		    if(prix_achat[x].value == ''){	    	
		    	$("#"+prix_achatId+"").after('<p class="text-danger"> Obligatoire</p>');
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   		for (var x = 0; x < prix_achat.length; x++) {       						
		    if(prix_achat[x].value){	    		    		    	
		    	validatePrix = true;
	      } else {      	
		    	validatePrix = false;
	      }          
	   	} // for

		if(date_depense && demende_depense && autorisation_depense ) {
			var form = $(this);
			// button loading
			if(validateProduct == true && validateQuantity == true && validatePrix == true) {


			//$("#createDepenseBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#createDepenseBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						manageDepenseTable.ajax.reload(null, false);						
						// hide the remove modal 
						$('#attacheFactureDepenseDepenseModal').modal('hide');
  	  					// reset the form text
						$("#getdepenseForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
  	  					$('.remove-messages').html('<div class="alert alert-success">'+
            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
           				 	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          				'</div>');

  	  						$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					}  // if

					else{
						$('.remove-messages').html('<div class="alert alert-danger">'+
            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
           				 	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          				'</div>');

  	  						$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					} // else return false marque existe

				} // /success
			}); // /ajax

			} // if
			return false;	
		} // if

		return false;
	}); // /submit brand form function
});
// create order form function
}else if(divRequest == 'edit')  {
	$("#date_depenseEdit").datepicker();

	$("#date_depenseEdit").datepicker();
		$("#editDepenseForm").unbind('submit').bind('submit', function() {
		// remove the error text
		$(".text-danger").remove();
		// remove the form error
		$('.form-group').removeClass('has-error').removeClass('has-success');			

			var date_depenseEdit	 		= $("#date_depenseEdit").val();
			var demende_depenseEdit 		= $("#demende_depenseEdit").val();
			var autorisation_depenseEdit 	= $("#autorisation_depenseEdit").val();
			var prix_total_achatValue 	= $("#prix_total_achatValue").val();
			var prix_achat_totalValue 	= $("#prix_achat_totalValue").val();
	

		if(date_depenseEdit == "") {
			$("#date_depenseEdit").after('<p class="text-danger">obligatoire</p>');
			$('#date_depenseEdit').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#date_depenseEdit").find('.text-danger').remove();
			// success out for form 
			$("#date_depenseEdit").closest('.form-group').addClass('has-success');	  	
		}
		if(demende_depenseEdit == "") {
			$("#demende_depenseEdit").after('<p class="text-danger"> Obligatoire </p>');
			$('#demende_depenseEdit').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#demende_depenseEdit").find('.text-danger').remove();
			// success out for form 
			$("#demende_depenseEdit").closest('.form-group').addClass('has-success');	  	
		}
		if(autorisation_depenseEdit == "") {
			$("#autorisation_depenseEdit").after('<p class="text-danger"> Obligatoire</p>');
			$('#autorisation_depenseEdit').closest('.form-group').addClass('has-error');
		} else {
			// remov error text field
			$("#autorisation_depenseEdit").find('.text-danger').remove();
			// success out for form 
			$("#autorisation_depenseEdit").closest('.form-group').addClass('has-success');	  	
		}
		
		// array validation
			var libelle_depense = document.getElementsByName('libelle_depense[]');				
			var validateProduct;
			for (var x = 0; x < libelle_depense.length; x++) {       			
				var libelle_depenseId = libelle_depense[x].id;	    	
		    	if(libelle_depense[x].value == ''){	    		    	
		    		$("#"+libelle_depenseId+"").after('<p class="text-danger"> Obligatoire</p>');
		    		$("#"+libelle_depenseId+"").closest('.form-group').addClass('has-error');	    		    	    	
		      	} else {      	
			    	$("#"+libelle_depenseId+"").closest('.form-group').addClass('has-success');	    		    		    	
		      	}          
	   		} // for
	   			for (var x = 0; x < libelle_depense.length; x++) {       						
			    if(libelle_depense[x].value){	    		    		    	
			    	validateProduct = true;
		      } else {      	
			    	validateProduct = false;
		      }          
		   	} // for

		   	var quantite = document.getElementsByName('quantite[]');		   	
	   	var validateQuantity;
	   	for (var x = 0; x < quantite.length; x++) {       
	 			var quantityId = quantite[x].id;
		    if(quantite[x].value == ''){	    	
		    	$("#"+quantityId+"").after('<p class="text-danger"> Obligatoire</p>');
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < quantite.length; x++) {       						
		    if(quantite[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for

	   		var prix_achat = document.getElementsByName('prix_achat[]');		   	
	   	var validatePrix;
	   	for (var x = 0; x < prix_achat.length; x++) {       
	 			var prix_achatId = prix_achat[x].id;
		    if(prix_achat[x].value == ''){	    	
		    	$("#"+prix_achatId+"").after('<p class="text-danger"> Obligatoire</p>');
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   		for (var x = 0; x < prix_achat.length; x++) {       						
		    if(prix_achat[x].value){	    		    		    	
		    	validatePrix = true;
	      } else {      	
		    	validatePrix = false;
	      }          
	   	} // for

		if(date_depenseEdit && demende_depenseEdit && autorisation_depenseEdit ) {
			var form = $(this);
			// button loading
			if(validateProduct == true && validateQuantity == true && validatePrix == true) {


			$("#editDepenseBtn").button('loading');

			$.ajax({
				url : form.attr('action'),
				type: form.attr('method'),
				data: form.serialize(),
				dataType: 'json',
				success:function(response) {
					// button loading
					$("#editDepenseBtn").button('reset');

					if(response.success == true) {
						// reload the manage member table 
						//manageDepenseTable.ajax.reload(null, false);						
						// hide the remove modal 
						//$('#attacheFactureDepenseDepenseModal').modal('hide');
  	  					// reset the form text
						$("#editDepenseForm")[0].reset();
						// remove the error text
						$(".text-danger").remove();
						// remove the form error
						$('.form-group').removeClass('has-error').removeClass('has-success');
  	  			
  	  					$('.remove-messages').html('<div class="alert alert-success">'+
            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
           				 	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          				'</div>');


								// disabled te modal footer button
								$(".editButtonFooter").addClass('div-hide');
								// remove the product row
								$(".removeCommandRowBtn").addClass('div-hide');

  	  						$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					}  // if

					else{
						$('.remove-messages').html('<div class="alert alert-danger">'+
            				'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
           				 	'<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
          				'</div>');

  	  						$(".alert-success").delay(500).show(10, function() {
								$(this).delay(3000).hide(10, function() {
								$(this).remove();
							});
						}); // /.alert
					} // else return false marque existe

				} // /success
			}); // /ajax

			} // if
			return false;	
		} // if

		return false;
	}); // /submit brand form function
	}
		

});

function addRow() {

	if ($("#date_depense").val() != "") {
		$("#addRowBtn").button("loading");

	var tableLength = $("#depenseTable tbody tr").length;

	var tableRow;
	var arrayNumber;
	var count;

	if(tableLength > 0) {		
		
		
		tableRow = $("#depenseTable tbody tr:last").attr('id');
		arrayNumber = $("#depenseTable tbody tr:last").attr('class');
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


	
			$("#addRowBtn").button("reset");			

			var tr = '<tr id="row'+count+'" class="'+arrayNumber+'">'+			  				
				'<td style="margin-left:20px;">'+
					'<div class="form-group">'+

					'<input type="text" class="form-control" name="libelle_depense[]" id="libelle_depense'+count+'"  >';//+
						
					tr += '</div>'+
					
				'</td>'+
				'<td style="padding-left:20px;">'+
					'<input type="number" name="quantite[]" id="quantite'+count+'" onkeyup="getTotal('+count+')" autocomplete="off" class="form-control" min="1" value="1"/>'+
				'</td>'+
				'<td style="padding-left:20px;"">'+
					
						'<input type="number" name="prix_achat[]" id="prix_achat'+count+'" onkeyup="getTotal('+count+')" autocomplete="off"  class="form-control" value="0"/>'+
					
				'</td>'+

				
				'<td style="padding-left:20px;">'+
				'<div class="form-group">'+
					'<input type="text" name="prix_achat_total[]" id="prix_achat_total'+count+'" autocomplete="off" class="form-control" disabled="true" value="0.00"/>'+
					'<input type="hidden" name="prix_achat_totalValue[]" id="prix_achat_totalValue'+count+'" autocomplete="off" class="form-control" />'+
				'</div>'+
				'</td>'+
				'<td>'+
					'<button class="btn btn-danger removeProductRowBtn" type="button" onclick="removeDepenseRow('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
				'</td>'+
				
			'</tr>';
			if(tableLength > 0) {							
				$("#depenseTable tbody tr:last").after(tr);
			} else {				
				$("#depenseTable tbody").append(tr);
			}		

	
}else{
	alert("Le champ date de demande est obligatoire ");
}
	

} // /add row


////////// remove row
function removeDepenseRow(row = null) {
	if(row) {
		$("#row"+row).remove();


		subAmount();
	} else {
		alert('Erreur ! Actualiser à nouveau la page');
	}
}// fin remove row

// table total
function getTotal(row = null) {
	if(row) {
		
		var total = Number($("#prix_achat"+row).val()) * Number($("#quantite"+row).val());

		total = total.toFixed(2);
		$("#prix_achat_total"+row).val(total);
		$("#prix_achat_totalValue"+row).val(total);

		subAmount();



	} else {
		alert('pas de rang !! veuillez rafraîchir la page');
	}
}
function subAmount() {
	var tableProductLength = $("#depenseTable tbody tr").length;
	var totalSubAmount = 0;

	var quantite =0;
	for(x = 0; x < tableProductLength; x++) {
		var tr = $("#depenseTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);

		totalSubAmount = Number(totalSubAmount) + Number($("#prix_achat_total"+count).val());
		$("#quantite_totalAffiche").val(quantite);
		quantite += Number($("#quantite"+count).val());
	} // /for



	totalSubAmount = totalSubAmount.toFixed(2);

	// sub total
	$("#prix_total_achatAffiche").val(totalSubAmount);
	$("#prix_total_achatValue").val(totalSubAmount);
	$("#quantite_totalAffiche").val(quantite);
	$("#quantite_total").val(quantite);

}


function viewDepense(depenseId = null){

	var table='<thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Produit</th><th scope="col">Quantité</th><th scope="col">PU</th><th scope="col">PT-HTVA</th></tr></thead>';
	if(depenseId) {
		$.ajax({
			url: 'php_action/fetchDepenseDataDetail.php',
			type: 'post',
			data: {depenseId: depenseId},
			dataType: 'json',
			success:function(response){

				$("#tableDatail").html(response);
			}
		});
	}	
}


function resetCommandeForm() {
	// reset the input field
	$("#getdepenseForm")[0].reset();
	// remove remove text danger
	$(".text-danger").remove();
	// remove form group error 
	$(".form-group").removeClass('has-success').removeClass('has-error');
} // /reset order form

function payementDepense(id_depense = null) {
	if(id_depense) {
		$("#date_facture").datepicker();
		$.ajax({
			url: 'php_action/fetchSelectedDepense.php',
			type: 'post',
			data: {id_depense : id_depense},
			dataType: 'json',
			success:function(response) {
				$('#depensePayementId').val(response.id_depense);
				$("#paiement").text(response.ref_depense);
				$("#prix_achat_depense").val(response.prix_total_depense);
				$("#demende_depenseEdit").val(response.demende_depense);
				$("#autorisation_depenseEdit").val(response.autorisation_depense);
				$("#dateemission").val(response.date_depense);
				$("#prix_achat_depenseValue").val(response.prix_total_depense);
				// click on remove button to remove the brand
				$("#getpaiementForm").unbind('submit').bind('submit', function() {
					// button loading
					var date_facture 				= $("#date_facture").val();
					var facture_depense 			= $("#facture_depense").val();
					var id_classe 					= $("#id_classe").val();
					var id_Compte 					= $("#id_Compte").val();
					var id_sous_compte 				= $("#id_sous_compte").val();
					var paymentType 				= $("#paymentType").val();
					var paymentStatusPayement 		= $("#paymentStatusPayement").val();
					var montant 					= $("#montant").val();
					//var prix_achat_depenseValue 	= $("#prix_achat_depenseValue").val();
					var observation_depense 		= $("#observation_depense").val();
					var depensePayementId 			= $("#depensePayementId").val();
					if(date_facture == "") {
						$("#date_facture").after('<p class="text-danger">La date est obligatoire</p>');
						$('#date_facture').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#date_facture").find('.text-danger').remove();
						// success out for form 
						$("#date_facture").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(facture_depense == "") {
						$("#facture_depense").after('<p class="text-danger">Le numéro est obligatoire</p>');
						$('#facture_depense').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#facture_depense").find('.text-danger').remove();
						// success out for form 
						$("#facture_depense").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(id_classe == "") {
						$("#id_classe").after('<p class="text-danger">La classe est obligatoire</p>');
						$('#id_classe').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#id_classe").find('.text-danger').remove();
						// success out for form 
						$("#id_classe").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(id_Compte == "") {
						$("#id_Compte").after('<p class="text-danger">Le compte est obligatoire</p>');
						$('#id_Compte').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#id_Compte").find('.text-danger').remove();
						// success out for form 
						$("#id_Compte").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(id_sous_compte == "") {
						$("#id_sous_compte").after('<p class="text-danger">Le sous compte est obligatoire</p>');
						$('#id_sous_compte').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#id_sous_compte").find('.text-danger').remove();
						// success out for form 
						$("#id_sous_compte").closest('.form-group').addClass('has-success');	  	
					}	// /else

					if(paymentType == "") {
						$("#paymentType").after('<p class="text-danger">Le type de paiement est obligatoire</p>');
						$('#paymentType').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#paymentType").find('.text-danger').remove();
						// success out for form 
						$("#paymentType").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(paymentStatusPayement == "") {
						$("#paymentStatusPayement").after('<p class="text-danger">Le status de paiement est obligatoire</p>');
						$('#paymentStatusPayement').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#paymentStatusPayement").find('.text-danger').remove();
						// success out for form 
						$("#paymentStatusPayement").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(montant == "") {
						$("#montant").after('<p class="text-danger">Le montant est obligatoire</p>');
						$('#montant').closest('.form-group').addClass('has-error');
					}else {
						// remov error text field
						$("#montant").find('.text-danger').remove();
						// success out for form 
						$("#montant").closest('.form-group').addClass('has-success');	  	
					}	// /else
					if(date_facture && facture_depense && id_classe && id_Compte && id_sous_compte && paymentType && paymentStatusPayement && montant){
						var form = $(this);
						$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),	
							dataType: 'json',
								success:function(response){
									$("#createpayementDepenseBtn").button('reset');
									if(response.success == true) {
										// reload the brand table 
										$("#getpaiementForm")[0].reset();
										manageDepenseTable.ajax.reload(null, false);
										// hide the remove modal  
										$('#addPayementDepenseModal').modal('hide');
										$('.remove-messages').html('<div class="alert alert-success">'+
								            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
								            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
								          '</div>');
										$(".alert-success").delay(500).show(10, function() {
											$(this).delay(3000).hide(10, function() {
												$(this).remove();
											});
										}); // /.alert

									}else {
										$('.remove-messages').html('<div class="alert alert-danger">'+
								            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
								            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
								          '</div>');

						  	  			$(".alert-success").delay(500).show(10, function() {
											$(this).delay(3000).hide(10, function() {
											$(this).remove();
											});
										}); // /.alert
							} // /else

							}
						});
					}
					return false;

				});

			}

		});

	}
	return false;

}

function removeDepense(id_depense = null) {
	if(id_depense) {
		$('#removeDepenseId').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedDepense.php',
			type: 'post',
			data: {id_depense : id_depense},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="removeDepenseId" id="removeDepenseId" value="'+response.id_depense+'" /> ');
				$("#supprimer").text(response.ref_depense);
				// click on remove button to remove the brand
				$("#removeDepenseBtn").unbind('click').bind('click', function() {
					// button loading
					$("#removeDepenseBtn").button('loading');

					$.ajax({
						url: 'php_action/removeDepense.php',
						type: 'post',
						data: {id_depense : id_depense},
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
													// button loading
							$("#removeDepenseBtn").button('reset');
							if(response.success == true) {
								// reload the brand table 
								manageDepenseTable.ajax.reload(null, false);
								// hide the remove modal 
								$('#removeDepenseModal').modal('hide');

								
								
								$('.remove-messages').html('<div class="alert alert-success">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
						          '</div>');

						  	  			$(".alert-success").delay(500).show(10, function() {
													$(this).delay(3000).hide(10, function() {
														$(this).remove();
													});
												}); // /.alert
							} else {
								$('.remove-messages').html('<div class="alert alert-success">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
						          '</div>');

						  	  			$(".alert-success").delay(500).show(10, function() {
													$(this).delay(3000).hide(10, function() {
														$(this).remove();
													});
												}); // /.alert
							} // /else
						} // /response messages
					}); // /ajax function to remove the brand

				}); // /click on remove button to remove the brand

			} // /success
		}); // /ajax

		$('.removeBrandFooter').after();
	} else {
		alert('error!! Refresh the page again');
	}
} // /remove brands function

function attacheFacture(id_depense = null) {
	if(id_depense) {
		//alert(id_depense);
		//$('#depense_id').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedDepense.php',
			type: 'post',
			data: {id_depense : id_depense},
			dataType: 'json',
			success:function(response) {
				//$('.removeBrandFooter').after('<input type="hidden" name="depense_id" id="depense_id" value="'+response.id_depense+'" /> ');
				$("#factureAttache").text(response.ref_depense);
				$("#depense_id").val(response.id_depense);
				// click on remove button to remove the brand

				$("#submitfactureDepenseForm").unbind('submit').bind('submit', function() {
						
						var form = $(this);
						
						// button loading
						//$("#createBordereauBtn").button('loading');

					$.ajax({
						url : form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),	
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
							// button loading
							$("#createBordereauBtn").button('reset');
							if(response.success == true) {
								$("#submitfactureDepenseForm")[0].reset();

								// hide the remove modal 
								$('#attacheFactureDepenseDepenseModal').modal('hide');
								// reload the brand table 
								manageDepenseTable.ajax.reload(null, false);
								$('.remove-messages').html('<div class="alert alert-success">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
						          '</div>');

						  	  			$(".alert-success").delay(500).show(10, function() {
											$(this).delay(3000).hide(10, function() {
												$(this).remove();
											});
										}); // /.alert
							}else{
								$('.remove-messages').html('<div class="alert alert-danger">'+
						            '<button type="button" class="close" data-dismiss="alert">&times;</button>'+
						            '<strong><i class="glyphicon glyphicon-ok-sign"></i></strong> '+ response.messages +
						          '</div>');

						  	  	$(".alert-danger").delay(500).show(10, function() {
									$(this).delay(3000).hide(10, function() {
										$(this).remove();
									});
								}); // /.alert
							}

						}
					});

				});
			}

		});
	}
}