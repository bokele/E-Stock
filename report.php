<?php require_once 'includes/header.php'; ?>
<br><br>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<i class="fa fa-flag"></i>	Génére un Rapport
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="" method="post" id="getOrderReportForm">
				  <div class="form-group">
		        	<label for="productStatus" class="col-sm-3 control-label">Type </label>
					    <div class="col-sm-9">
					      <select class="form-control" id="productStatus" name="productStatus">
					      	<option value="">~~SELECT~~</option>
					      	<option value="0">Etat du Stock Liquids</option>
					      	<option value="1">Etat du Stock Savonor</option>
					      	<option value="2">Liste des Ventes</option>
					      	<option value="3">Liste des Ventes detail</option>
					      	<option value="4">Liste des Ventes Payé</option>
					      	<option value="5">Liste des Ventes Credit</option>
					      	<option value="6">Liste des Ventes Avance</option> 
					      </select>
					    </div>
		        </div> <!-- /form-group-->
				  <div class="form-group">
				    <label for="startDate" class="col-sm-3 control-label">Début</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="startDate" name="startDate" placeholder="Date de fin" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate" class="col-sm-3 control-label">Fin</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="endDate" name="endDate" placeholder="Date de fin" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-5 col-sm-10">
				      <button type="submit" class="btn btn-primary" id="generateReportBtn"> <i class="fa fa-file"></i> Générer</button>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
	<!-- /col-dm-12 -->
	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<i class="fa fa-flag"></i>	Génére un Rapport Par Fournisseur pour le semi-distributeurs
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="" method="post" id="getFournisseurReportForm">
				  <div class="form-group">
		        	<label for="productStatus" class="col-sm-3 control-label">Fournisseur </label>
					    <div class="col-sm-9">
					      <select class="form-control" id="productStatusClient" name="productStatusClient">
					      	<option value="">~~SELECT~~</option>
					      	<?php 
				      			$sql = "SELECT brand_id, brand_name FROM brands   ORDER BY brand_name ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
					      </select>
					    </div>
		        </div> <!-- /form-group-->
				  <div class="form-group">
				    <label for="startDate" class="col-sm-3 control-label">Début</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="startDateClient" name="startDateClient" placeholder="Date de Début" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate" class="col-sm-3 control-label">fin</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="endDateClient" name="endDateClient" placeholder="Date de fin" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-5 col-sm-10">
				      <button type="submit" class="btn btn-info" id="generateReportBtn"> <i class="fa fa-file"></i> Générer</button>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
		<div class="col-md-6">
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-flag"></i>	Génére un Rapport Par Fournisseur, Chiffre d'affaires
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="" method="post" id="getFournisseurChiffreAffaireReportForm">
				  <div class="form-group">
		        	<label for="productStatus" class="col-sm-3 control-label">Fournisseur </label>
					    <div class="col-sm-9">
					      <select class="form-control" id="productStatusChiffre" name="productStatusChiffre">
					      	<option value="">~~SELECT~~</option>
					      	<?php 
				      			$sql = "SELECT brand_id, brand_name FROM brands   ORDER BY brand_name ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
					      </select>
					    </div>
		        </div> <!-- /form-group-->
				  <div class="form-group">
				    <label for="startDate" class="col-sm-3 control-label">Début</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="startDateChiffre" name="startDateChiffre" placeholder="Date de Début" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate" class="col-sm-3 control-label">Fin</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="endDateChiffre" name="endDateChiffre" placeholder="Date de fin" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-5 col-sm-10">
				      <button type="submit" class="btn btn-default" id="generateReportChiffreBtn"> <i class="fa fa-file"></i> Générer</button>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
		<div class="col-md-6">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<i class="fa fa-flag"></i>	Génére un Rapport Par Client
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="" method="post" id="getClientReportForm">
				  <div class="form-group">
		        	<label for="productStatus" class="col-sm-3 control-label">Client </label>
					    <div class="col-sm-9">
					      <select class="form-control" id="productStatusClientReport" name="productStatusClientReport">
					      	<option value="">~~SELECT~~</option>
					      	<?php 
				      			$sql = "SELECT 	id_client, nom_client, prenom_client FROM client   ORDER BY nom_client ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]." ".$row[2]."</option>";
								} // while
								
				      	?>
					      </select>
					    </div>
		        </div> <!-- /form-group-->
				  <div class="form-group">
				    <label for="startDate" class="col-sm-3 control-label">Début</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="startDateClientReport" name="startDateClientReport" placeholder="Date de Début" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate" class="col-sm-3 control-label">Fin</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="endDateClientReport" name="endDateClientReport" placeholder="Date de fin" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-5 col-sm-10">
				      <button type="submit" class="btn btn-warning" id="generateReportBtn"> <i class="fa fa-file"></i> Générer</button>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-danger">
			<div class="panel-heading">
				<i class="fa fa-flag"></i>	Génére un Rapport par Gestion
			</div>
			<!-- /panel-heading -->
			<div class="panel-body">
				
				<form class="form-horizontal" action="" method="post" id="getCaisseReportForm">
				   <div class="form-group">
		        	<label for="productStatus" class="col-sm-3 control-label">Type </label>
					    <div class="col-sm-9">
					      <select class="form-control" id="productStatusCaisse" name="productStatusCaisse">
					      	<option value="">~~SELECT~~</option>
					      	<option value="0">Commande</option>
					      	<option value="1">Depense</option>
					      	<option value="2">Sortie</option>
					      </select>
					    </div>
		        </div> <!-- /form-group-->
				  <div class="form-group">
				    <label for="startDate" class="col-sm-3 control-label">Début</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="startDateCaisse" name="startDateCaisse" placeholder="Date de Début" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <label for="endDate" class="col-sm-3 control-label">Fin</label>
				    <div class="col-sm-9">
				      <input type="text" class="form-control" id="endDateCaisse" name="endDateCaisse" placeholder="Date de fin" autocomplete="off" />
				    </div>
				  </div>
				  <div class="form-group">
				    <div class="col-sm-offset-5 col-sm-10">
				      <button type="submit" class="btn btn-danger" id="generateReportBtn"> <i class="fa fa-file"></i> Générer</button>
				    </div>
				  </div>
				</form>

			</div>
			<!-- /panel-body -->
		</div>
	</div>

