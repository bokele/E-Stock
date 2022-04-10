$(document).ready(function() {

	var manageSortieTable;
$("#navDepense").addClass('active');
	$('#topNavManageSortie').addClass('active');
		// order date picker
		$("#date_sortie").datepicker();
		$("#date_depense").datepicker();

			manageSortieTable = $("#manageSortieTable").DataTable({
		'ajax': 'php_action/fetchSortie.php',
		'order': [],
			"columnDefs":[  
                {  
                    "targets":[5],  
                    "orderable":false,  
                },  
           ]
	});	

	$("#getSortieForm").unbind('submit').bind('submit', function() {
			var form = $(this);
			$('.form-group').removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove();

			var date_sortie = $("#date_sortie").val();
			var observation_sortie = $("#observation_sortie").val();
			var autorise_sortie = $("#autorise_sortie").val();

			var montantAfficheValue = $("#montantAfficheValue").val();
			prix_total_achatValue
			

			if(date_sortie == "") {
				$("#date_sortie").after('<p class="text-danger"> Le champ Date  est obligatoire </p>');
				$('#date_sortie').closest('.form-group').addClass('has-error');
			} else {
				$('#date_sortie').closest('.form-group').addClass('has-success');
			} // /else

			if(observation_sortie == "") {
				$("#observation_sortie").after('<p class="text-danger"> Le champ observation est obligatoire </p>');
				$('#observation_sortie').closest('.form-group').addClass('has-error');
			} else {
				$('#observation_sortie').closest('.form-group').addClass('has-success');
			} // /else
			if(autorise_sortie == "") {
				$("#autorise_sortie").after('<p class="text-danger"> Le champ autorisé est obligatoire </p>');
				$('#autorise_sortie').closest('.form-group').addClass('has-error');
			} else {
				$('#autorise_sortie').closest('.form-group').addClass('has-success');
			} // /else
			
			// array validation
			var libelle_sortie = document.getElementsByName('libelle_sortie[]');				
			var validateProduct;
			for (var x = 0; x < libelle_sortie.length; x++) {       			
				var libelle_sortieId = libelle_sortie[x].id;	    	
		    if(libelle_sortie[x].value == ''){	    		    	
		    	$("#"+libelle_sortieId+"").after('<p class="text-danger"> Le désignation est obligatoire!! </p>');
		    	$("#"+libelle_sortieId+"").closest('.form-group').addClass('has-error');	    		    	    	
	      } else {      	
		    	$("#"+libelle_sortieId+"").closest('.form-group').addClass('has-success');	    		    		    	
	      }          
	   	} // for

	   	for (var x = 0; x < libelle_sortie.length; x++) {       						
		    if(libelle_sortie[x].value){	    		    		    	
		    	validateProduct = true;
	      } else {      	
		    	validateProduct = false;
	      }          
	   	} // for 

	   	var quantite_sortie = document.getElementsByName('quantite_sortie[]');		   	
	   	var validateQuantity;
	   	for (var x = 0; x < quantite_sortie.length; x++) {       
	 			var quantityId = quantite_sortie[x].id;
		    if(quantite_sortie[x].value == ''){	    	
		    	$("#"+quantityId+"").after('<p class="text-danger"> Le Champ Quantité est obligatoire!! </p>');
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+quantityId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < quantite_sortie.length; x++) {       						
		    if(quantite_sortie[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for

	   		var prix_achat_sortie = document.getElementsByName('prix_achat_sortie[]');		   	
	   	var validatePrix;
	   	for (var x = 0; x < prix_achat_sortie.length; x++) {       
	 			var prix_achat_sortieId = prix_achat_sortie[x].id;
		    if(prix_achat_sortie[x].value == ''){	    	
		    	$("#"+prix_achat_sortieId+"").after('<p class="text-danger"> Le Champ montant est obligatoire!! </p>');
		    	$("#"+prix_achat_sortieId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+prix_achat_sortieId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < prix_achat_sortie.length; x++) {       						
		    if(prix_achat_sortie[x].value){	    		    		    	
		    	validatePrix = true;
	      } else {      	
		    	validatePrix = false;
	      }          
	   	} // for

			if(date_sortie && observation_sortie && autorise_sortie ) {
				if(validateProduct == true && validateQuantity == true && validatePrix == true) {
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
								manageSortieTable.ajax.reload(null, false);
								$("#getSortieForm")[0].reset();
									$("#addDepenseModal").show("hide");
								$("remove-messages").html('<div class="alert alert-success">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong ><h3><i class="glyphicon glyphicon-ok-sign"></i></strong><h3 align="center"> '+ response.messages +
				            	' </h3><br /> <br /> <a href="php_action/printSortie.php?SortieId='+response.id_bonSortie+'" class="btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Print </a>'+
				            	'<a href="orders.php?o=add" class="btn btn-default" style="margin-left:10px;"> <i class="glyphicon glyphicon-plus-sign"></i> Add New Order </a>'+
				            	
				   		       '</div>');
									
								$("html, body, div.panel, div.pane-body").animate({scrollTop: '0px'}, 100);

								// disabled te modal footer button
								$(".submitButtonFooter").addClass('div-hide');
								// remove the product row
								$(".removeProductRowBtn").addClass('div-hide');
								
							} else {
								$("#remove-messages").html('<div class="alert alert-danger">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong ><h3><i class="glyphicon glyphicon-ok-sign"></i></strong><h3 align="center"> '+ response.messages +
				            	
				            	
				            	
				   		       '</div>');								
							}
						} // /response
					}); // /ajax

				}
				return false;
			}

			return false;
		});

// create order form function
		$("#editDepenseForm").unbind('submit').bind('submit', function() {
			var form = $(this);
			$('.form-group').removeClass('has-error').removeClass('has-success');
			$('.text-danger').remove();

			var date_depense = $("#date_depense").val();
			var demende_depense = $("#demende_depense").val();
			var autorisation_depense = $("#autorisation_depense").val();
			var prix_total_achatValue = $("#prix_total_achatValue").val();
			
			

			if(date_depense == "") {
				$("#date_depense").after('<p class="text-danger"> Le champ Date  est obligatoire </p>');
				$('#date_depense').closest('.form-group').addClass('has-error');
			} else {
				$('#date_depense').closest('.form-group').addClass('has-success');
			} // /else

			if(demende_depense == "") {
				$("#demende_depense").after('<p class="text-danger"> Le champ demandé est obligatoire </p>');
				$('#demende_depense').closest('.form-group').addClass('has-error');
			} else {
				$('#demende_depense').closest('.form-group').addClass('has-success');
			} // /else
			if(autorisation_depense == "") {
				$("#autorisation_depense").after('<p class="text-danger"> Le champ autorisé est obligatoire </p>');
				$('#autorisation_depense').closest('.form-group').addClass('has-error');
			} else {
				$('#autorisation_depense').closest('.form-group').addClass('has-success');
			} // /else
			
			// array validation
			var libelle_depense = document.getElementsByName('libelle_depense[]');				
			var validateProduct;
			for (var x = 0; x < libelle_depense.length; x++) {       			
				var libelle_depenseId = libelle_depense[x].id;	    	
		    if(libelle_depense[x].value == ''){	    		    	
		    	$("#"+libelle_depenseId+"").after('<p class="text-danger"> Le désignation est obligatoire!! </p>');
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
		    	$("#"+quantityId+"").after('<p class="text-danger"> Le Champ Quantité est obligatoire!! </p>');
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
	   	var validateQuantity;
	   	for (var x = 0; x < prix_achat.length; x++) {       
	 			var prix_achatId = prix_achat[x].id;
		    if(prix_achat[x].value == ''){	    	
		    	$("#"+prix_achatId+"").after('<p class="text-danger"> Le Champ Quantité est obligatoire!! </p>');
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-error');	    		    		    	
	      } else {      	
		    	$("#"+prix_achatId+"").closest('.form-group').addClass('has-success');	    		    		    		    	
	      } 
	   	}  // for

	   	for (var x = 0; x < prix_achat.length; x++) {       						
		    if(prix_achat[x].value){	    		    		    	
		    	validateQuantity = true;
	      } else {      	
		    	validateQuantity = false;
	      }          
	   	} // for

			if(date_depense && demende_depense ) {
				if(validateProduct == true && validateQuantity == true) {
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
								manageDepenseTable.ajax.reload(null, false);
								$("#getdepenseForm")[0].reset();
									// create order button
								$("remove-messages").html('<div class="alert alert-success">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong ><h3><i class="glyphicon glyphicon-ok-sign"></i></strong><h3 align="center"> '+ response.messages +
				            	' </h3><br /> <br /> <a href="php_action/printCommande.php?commandeId='+response.commande_id+'" class="btn btn-primary"> <i class="glyphicon glyphicon-print"></i> Print </a>'+
				            	'<a href="orders.php?o=add" class="btn btn-default" style="margin-left:10px;"> <i class="glyphicon glyphicon-plus-sign"></i> Add New Order </a>'+
				            	
				   		       '</div>');
									
								$("html, body, div.panel, div.pane-body").animate({scrollTop: '0px'}, 100);

								// disabled te modal footer button
								$(".submitButtonFooter").addClass('div-hide');
								// remove the product row
								$(".removeProductRowBtn").addClass('div-hide');
								
							} else {
								$("#remove-messages").html('<div class="alert alert-danger">'+
				            	'<button type="button" class="close" data-dismiss="alert">&times;</button>'+
				            	'<strong ><h3><i class="glyphicon glyphicon-ok-sign"></i></strong><h3 align="center"> '+ response.messages +
				            	
				            	
				            	
				   		       '</div>');								
							}
						} // /response
					}); // /ajax

				}
				return false;
			}

			return false;



		});

});

