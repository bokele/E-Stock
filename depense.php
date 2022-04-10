<?php require_once 'includes/header.php'; 



$depense ="" ;

if (isset($_GET["DP"])!="") {


// add order
	echo "<div class='div-request div-hide'>edit</div>";


$depense =$_GET["DP"];

$sql = "SELECT depenses.id_depense, depenses.ref_depense, depenses.prix_total_depense, depenses.date_depense, depenses.demende_depense, depenses.autorisation_depense, depenses.status_payement FROM depenses 	
	WHERE depenses.id_depense = {$depense}";

$result = $connect->query($sql);
$data = $result->fetch_row();

	?>
	<div class="remove-messages"></div>
<div class="panel panel-warning">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-pencil"></i>Modifier la depense N° : <span id="depnse_ref"><?php echo $data[1] ?></span></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

		<form class="form-horizontal" action="php_action/editDepense.php" method="post" id="editDepenseForm">
        		<div class="form-group">
        			<label for="date_depense" class="col-sm-2 control-label">Date : </label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" id="date_depenseEdit" name="date_depenseEdit" autocomplete="off" value="<?php echo $data[3] ?>"/>
					    </div>
							    
							    	
				</div>
					<div class="form-group">
				    	<label for="libelle_depense" class="col-sm-2 control-label">Demandé par : </label>
					    <div class="col-sm-4">
					        <input type="text" class="form-control" id="demende_depenseEdit" name="demende_depenseEdit" autocomplete="off" value="<?php echo $data[4] ?>"/>
					    </div>
				    	<label for="libelle_depense" class="col-sm-2 control-label">Autorisé par : </label>
					    <div class="col-sm-4">
					        <input type="text" class="form-control" id="autorisation_depenseEdit" name="autorisation_depenseEdit" autocomplete="off" value="<?php echo $data[5] ?>" />
					    </div>		    	
			  	</div>
				<div class="table-responsive">
			  <table class="table table-hover  table-striped table-outline mb-0 nowrap text-center" id="depenseTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;text-align: center;">DESIGNATION</th>
			  			<th style="width:15%;text-align: center;">QUANTITE</th>
			  			<th style="width:20%;text-align: center;">PRIX ACHAT</th>			  			
			  			<th style="width:15%;text-align: center;">PRIX TOTAL</th>			  			
			  			<th style="width:10%;text-align: center;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php
			  		$depenseItemSql = "SELECT depense_item.id_depesne_item, depense_item.id_depense, depense_item.libelle_depense, depense_item.quantite_depense, depense_item.prix_achat_depense, depense_item.prix_achat_total_depense FROM depense_item INNER JOIN depenses ON depenses.id_depense = depense_item.id_depense  WHERE  depense_item.id_depense = {$depense}";
						$depenseItemResult = $connect->query($depenseItemSql);
						
			  		$arrayNumber = 0;
			  		
			  		$x = 1;
			  		while($depsenseItemData = $depenseItemResult->fetch_array()) {  ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:20px;">
			  					<div class="form-group">
		  							<input type="text" class="form-control" name="libelle_depense[]" id="libelle_depense<?php echo $x; ?>" value="<?php echo $depsenseItemData[2] ?>">
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="number" name="quantite[]" id="quantite<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1"  value="<?php echo $depsenseItemData[3] ?>"/>	

			  				</td>
			  				<td style="padding-left:20px;">
			  					
			  						<input type="number" name="prix_achat[]" id="prix_achat<?php echo $x; ?>" autocomplete="off"  class="form-control" onkeyup="getTotal(<?php echo $x ?>)" value="<?php echo $depsenseItemData[4] ?>" />
			  					
			  				</td>
			  				<td style="padding-left:20px;">	
			  				<div class="form-group submitButtonFooter">		  					
			  					<input type="number" name="prix_achat_total[]" id="prix_achat_total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true"   value="<?php echo $depsenseItemData[5] ?>"/>

			  					<input type="hidden" name="prix_achat_totalValue[]" id="prix_achat_totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $depsenseItemData[5] ?>"/>
			  				</div>

			  				</td>
			  			
			  				<td>

			  					<button class="btn btn-danger removeCommandRowBtn" type="button" id="removeCommandRowBtn" onclick="removeDepenseRow(<?php echo $x; ?>)" ><i class="fa fa-trash  "></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
		  			$x++;
			  		} // /for
			  		?>
			  	</tbody>
			  </table>
			</div>
							  	
				 				
							  	
							  	<div class="form-group">
							    	
								        <input type="hidden" class="form-control" id="prix_total_achatValue" name="prix_total_achatValue" autocomplete="off" value="<?php echo $data[2] ?>"/>

								   <input type="hidden" class="form-control" id="id_depense" name="id_depense" autocomplete="off" value="<?php echo $data[0] ?>"/>
							    	<label for="libelle_depense" class="col-sm-3 control-label">TOTAL GENERAl : </label>
								    <div class="col-sm-5">
								        <input type="text" class="form-control" id="prix_total_achatAffiche" name="prix_total_achatAffiche" autocomplete="off" disabled="disabled"  value="<?php echo $data[2] ?>"/>
								    </div>
							    	
							    	
							  	</div>
							  	<div class="modal-footer editButtonFooter">
	      	 <button type="button" class="btn btn-info" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="fa fa-plus addRowBtn"></i> Ajoute un autre produit </button>
	      	
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="editDepenseBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
	      </div> <!-- /modal-footer -->	 	 
							 </form>		
		
			</div> <!-- /panel-body -->
		</div> <!-- /panel -->



	<?php
	# code...
}else{

?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Tableau de Bord</a></li>		  
		  <li>Depenses</li>
		  <li class="active">Gestion des dépenses</li>
		</ol>
		<div class="remove-messages"></div>
		<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-primary button1" data-toggle="modal" id="addpenseModalBtn" data-target="#addDepenseModal"> <i class="fa fa-plus"></i> Créer une nouvelle dépense  </button>
		</div> <!-- /div-action -->	
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-list"></i>Gestion des dépenses</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				

							
				<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageDepenseTable">
					<thead>
						<tr><th class="text-center" >Date</th>	
							<th class="text-center" >Réference</th>	
							<th class="text-center" >Montant</th>
							<th class="text-center" >Demandé par</th>
							<th class="text-center" >Autorisé par</th>
							<th class="text-center" >Status</th>
							<th style="width:15%;" class="text-center" >Options</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->
			</div>
			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->
<div class="modal fade" tabindex="-1" role="dialog" id="addDepenseModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> CREER UNE NOUVELLE DEPENSE</h4>
      </div>
      <div class="modal-body">
      	
        	<form class="form-horizontal" role="form"  action="php_action/createDepense.php" method="POST" id="getdepenseForm" >
        		<div class="form-group">
        			<label for="date_depense" class="col-sm-2 control-label">Date : </label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" id="date_depense" name="date_depense" autocomplete="off" />
					    </div>	    	
				</div>
				<div class="form-group">
			    	<label for="libelle_depense" class="col-sm-2 control-label">Demandé par : </label>
				    <div class="col-sm-4">
				        <input type="text" class="form-control" id="demende_depense" name="demende_depense" autocomplete="off" />
				    </div>
				    <label for="libelle_depense" class="col-sm-2 control-label">Autorisé par : </label>
				    <div class="col-sm-4">
				        <input type="text" class="form-control" id="autorisation_depense" name="autorisation_depense" autocomplete="off" />
				    </div>		    	
			  	</div>
				<div class="table-responsive">
			  <table class="table table-hover  table-striped table-outline mb-0 nowrap text-center" id="depenseTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;text-align: center;">DESIGNATION</th>
			  			<th style="width:15%;text-align: center;">QUANTITE</th>
			  			<th style="width:20%;text-align: center;">PRIX ACHAT</th>			  			
			  			<th style="width:15%;text-align: center;">PRIX TOTAL</th>			  			
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
		  							<input type="text" class="form-control" name="libelle_depense[]" id="libelle_depense<?php echo $x; ?>" autocomplete="off" >
			  					</div>
			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="number" name="quantite[]" id="quantite<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" />	

			  				</td>
			  				<td style="padding-left:20px;">
			  					
			  						<input type="number" name="prix_achat[]" id="prix_achat<?php echo $x; ?>" autocomplete="off"  class="form-control"  onkeyup="getTotal(<?php echo $x ?>)" />
			  					
			  				</td>
			  				<td style="padding-left:20px;">	
			  				<div class="form-group">		  					
			  					<input type="number" name="prix_achat_total[]" id="prix_achat_total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />

			  					<input type="hidden" name="prix_achat_totalValue[]" id="prix_achat_totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />
			  				</div>

			  				</td>
			  			
			  				<td>

			  					<button class="btn btn-danger removeCommandRowBtn" type="button" id="removeCommandRowBtn" onclick="removeDepenseRow(<?php echo $x; ?>)" ><i class="glyphicon glyphicon-trash  "></i></button>
			  				</td>
			  			</tr>
		  			<?php
		  			$arrayNumber++;
			  		} // /for
			  		?>
			  	</tbody>
			  </table>
			</div>
							  	
				 				
							  	
		  	<div class="form-group">
		    	
			        <input type="hidden" class="form-control" id="prix_total_achatValue" name="prix_total_achatValue" autocomplete="off" />
			   
		    	<label for="libelle_depense" class="col-sm-3 control-label">TOTAL GENERAL : </label>
			    <div class="col-sm-5">
			        <input type="text" class="form-control" id="prix_total_achatAffiche" name="prix_total_achatAffiche" autocomplete="off" disabled="disabled"  value="0.00"/>
			    </div>
		    	
		    	
		  	</div>
			<div class="modal-footer submitButtonFooter">
		      	<button type="button" class="btn btn-info" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="fa fa-plus addRowBtn"></i> Ajoute un autre produit </button>
		      	<button type="reset" class="btn btn-danger" onclick="resetCommandeForm()"><i class="fa fa-eraser"></i> ReInitialise</button>
		        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Close</button>
		        
		        <button type="submit" class="btn btn-primary" id="createDepenseBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
	      </div> <!-- /modal-footer -->	 	 
		</form>
    </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" tabindex="-1" role="dialog" id="addPayementDepenseModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-usd"></i> ENREGISTRE  PAIEMENT POUR : <span id="paiement"></span></h4>
      </div>
      <div class="modal-body">
      	<div id="add-Souscompte-messages"></div>
        	<form class="form-horizontal" action="php_action/createpayementFactureDepense.php" method="POST" id="getpaiementForm">
        		<div class="form-group">
        			<label for="date_commande" class="col-sm-2 control-label"><span class="text-danger">*</span>Date facture </label>
					    <div class="col-sm-4">
					      <input type="text" class="form-control" id="date_facture" name="date_facture" autocomplete="off" />
					    </div>
					    <label for="facture_depense" class="col-sm-2 control-label"><span class="text-danger">*</span>N° facture  </label>
								    <div class="col-sm-4">
								        <input type="text" class="form-control" id="facture_depense" name="facture_depense" placeholder="N° facture  ou Bordereau" autocomplete="off" />
								    </div>

							    	
							    	
							  	</div>
							  	<div class="form-group">

							  		<label for="nom_societe" class="col-sm-2 control-label"><span class="text-danger">*</span>Nom de classe</label>
							    	<div class="col-sm-4">
							      		<select class="form-control" id="id_classe" name="id_classe">
									      	<option value="">~~SELECT~~</option>
									      	<?php 
									      	$sql = "SELECT id, libelle_classe FROM comptabilite_classe_compte WHERE status=1 ORDER BY id ASC";
													$result = $connect->query($sql);

													while($row = $result->fetch_array()) {
														echo "<option value='".$row[0]."'>".$row[1]." - CLASSE ".$row[0]."</option>";
													} // while
													
									      	?>
									      </select>
							    	</div>
							    	<label for="nom_societe" class="col-sm-2 control-label"><span class="text-danger">*</span>Nom du compte</label>
							    	<div class="col-sm-4">
							      		<select class="form-control" id="id_Compte" name="id_Compte">
									      	<option value="">~~SELECT~~</option>
									      	<script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#id_classe', function(){
			  								factureTva = $(this).val();
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var id_classe = $(this).val();
										   		var result = '';
										   		if(action == "id_classe")
											   {
											    result ="id_Compte";
											   }

											   	$.ajax({
													url:"php_action/fetchProductData.php",
											      	method:"POST",
													data:{id_classe:id_classe,action : action},
													dataType:"json",
													success:function(data){
														$('#'+result).html(data);
													}

												});
											}
			  							});
			  							
			  						});
			  						
			  					</script>

									      </select>
							    	</div>

							    
							    	
							  	</div>
							  	 <div class="form-group">
							  	 		<label for="nom_societe" class="col-sm-2 control-label"><span class="text-danger">*</span>Sous  compte</label>
							    	<div class="col-sm-4">
							      		
							      		<select class="form-control" id="id_sous_compte" name="id_sous_compte">
									      	<option value="">~~SELECT~~</option>
									      	<script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#id_Compte', function(){
			  								factureTva = $(this).val();
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var id_Compte = $(this).val();
										   		var result = '';
										   		if(action == "id_Compte")
											   {
											    result ="id_sous_compte";
											   }

											   	$.ajax({
													url:"php_action/fetchProductData.php",
											      	method:"POST",
													data:{id_Compte:id_Compte,action : action},
													dataType:"json",
													success:function(data){
														$('#'+result).html(data);
													}

												});
											}
			  							});
			  							
			  						});
			  						
			  					</script>

									      </select>
							    	</div>
								    <label for="clientContact" class="col-sm-2 control-label"><span class="text-danger">*</span>Type payement</label>
								    <div class="col-sm-4">
								      <select class="form-control" name="paymentType" id="paymentType">
								      	<option value="">~~SELECT~~</option>
								      	<option value="1">Cheque</option>
								      	<option value="2">Cash</option>
								      	<option value="3">Carte de Credit</option>
								      </select>
								    </div>
								  
								  </div> <!--/form-group-->	
							  	
				 				
							  	<div class="form-group">
							  		   <label for="clientContact" class="col-sm-2 control-label"><span class="text-danger">*</span>Status payement</label>
								    <div class="col-sm-4">
								      <select class="form-control" name="paymentStatusPayement" id="paymentStatusPayement">
								      	<option value="">~~SELECT~~</option>
							      		<option value="1">Payement Total</option>
							      		<option value="2">Avance</option>
							      		<option value="3">Credit</option>
								      </select>
								    </div>
							    	<label for="libelle_depense" class="col-sm-2 control-label"><span class="text-danger">*</span>Montant </label>
								    <div class="col-sm-4">
								        <input type="number" class="form-control" id="montant" name="montant" autocomplete="off" />
								    </div>
							    	
							    	
							    	
							  	</div>
							  	<div class="form-group">
							    	<label for="libelle_depense" class="col-sm-2 control-label">Observation  </label>
								    <div class="col-sm-10">
								      <textarea id="observation_depense" name="observation_depense" autocomplete="off" placeholder="Votre observation" rows="2" cols="100" class="form-control" style="resize: none;" maxlength="200"></textarea>
								    </div>
							  	</div>
							  	<div class="form-group">
							    	<label for="libelle_depense" class="col-sm-2 control-label">Date émise  </label>
								    <div class="col-sm-4">
								        <input type="date" class="form-control" id="dateemission" name="dateemission" autocomplete="off" disabled="" />
								    </div>
							    	<label for="libelle_depense" class="col-sm-2 control-label">Prix d'achat Total  </label>
								    <div class="col-sm-4">
								        <input type="number" class="form-control" id="prix_achat_depense" name="prix_achat_depense" autocomplete="off" disabled="true" />
								         <input type="hidden" class="form-control" id="prix_achat_depenseValue" name="prix_achat_depenseValue" autocomplete="off" />
								    </div>
							    	
							    	
							  	</div>
							  	<div class="form-group">
							    	<label for="libelle_depense" class="col-sm-2 control-label">Demandé par  </label>
								    <div class="col-sm-4">
								        <input type="text" class="form-control" id="demende_depenseEdit" name="demende_depense" autocomplete="off" disabled="" />
								    </div>
							    	<label for="libelle_depense" class="col-sm-2 control-label">Autorisé par  </label>
								    <div class="col-sm-4">
								        <input type="text" class="form-control" id="autorisation_depenseEdit" name="autorisation_depense" autocomplete="off" disabled="true" />
								        <input type="hidden" name="depensePayementId" id="depensePayementId" class="form-control" />
								    </div>
							    	
							    	
							  	</div>
							  	<div class="modal-footer depensePayementFooter">

							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="createpayementDepenseBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="depenseModalView" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center btn-info">
        <h5 class="modal-title " id="titre">DETAIL DuU BON DE DEPENSE</h5>
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

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeDepenseModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-trash"></i> Supprimer un Bon de dépense</h4>
      </div>
      <div class="modal-body">
        <p>Voulez-vous vraiment supprimer ce Bon de dépense N° : <b> <span id="supprimer"></span> </b> ?</p>
      </div>
      <div class="modal-footer removeCategoriesFooter">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-remove"></i> Close</button>
        <button type="button" class="btn btn-danger" id="removeDepenseBtn" data-loading-text="Loading..."> <i class="fa fa-trash"></i> Supprime</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->