</div>
<!-- /row -->

<!-- <script src="custom/js/report.js"></script> -->

<?php require_once 'includes/footer.php'; ?>
<script type="text/javascript">
	$(document).ready(function() {
		$('#navReport').addClass('active');
	// order date picker
	$("#startDate").datepicker();
	// order date picker
	$("#endDate").datepicker();

	$("#startDateClient").datepicker();
	// order date picker
	$("#endDateClient").datepicker();
	$("#startDateCaisse").datepicker();
	// order date picker
	$("#endDateCaisse").datepicker();

	$("#startDateClientAgence").datepicker();
	// order date picker
	$("#endDateClientAgence").datepicker();

	$("#startDateClientReport").datepicker(); 
	$("#endDateClientReport").datepicker();
	
	$("#endDateChiffre").datepicker();
	$("#startDateChiffre").datepicker();

	//$("#getOrderReportForm").unbind('submit').bind('submit', function() {
		$(document).on("submit","#getOrderReportForm", function(event){
		
			event.preventDefault();
		var startDate = $("#startDate").val();
		var endDate = $("#endDate").val();
		var productStatus = $("#productStatus").val();

		if(startDate == "" || endDate == "" || productStatus=="") {
			if(startDate == "") {
				$("#startDate").closest('.form-group').addClass('has-error');
				$("#startDate").after('<p class="text-danger">Date de debut est obligatoir</p>');
				$("#startDate").closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#startDate").closest('.form-group').addClass('has-success');	
			}

			if(endDate == "") {
				$("#endDate").closest('.form-group').addClass('has-error');
				$("#endDate").after('<p class="text-danger">Date de fin est obligatoir</p>');
				$('#endDate').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#endDate").closest('.form-group').addClass('has-success');	
			}
			if(productStatus=="") {
				$("#productStatus").closest('.form-group').addClass('has-error');
				$("#productStatus").after('<p class="text-danger">Type de rapport est obligatoir</p>');
				$('#productStatus').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#productStatus").closest('.form-group').addClass('has-success');	
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();
			$(".form-group").closest('.form-group').addClass('has-success');	

			//var form = $(this);
			//// Liste de commande en general sythese de commandes
			if (productStatus == 2) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getOrderReport.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}else if(productStatus == 3){
				$.ajax({
				
					url: "php_action/getOrderReportDetail.php",
					method:'POST',  
	                data:new FormData(this),  
	                contentType:false,  
                processData:false, 
				dataType: 'text',
					success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
					} // /success
				});	// /ajax
			}else if (productStatus == 0) {
				$.ajax({
				url: "php_action/getProductReportLiquids.php",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else liquids
			else if (productStatus == 1) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getProductReportSavonor.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else savonor

			else if (productStatus == 4) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getProductReportPaid.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else paye
			else if (productStatus == 5) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getProductReportCredit.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else credit
			else if (productStatus ==6) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getProductReportAvance.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else credit
		} // /else

		return false;
			
	});

	$(document).on("submit","#getFournisseurReportForm", function(event){
		
			event.preventDefault();
		var startDateClient  = $("#startDateClient").val();
		var endDateClient  = $("#endDateClient").val();
		var productStatusClient = $("#productStatusClient").val();

		if(startDateClient == "" || endDateClient  == "" || productStatusClient =="") {
			if(startDate == "") {
				$("#startDateClient").closest('.form-group').addClass('has-error');
				$("#startDateClient").after('<p class="text-danger">Date de debut est obligatoir</p>');
				$("#startDateClient").closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#startDateClient").closest('.form-group').addClass('has-success');	
			}

			if(endDateClient  == "") {
				$("#endDateClient").closest('.form-group').addClass('has-error');
				$("#endDateClient").after('<p class="text-danger">Date de fin est obligatoir</p>');
				$('#endDateClient').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#endDateClient").closest('.form-group').addClass('has-success');	
			}
			if(productStatusClient=="") {
				$("#productStatusClient").closest('.form-group').addClass('has-error');
				$("#productStatusClient").after('<p class="text-danger">Type de rapport est obligatoir</p>');
				$('#productStatusClient').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#productStatusClient").closest('.form-group').addClass('has-success');	
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();
			$(".form-group").closest('.form-group').addClass('has-success');
			$.ajax({
				url: "php_action/getClientReportDetail.php",
					method:'POST',  
	                data:new FormData(this),  
	                contentType:false,  
                processData:false, 
				dataType: 'text',
					success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
					} // /success
				});	// /ajax

		}		
});

	$(document).on("submit","#getCaisseReportForm", function(event){
		
			event.preventDefault();
		var startDateCaisse  = $("#startDateCaisse").val();
		var endDateCaisse  = $("#endDateCaisse").val();
		var productStatusCaisse  = $("#productStatusCaisse").val();

		if(startDateCaisse == "" || startDateCaisse  == "" || productStatusCaisse =="") {
			if(startDateCaisse == "") {
				$("#startDateCaisse").closest('.form-group').addClass('has-error');
				$("#startDateCaisse").after('<p class="text-danger">Date de debut est obligatoir</p>');
				$("#startDateCaisse").closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#startDateCaisse").closest('.form-group').addClass('has-success');	
			}

			if(endDateCaisse  == "") {
				$("#endDateCaisse").closest('.form-group').addClass('has-error');
				$("#endDateCaisse").after('<p class="text-danger">Date de fin est obligatoir</p>');
				$('#endDateCaisse').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#endDateCaisse").closest('.form-group').addClass('has-success');	
			}
			if(productStatusCaisse  == "") {
				$("#productStatusCaisse").closest('.form-group').addClass('has-error');
				$("#productStatusCaisse").after('<p class="text-danger">Date de fin est obligatoir</p>');
				$('#productStatusCaisse').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#productStatusCaisse").closest('.form-group').addClass('has-success');	
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();
			$(".form-group").closest('.form-group').addClass('has-success');

			if (productStatusCaisse == 0) {
				$.ajax({
				url: "php_action/getCaisseCommandeReport.php",
					method:'POST',  
	                data:new FormData(this),  
	                contentType:false,  
                processData:false, 
				dataType: 'text',
					success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
					} // /success
				});	// /ajax
			}else if (productStatusCaisse == 1) {
				$.ajax({
				url: "php_action/getCaisseDepenseReport.php",
					method:'POST',  
	                data:new FormData(this),  
	                contentType:false,  
                processData:false, 
				dataType: 'text',
					success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
					} // /success
				});	// /ajax
			}else if (productStatusCaisse == 2) {
				$.ajax({
				url: "php_action/getCaisseSortieReport.php",
					method:'POST',  
	                data:new FormData(this),  
	                contentType:false,  
                processData:false, 
				dataType: 'text',
					success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
					} // /success
				});	// /ajax
			}
			

		}		
});

$(document).on("submit","#getClientReportAgenceForm", function(event){
 
			event.preventDefault();
		var productStatusClientAgence  = $("#productStatusClientAgence").val();
		var productStatusAgence  = $("#productStatusAgence").val();
		var startDateClientAgence  = $("#startDateClientAgence").val();
		var endDateClientAgence  = $("#endDateClientAgence").val();

		if(productStatusClientAgence == "" || productStatusAgence  == "" || startDateClientAgence == "" ||  productStatusAgence =="") {
			if(productStatusClientAgence == "") {
				$("#productStatusClientAgence").closest('.form-group').addClass('has-error');
				$("#productStatusClientAgence").after('<p class="text-danger">Obligatoir</p>');
				$('#productStatusClientAgence').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#productStatusClientAgence").closest('.form-group').addClass('has-success');	
			}
			if(productStatusAgence == "") {
				$("#productStatusAgence").closest('.form-group').addClass('has-error');
				$("#productStatusAgence").after('<p class="text-danger">Obligatoir</p>');
				$('#productStatusAgence').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#productStatusAgence").closest('.form-group').addClass('has-success');	
			}
			if(startDateClientAgence == "") {
				$("#startDateClientAgence").closest('.form-group').addClass('has-error');
				$("#startDateClientAgence").after('<p class="text-danger">Obligatoir</p>');
				$("#startDateClientAgence").closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#startDateClientAgence").closest('.form-group').addClass('has-success');	
			}

			if(endDateClientAgence  == "") {
				$("#endDateClientAgence").closest('.form-group').addClass('has-error');
				$("#endDateClientAgence").after('<p class="text-danger">Obligatoir</p>');
				$('#endDateClientAgence').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#endDateClientAgence").closest('.form-group').addClass('has-success');	
			}
			
		} else {
				$(".form-group").removeClass('has-error');
			$(".text-danger").remove();
			$(".form-group").closest('.form-group').addClass('has-success');	

			//var form = $(this);
			//// Liste de commande en general sythese de commandes
			if (productStatusAgence == 2) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getOrderReportAgence.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}else if(productStatusAgence == 3){
				$.ajax({
				
					url: "php_action/getOrderReportDetailAgence.php",
					method:'POST',  
	                data:new FormData(this),  
	                contentType:false,  
                processData:false, 
				dataType: 'text',
					success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
					} // /success
				});	// /ajax
			}else if (productStatusAgence == 0) {
				$.ajax({
				url: "php_action/getProductReportLiquidsAgence.php",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else liquids
			else if (productStatusAgence == 1) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getProductReportSavonor.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else savonor

			else if (productStatusAgence == 4) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getProductReportPaid.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else paye
			else if (productStatusAgence == 5) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getProductReportCredit.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else credit
			else if (productStatusAgence ==6) {
				$.ajax({
				//url: form.attr('action'),
				url: "php_action/getProductReportAvance.php",
				//type: "form.attr('method'),"
				//type:"POST",
				method:'POST',  
                data:new FormData(this),  
                contentType:false,  
                processData:false, 
				//dataType: 'text',
				success:function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
				} // /success
			});	// /ajax
			}//else credit

			

		}		
});


	$(document).on("submit","#getClientReportForm", function(event){
		
			event.preventDefault();
		var startDateClientReport  = $("#startDateClientReport").val();
		var endDateClientReport  = $("#endDateClientReport").val();
		var productStatusClientReport  = $("#productStatusClientReport").val();

		if(startDateClientReport == "" || endDateClientReport  == "" || productStatusClientReport =="") {
			if(startDateClientReport == "") {
				$("#startDateClientReport").closest('.form-group').addClass('has-error');
				$("#startDateClientReport").after('<p class="text-danger">Obligatoir</p>');
				$("#startDateClientReport").closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#startDateClientReport").closest('.form-group').addClass('has-success');	
			}

			if(endDateClientReport  == "") {
				$("#endDateClientReport").closest('.form-group').addClass('has-error');
				$("#endDateClientReport").after('<p class="text-danger">Obligatoir</p>');
				$('#endDateClientReport').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#endDateCaisse").closest('.form-group').addClass('has-success');	
			}
			if(productStatusClientReport  == "") {
				$("#productStatusClientReport").closest('.form-group').addClass('has-error');
				$("#productStatusClientReport").after('<p class="text-danger">Obligatoir</p>');
				$('#productStatusClientReport').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#productStatusClientReport").closest('.form-group').addClass('has-success');	
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();
			$(".form-group").closest('.form-group').addClass('has-success');

			if (productStatusCaisse) {
				$.ajax({
				url: "php_action/getClientReport.php",
					method:'POST',  
	                data:new FormData(this),  
	                contentType:false,  
                processData:false, 
				dataType: 'text',
					success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
					} // /success
				});	// /ajax
			}
			

		}		
});



	$(document).on("submit","#getFournisseurChiffreAffaireReportForm", function(event){
		
			event.preventDefault(); 
		var startDateChiffre  = $("#startDateChiffre").val();
		var endDateChiffre  = $("#endDateChiffre").val();
		var productStatusChiffre  = $("#productStatusChiffre").val();

		if(startDateChiffre == "" || endDateChiffre  == "" || productStatusChiffre =="") {
			if(startDateChiffre == "") {
				$("#startDateChiffre").closest('.form-group').addClass('has-error');
				$("#startDateChiffre").after('<p class="text-danger">Obligatoir</p>');
				$("#startDateChiffre").closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#startDateClientReport").closest('.form-group').addClass('has-success');	
			}

			if(endDateChiffre  == "") {
				$("#endDateChiffre").closest('.form-group').addClass('has-error');
				$("#endDateChiffre").after('<p class="text-danger">Obligatoir</p>');
				$('#endDateChiffre').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#endDateCaisse").closest('.form-group').addClass('has-success');	
			}
			if(productStatusChiffre  == "") {
				$("#productStatusChiffre").closest('.form-group').addClass('has-error');
				$("#productStatusChiffre").after('<p class="text-danger">Obligatoir</p>');
				$('#productStatusChiffre').closest('.form-group').addClass('has-error');
			} else {
				$(".form-group").removeClass('has-error');
				$(".text-danger").remove();
				$("#productStatusChiffre").closest('.form-group').addClass('has-success');	
			}
		} else {
			$(".form-group").removeClass('has-error');
			$(".text-danger").remove();
			$(".form-group").closest('.form-group').addClass('has-success');

			if (productStatusCaisse) {
				$.ajax({
				url: "php_action/getChiffreAffaireReport.php",
					method:'POST',  
	                data:new FormData(this),  
	                contentType:false,  
                processData:false, 
				dataType: 'text',
					success:function(response) {
						var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
			        mywindow.document.write('<html><head><title>Order Report Slip</title>');        
			        mywindow.document.write('</head><body>');
			        mywindow.document.write(response);
			        mywindow.document.write('</body></html>');
			        mywindow.document.close(); // necessary for IE >= 10
			        mywindow.focus(); // necessary for IE >= 10
			        mywindow.print();
			        mywindow.close();
					} // /success
				});	// /ajax
			}
			

		}		
});

});
</script>