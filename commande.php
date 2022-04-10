<?php require_once 'includes/header.php'; 


$commandeId ="" ;

if (isset($_GET["BC"])!="") {


// add order
	echo "<div class='div-request div-hide'>edit</div>";


$commandeId =$_GET["BC"];

$sql = "SELECT  boncommande.id_commande,  boncommande.ref_commande,  boncommande.prix_total_achat,  boncommande.date_commande,   boncommande.status_paye, id_marque FROM  boncommande 	
	WHERE  boncommande.id_commande = {$commandeId}";

$result = $connect->query($sql);
$data = $result->fetch_row();
$marque = $data[5];

	?>
	<div class="remove-messages"></div>
<div class="panel panel-warning">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-pencil"></i>Modifier le bon de commande N° : <span id="depnse_ref"><?php echo $data[1] ?></span></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

		<form class="form-horizontal" action="php_action/editCommandeCom.php" method="post" id="editCommandeForm">
			<div class="col-md-12">
				<div class="col-md-6">
					<div class="form-group">
	        	 <label for="date_commande" class="col-sm-4control-label">Date : </label>
			    <div class="col-sm-8">
			      <input type="date" class="form-control" id="date_commande" name="date_commande" autocomplete="off" value="<?php echo $data[3]; ?>" disabled="true"/>
			    </div>
	       		
				  
	        </div> <!-- /form-group-->
	    </div>
	    <div class="col-md-6">
					<div class="form-group">
						<label for="id_marque" class="col-sm-4 control-label">Fournisseur : </label>
						<div class="col-sm-8">
				    	  <select class="form-control" name="id_marque" id="id_marque" disabled="true">
			      	<option value="">~~SELECT~~</option>
			      		<?php 


				      		$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1 ORDER BY brand_name ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									$selected = "";
									if($marque == $row[0]) {
										$selected = "selected";
									} else {
										$selected = "";
									}
									echo "<option value='".$row[0]."' ".$selected.">".$row[1]."</option>";
								} // while
								
				      	?>
			      
				      </select>
				      </div>		    	
			  	</div>
				</div>
			</div>
					
					
				<div class="table-responsive col-md-12">
			  <table class="table table-hover  table-striped table-outline mb-0 nowrap text-center" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:40%;text-align: center;">PRODUIT</th>
			  			<th style="width:15%;text-align: center;">QUANTITE</th>
			  					  			
			  			<th style="width:10%;text-align: center;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  	<?php
			  	$depenseItemSql = "SELECT boncommande_item.bonLivraison_id, boncommande_item.id_commande, boncommande_item.id_produit, boncommande_item.quantite, boncommande_item.prix_achat, boncommande_item.prix_achat_total FROM boncommande_item INNER JOIN boncommande ON boncommande.id_commande = boncommande_item.id_commande  WHERE  	id_marque=$marque AND  boncommande_item.id_commande = {$commandeId}";
						$depenseItemResult = $connect->query($depenseItemSql);
						
			  		$arrayNumber = 0;
			  		
			  		$x = 1;
			  		while($depsenseItemData = $depenseItemResult->fetch_array())  { ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:60px;">
	
			  				<select class="form-control" name="productId[]" id="productId<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  					<option value="">~~SELECT~~</option>
			  						<?php
			  							$productSql = "SELECT * FROM product   WHERE active = 1 AND status = 1 AND brand_id = $marque";
			  							$productData = $connect->query($productSql);

			  							while($row = $productData->fetch_array()) {									 		
			  								$selected = "";
			  								if($row['product_id'] == $depsenseItemData['id_produit']) {
			  									$selected = "selected";
			  								} else {
			  									$selected = "";
			  								}

			  								echo "<option value='".$row['product_id']."' id='changeProduct".$row['product_id']."' ".$selected." >".$row['product_name']."</option>";
										 	} // /while 

			  						?>
			  					<script type="text/javascript">

			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#id_marque', function(){
			  								factureTva = $(this).val();
			  								$("#quantite<?php echo $x; ?>").val("");
			  								$("#prix_achat_total<?php echo $x; ?>").val("");
			  								$("#prix_achatValue<?php echo $x; ?>").val("");
			  								$("#prix_achat_totalValue<?php echo $x; ?>").val("");
			  								$("#prix_achat<?php echo $x; ?>").val("");
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var id_marque = $(this).val();
										   		var result = '';
										   		if(action == "id_marque")
											   {
											    result ="productId<?php echo $x; ?>";
											   }

											   	$.ajax({
													url:"php_action/fetchProductData.php",
											      	method:"POST",
													data:{id_marque:id_marque, action : action},
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
		  						
			  				

			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="number" name="quantite[]" id="quantite<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" value="<?php echo $depsenseItemData["quantite"]; ?>"/>	

			  				</td>
			  				<!--<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="hidden" name="prix_achat[]" id="prix_achat<?php //echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />	-->
			  					<input type="hidden" name="prix_achat[]" id="prix_achat<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" value="<?php echo $depsenseItemData["prix_achat"]; ?>"/>		  					
			  					<input type="hidden" name="prix_achatValue[]" id="prix_achatValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $depsenseItemData["prix_achat"]; ?>"/>	
			  					
			  				<!--</td>-->
			  				<!--<td style="padding-left:20px;">			  					
			  						-->	
			  						<input type="hidden" name="prix_achat_total[]" id="prix_achat_total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" value="<?php echo $depsenseItemData["prix_achat_total"]; ?>"/>	  					
			  					<input type="hidden" name="prix_achat_totalValue[]" id="prix_achat_totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" value="<?php echo $depsenseItemData["prix_achat_total"]; ?>"/>

			  				<!--</td>-->
			  			
			  				<td>

			  					<button class="btn btn-danger removeCommandRowBtn" type="button" id="removeCommandRowBtn" onclick="removeCommandRow(<?php echo $x; ?>)" ><i class="fa fa-trash  "></i></button>
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

								   <input type="hidden" class="form-control" id="id_commande" name="id_commande" autocomplete="off" value="<?php echo $data[0] ?>"/>
							    	<label for="libelle_depense" class="col-sm-3 control-label">TOTAL GENERAl : </label>
								    <div class="col-sm-5">
								        <input type="text" class="form-control" id="prix_total_achatAffiche" name="prix_total_achatAffiche" autocomplete="off" disabled="disabled"  value="<?php echo $data[2] ?>"/>
								    </div>
							    	
							    	
							  	</div>
							  	<div class="modal-footer editButtonFooter">
	      	 <button type="button" class="btn btn-info" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="fa fa-plus addRowBtn"></i> Ajoute un autre produit </button>
	      	
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="editCommandeBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
	      </div> <!-- /modal-footer -->	 	 
							 </form>		
		
			</div> <!-- /panel-body -->
		</div> <!-- /panel -->



	<?php
	# code...
}else{
	echo "<div class='div-request div-hide'>addCommande</div>";

?>

<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Tableau de Bord</a></li>		  
		  <li>Depenses</li>
		  <li class="active">Gestion des Bons des commandes</li>
		</ol>
		<div class="remove-messages"></div>
		<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-primary button1" data-toggle="modal" id="addCategoriesModalBtn" data-target="#addCommandeModal"> <i class="fa fa-plus"></i> Créer un bon de commande </button>
				</div> <!-- /div-action -->	
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-list"></i> Gestion des Bons des commandes</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				

							
				<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageCommandeTable">
					<thead>
						<tr><th class="text-center" >Date</th>							
							<th class="text-center" >Référence</th>
							<th class="text-center" >Désignation</th>
							<th class="text-center" >Montant</th>
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


<!-- add categories -->
<div class="modal fade" id="addCommandeModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

    	<form class="form-horizontal" id="getCommandeForm" action="php_action/createCommande.php" method="POST">
	      <div class="modal-header btn-primary">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Créer un bon de commande</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-commande-messages"></div>

	         
	        <div class="form-group">
	        	 <label for="date_commande" class="col-sm-2 control-label">Date : </label>
			    <div class="col-sm-4">
			      <input type="text" class="form-control" id="date_commande" name="date_commande" autocomplete="off" />
			    </div>
	       		<label for="id_marque" class="col-sm-2 control-label">Fournisseur : </label>
				    <div class="col-sm-4">
				      
				  
			      <select class="form-control" name="id_marque" id="id_marque">
			      	<option value="">~~SELECT~~</option>
			      	<?php 
				      	$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1 ORDER BY brand_name ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
			      
				      </select>
				    </div>
				  
	        </div> <!-- /form-group-->	

	         <div class="table-responsive">
			  <table class="table table-hover  table-striped table-outline mb-0 nowrap text-center" id="productTable">
			  	<thead>
			  		<tr>			  			
			  			<th style="width:60%;text-align: center;">PRODUIT</th>
			  			<th style="width:20%;text-align: center;">QUANTITE</th>
			  			<!-- <th style="width:20%;text-align: center;">PRIX ACHAT</th>			  			
			  			<th style="width:15%;text-align: center;">PRIX TOTAL</th>	-->		  			
			  			<th style="width:10%;text-align: center;"></th>
			  			<th style="width:10%;text-align: center;"></th>
			  		</tr>
			  	</thead>
			  	<tbody>
			  		<?php
			  		$arrayNumber = 0;
			  		for($x = 1; $x < 4; $x++) { ?>
			  			<tr id="row<?php echo $x; ?>" class="<?php echo $arrayNumber; ?>">			  				
			  				<td style="margin-left:60px;">
			  				

			  						

			  				<select class="form-control" name="productId[]" id="productId<?php echo $x; ?>" onchange="getProductData(<?php echo $x; ?>)" >
			  					<option value="">~~SELECT~~</option>
			  						
			  					<script type="text/javascript">

			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#id_marque', function(){
			  								factureTva = $(this).val();
			  								$("#quantite<?php echo $x; ?>").val("");
			  								$("#prix_achat_total<?php echo $x; ?>").val("");
			  								$("#prix_achatValue<?php echo $x; ?>").val("");
			  								$("#prix_achat_totalValue<?php echo $x; ?>").val("");
			  								$("#prix_achat<?php echo $x; ?>").val("");
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var id_marque = $(this).val();
										   		var result = '';
										   		if(action == "id_marque")
											   {
											    result ="productId<?php echo $x; ?>";
											   }

											   	$.ajax({
													url:"php_action/fetchProductData.php",
											      	method:"POST",
													data:{id_marque:id_marque, action : action},
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
		  						
			  				

			  				</td>
			  				<td style="padding-left:20px;">			  					
			  					<input type="number" name="quantite[]" id="quantite<?php echo $x; ?>" onkeyup="getTotal(<?php echo $x ?>)" autocomplete="off" class="form-control" min="1" />	

			  				</td>
			  				<!--<td style="padding-left:20px;">
			  					<div class="form-group">
			  					<input type="hidden" name="prix_achat[]" id="prix_achat<?php //echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />	-->
			  					<input type="hidden" name="prix_achat[]" id="prix_achat<?php echo $x; ?>" autocomplete="off" disabled="true" class="form-control" />		  					
			  					<input type="hidden" name="prix_achatValue[]" id="prix_achatValue<?php echo $x; ?>" autocomplete="off" class="form-control" />	
			  					
			  				<!--</td>-->
			  				<!--<td style="padding-left:20px;">			  					
			  						-->	
			  						<input type="hidden" name="prix_achat_total[]" id="prix_achat_total<?php echo $x; ?>" autocomplete="off" class="form-control" disabled="true" />	  					
			  					<input type="hidden" name="prix_achat_totalValue[]" id="prix_achat_totalValue<?php echo $x; ?>" autocomplete="off" class="form-control" />

			  				<!--</td>-->
			  			
			  				<td>

			  					<button class="btn btn-danger removeCommandRowBtn" type="button" id="removeCommandRowBtn" onclick="removeCommandRow(<?php echo $x; ?>)" ><i class="fa fa-trash  "></i></button>
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
	        	<label for="rate" class="col-sm-2 control-label">Prix Achat total : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="prix_total_achatAffiche" placeholder="Prix Achat total" name="prix_total_achatAffiche" autocomplete="off" disabled="true">
				     
				      <input type="hidden" class="form-control" id="prix_total_achatValue" name="prix_total_achatValue" autocomplete="off" >

				    </div>
				  
				    
	        </div> <!-- /form-group-->	
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	      	 <button type="button" class="btn btn-info" onclick="addRow()" id="addRowBtn" data-loading-text="Loading..."> <i class="fa fa-plus addRowBtn"></i> Ajoute un autre produit </button>
	      	 <button type="reset" class="btn btn-danger" onclick="resetCommandeForm()"><i class="glyphicon glyphicon-erase"></i> ReInitialise</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-rmove"></i> Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="createBonLivraisonBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
	      </div> <!-- /modal-footer -->	      
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->


<!-- edit categories brand -->

<!-- /categories brand -->

<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeCommnandeModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Supprimer un Bon de commande</h4>
      </div>
      <div class="modal-body">
        <p>Voulez-vous vraiment supprimer ce Bon de commande No : <b> <span id="supprimer"></span> </b> ?</p>
      </div>
      <div class="modal-footer removeCategoriesFooter">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-danger" id="removeCommandeBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-trash"></i> Supprime</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->


<div class="modal fade" id="commandeModalView" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center btn-info">
        <h5 class="modal-title " id="titre">DETAIL DU BON DE COMMANDES</h5>
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


<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="attacheFactureCommandeModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-default">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-paperclip"></i> ATTACHE LA FACTURE AU BON DE COMMANDE N° <span id="factureAttache"></h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" id="submitBordereauCommandeForm" action="php_action/attacheFactureCommande.php" method="post" enctype="multipart/form-data">
       	<div class="form-group">
	        	<label for="productImage" class="col-sm-4 control-label">Facture ou Bordereau : </label>
				    <div class="col-sm-7">
					    <!-- the avatar markup -->
						<div class="form-group">
							<input 	type='file'
							class='input-ghost'
							name='Fichier_2'
							style='visibility:hidden; height:0'
							onchange="$(this).next().find('input').val(($(this).val()).split('\\').pop());">
							<div class="input-group input-file" name="Fichier_2">
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
	          	<div class="form-group">
	        	<label for="productImage" class="col-sm-4 control-label">Bon de livraison: </label>
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
	          	<input type="hidden" name="id_commande" id="id_commande" /> 
		        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Fermer</button>
		        <button type="submit" class="btn btn-primary" id="createBordereauBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
		      </div>	
	    </form>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->


<div class="modal fade" tabindex="-1" role="dialog" id="addPayementCommandeModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-usd"></i> ENREGISTRE  PAIEMENT POUR : <span id="paiement"></span></h4>
      </div>
      <div class="modal-body">
      	<div id="add-Souscompte-messages"></div>
        	<form class="form-horizontal" action="php_action/createpayementFactureCommande.php" method="post" id="getpaiementCommandeForm">
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
								      <select class="form-control" name="paymentStatus" id="paymentStatusPayement">
								      	<option value="">~~SELECT~~</option>
							      		<option value="1">Paiement Total</option>
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
								      <textarea id="observation_depense" name="observation" autocomplete="off" placeholder="Votre observation" rows="2" cols="100" class="form-control" style="resize: none;" maxlength="200"></textarea>
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

							  	<div class="modal-footer depensePayementFooter">
							  		<input type="hidden" id="depensePayementId" name="depensePayementId">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="createpayementCoomandeBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<?php } ?>
<script src="custom/js/commande.js"></script>

<?php require_once 'includes/footer.php'; ?>