function addRow() {

	if ($("#date_sortie").val() != "") {
		$("#addRowBtn").button("loading");

	var tableLength = $("#sortieTable tbody tr").length;

	var tableRow;
	var arrayNumber;
	var count;

	if(tableLength > 0) {		
		
		
		tableRow = $("#sortieTable tbody tr:last").attr('id');
		arrayNumber = $("#sortieTable tbody tr:last").attr('class');
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

					'<input type="text" class="form-control" name="libelle_sortie[]" id="libelle_sortie'+count+'"  >';//+
						
					tr += '</div>'+
					
				'</td>'+
				'<td style="padding-left:20px;">'+
					'<input type="number" name="quantite_sortie[]" id="quantite_sortie'+count+'" onkeyup="getTotal('+count+')" autocomplete="off" class="form-control" min="1" value="1"/>'+
				'</td>'+
				'<td style="padding-left:20px;"">'+
					
						'<input type="number" name="prix_achat_sortie[]" id="prix_achat_sortie'+count+'" onkeyup="getTotal('+count+')" autocomplete="off"  class="form-control" value="0"/>'+
					
				'</td>'+

				
				'<td style="padding-left:20px;">'+
				'<div class="form-group">'+
					'<input type="text" name="prix_achat_total_sortie[]" id="prix_achat_total_sortie'+count+'" autocomplete="off" class="form-control" disabled="true" value="0.00"/>'+
					'<input type="hidden" name="prix_achat_total_sortieValue[]" id="prix_achat_total_sortieValue'+count+'" autocomplete="off" class="form-control" />'+
				'</div>'+
				'</td>'+
				'<td>'+
					'<button class="btn btn-danger removeProductRowBtn" type="button" onclick="removeDepenseRow('+count+')"><i class="glyphicon glyphicon-trash"></i></button>'+
				'</td>'+
				
			'</tr>';
			if(tableLength > 0) {							
				$("#sortieTable tbody tr:last").after(tr);
			} else {				
				$("#sortieTable tbody").append(tr);
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
		
		var total = Number($("#prix_achat_sortie"+row).val()) * Number($("#quantite_sortie"+row).val());

		total = total.toFixed(2);
		$("#prix_achat_total_sortie"+row).val(total);
		$("#prix_achat_total_sortieValue"+row).val(total);

		subAmount();



	} else {
		alert('pas de rang !! veuillez rafraîchir la page');
	}
}

function subAmount() {
	var tableProductLength = $("#sortieTable tbody tr").length;
	var totalSubAmount = 0;

	var quantite =0;
	for(x = 0; x < tableProductLength; x++) {
		var tr = $("#sortieTable tbody tr")[x];
		var count = $(tr).attr('id');
		count = count.substring(3);

		totalSubAmount = Number(totalSubAmount) + Number($("#prix_achat_total_sortie"+count).val());
		$("#quantite_totalAffiche").val(quantite);
		quantite += Number($("#quantite_sortie"+count).val());

	} // /for



	totalSubAmount = totalSubAmount.toFixed(2);

	// sub total
	$("#montantAffiche").val(totalSubAmount);
	$("#montantAfficheValue").val(totalSubAmount);
	//$("#quantite_totalAffiche").val(quantite);
	//$("#quantite_total").val(quantite);

}

function payementSortie(id_sortie = null) {
	if(id_sortie) {
		$("#date_facture").datepicker();
		
		
		$.ajax({
			url: 'php_action/fetchSelectedSortie.php',
			type: 'post',
			data: {id_sortie : id_sortie},
			dataType: 'json',
			success:function(response) {
				$('#depensePayementId').val(response.id_bonSortie);
				$("#paiement").text(response.ref_sortie);
				$("#prix_achat_depense").val(response.montant);
				$("#autorisation_depenseEdit").val(response.autorise_sortie);
				$("#dateemission").val(response.date_sortie);
				$("#montant").val(response.montant);
				$("#prix_achat_depenseValue").val(response.montant);
				// click on remove button to remove the brand
				$("#getpaiementForm").unbind('submit').bind('submit', function() {
					// button loading
					var form = $(this);
					
					
					
					var id_classe 					= $("#id_classe").val();
					var id_Compte 					= $("#id_Compte").val();
					var id_sous_compte 				= $("#id_sous_compte").val();
					var paymentType 				= $("#paymentType").val();
					var paymentStatusPayement 		= $("#paymentStatusPayement").val();
					var montant 					= $("#montant").val();
					var observation 				= $("#observation").val();
					var depensePayementId 			= $("#depensePayementId").val();

				
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
					}	else {
						// remov error text field
						$("#montant").find('.text-danger').remove();
						// success out for form 
						$("#montant").closest('.form-group').addClass('has-success');	  	
					}	// /else

						if(observation == "") {
						$("#observation").after('<p class="text-danger">Votre motif est obligatoire</p>');
						$('#observation').closest('.form-group').addClass('has-error');
					}	else {
						// remov error text field
						$("#observation").find('.text-danger').remove();
						// success out for form 
						$("#observation").closest('.form-group').addClass('has-success');	  	
					}	// /else
						var montant = montant.toFixed(2);
						var zero =0;
						zero = zero.toFixed(2);
					
					if(date_facture && observation && id_classe && id_Compte && id_sous_compte && paymentType && paymentStatusPayement && montant ) {
						
						if (paymentStatusPayement == 1 && montant != prix_achat_depenseValue) {
							alert("le status de paiement est incorrect par rapport du montant payé, le status devrait être avance");
						}
						else if (montant == zero  && paymentStatus != 3 ) {
							alert("le status de paiement est incorrect par rapport du montant payé, le status devrait être crédit");
						}else{
							$.ajax({
							url : form.attr('action'),
							type: form.attr('method'),
							data: form.serialize(),	
							dataType: 'json',
							cache: false,
							contentType: false,
							processData: false,
							dataType: 'json',
								success:function(response){
									//console.log(response);
								
									// button loading
									$("#createpayementDepenseBtn").button('reset');
									if(response.success == true) {

										// hide the remove modal  
										$('#addPayementDepenseModal').modal('hide');

										// reload the brand table 
										$("#getpaiementForm")[0].reset();
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
						}
					
					}
				return false;

				}); // /click on remove button to remove the brand

			} // /success
		}); // /ajax

		$('.removeBrandFooter').after();
	} else {
		alert('error!! Refresh the page again');
	}
} // /remove brands function

function attacheFacture(id_sortie = null) {
	if(id_sortie) {
		//alert(id_depense);
		$('#depense_id').remove();
		
		$.ajax({
			url: 'php_action/fetchSelectedSortie.php',
			type: 'post',
			data: {id_sortie : id_sortie},
			dataType: 'json',
			success:function(response) {
				$('.removeBrandFooter').after('<input type="hidden" name="id_sortie" id="id_sortie" value="'+response.id_bonSortie+'" /> ');
				$("#factureAttache").text(response.ref_depense);
				// click on remove button to remove the brand
				$("#submitBordereauForm").unbind('submit').bind('submit', function() {

					var form = $(this);
					// button loading
					$("#createBordereauBtn").button('loading');

					$.ajax({
						url: form.attr('action'),
						type: form.attr('method'),
						data: form.serialize(),
						dataType: 'json',
						success:function(response) {
							console.log(response);
								
													// button loading
							$("#createBordereauBtn").button('reset');
							if(response.success == true) {
								$("#submitBordereauForm")[0].reset();

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

function viewSortie(sortieId = null){

	var table='<thead class="thead-dark"><tr><th scope="col">#</th><th scope="col">Produit</th><th scope="col">Quantité</th><th scope="col">PU</th><th scope="col">PT-HTVA</th></tr></thead>';
	if(sortieId) {
		$.ajax({
			url: 'php_action/fetchSortieDataDetail.php',
			type: 'post',
			data: {sortieId: sortieId},
			dataType: 'json',
			success:function(response){

				$("#tableDatail").html(response);
			}
		});
	}	
}