<!-- categories brand -->

<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="attacheFactureDepenseDepenseModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-default">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-paperclip"></i> ATTACHE LA FACTURE AU BON DE DEPENSE N° <span id="factureAttache"></h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" id="submitfactureDepenseForm" action="php_action/attacheFactureDepense.php" method="POST" enctype="multipart/form-data">
       	<div class="form-group">
	        	<label for="productImage" class="col-sm-4 control-label">Facture ou Bordereau : </label>
				   				    <div class="col-sm-7">
					    <!-- the avatar markup -->
						<div class="form-group">
							<input 	type='file'
							class='input-ghost'
							name='Fichier_1'
							style='visibility:hidden; height:0'
							onchange="$(this).next().find('input').val(($(this).val()).split('\\').pop());">
							<div class="input-group input-file" name="Fichier_1">
								<span class="input-group-btn">
									<button 	class="btn btn-primary btn-choose"
												type="button"
												onclick="$(this).parents('.input-file').prev().click();">Choisir</button>
								</span>
								<input 	type="text"
										class="form-control"
										placeholder='Choisissez un fichier...'
										style="cursor:pointer"
										onclick="$(this).parents('.input-file').prev().click(); return false;"
								/>
								<span class="input-group-btn">
									 <button 	class="btn btn-warning btn-reset"
												type="button"
												onclick="
													$(this).parents('.input-file').prev().val(null);
													$(this).parents('.input-file').find('input').val('');
												">Effacer</button>
								</span>
							</div>
						</div>
					   
				      
				    </div>
	        </div> <!-- /form-group-->
	          <div class="modal-footer removeBrandFooter">
	          	<input type="hidden" name="depense_id" id="depense_id"/>
		        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Fermer</button>
		        <button type="submit" class="btn btn-primary" id="createBordereauBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
		    </div>	
	    </form>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->

<?php } ?>




<script src="custom/js/depense.js"></script>

<?php require_once 'includes/footer.php'; ?>