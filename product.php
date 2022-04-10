<?php require_once 'php_action/db_connect.php' ?>
<?php require_once 'includes/header.php'; 

if($_GET['o'] == 'produit') { 
// add order
	echo "<div class='div-request div-hide'>produit</div>";
}else if($_GET['o'] == 'stock') { 
	echo "<div class='div-request div-hide'>stock</div>";
} 

 else if($_GET['o'] == 'stockAgence') { 
	echo "<div class='div-request div-hide'>stockAgence</div>";
} 
else if($_GET['o'] == 'stockParAgence') { 
	echo "<div class='div-request div-hide'>stockParAgence</div>";
} 


?>

<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
  <li><a href="dashboard.php">Tableau de Bord</a></li>
  <li>Produit</li>
  <li class="active">
  	<?php if($_GET['o'] == 'produit') { ?>
  		Gestion du Stock Général

  	<?php } else if($_GET['o'] == 'stock') { ?>
			Gestion du stock général
		<?php } else if($_GET['o'] == 'stockAgence') { ?>
			Gestion du stock Agence
		<?php }else if($_GET['o'] == 'stockParAgence'){// /else manage order ?>
			Gestion de stock par agence
		<?php }?>
  </li>
</ol>
	<?php if($_GET['o'] == 'produit') { ?>
		<div class="div-action pull pull-right" style="padding-bottom: 10px;" >
					<button class="btn btn-primary button1" data-toggle="modal" id="addProductModalBtn" data-target="#addProductModal"> <i class="fa fa-plus"></i> Ajoute un Produit </button>
				</div> <!-- /div-action -->	
				<div class="remove-messages"></div>
		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-list"></i> Gestion de Produits</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

	        <div class="form-group">
	        	<label for="brandName" class="col-sm-2 control-label">Fournisseur : </label>
				    <div class="col-sm-4">
				      <select class="form-control" id="fournisseur" name="fournisseur">
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
	        </div> <!-- /form-group--><br>
	        <script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#fournisseur', function(){
			  								if($(this).val()  != ""){
			  									var fournisseur = $(this).val();
											   	var dataTable = $('#manageProductTable').DataTable({
											   		destroy: true,
												   "processing":true,
												   "serverSide":false,
												   "order":[],
												   "ajax":{
												    url:"php_action/fetchProductSavonor.php",
												    type:"POST",
												    data:{fournisseur:fournisseur}
												   },
												   "columnDefs":[
												    {
												     "targets":[7],
												     "orderable":false,
												    },
												   ],
												  });

												
											}
			  							});
			  							
			  						});
			  						
			  					</script>


				<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageProductTable">
					<thead>
						<tr>						
							<th class="text-center" >Produit</th>
							<th class="text-center" >Pieces</th>
							<th class="text-center" >P.A</th>
							<th class="text-center" >P.V</th>
							<th class="text-center" >B</th>							
							<th class="text-center" >Fournisseur</th>
							<th class="text-center" >TVA</th>
							<th style="width:15%;" class="text-center" >Options</th>
						</tr>
					</thead>
				</table>
			</div>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<div class="modal fade" id="productModalView" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center btn-info">
        <h5 class="modal-title " id="titre">DETAIL DU PRODUIT</h5>
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



<!-- add product -->
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

    	<form class="form-horizontal" id="submitProductForm" action="php_action/createProduct.php" method="POST" enctype="multipart/form-data">
	      <div class="modal-header btn-primary">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Ajoute Produit</h4>
	      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div id="add-product-messages"></div>

	      	<div class="form-group">
	        	<label for="productImage" class="col-sm-3 control-label">Image du Produit : </label>

				    <div class="col-sm-8">
					    <!-- the avatar markup -->
							<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
					    <div class="kv-avatar center-block">					        
					        <input type="file" class="form-control" id="productImage" placeholder="Product Name" name="productImage" class="file-loading" style="width:auto;"/>
					    </div>
				      
				    </div>
	        </div> <!-- /form-group-->	 

	        <div class="form-group">
				        	<label for="editProductStatus" class="col-sm-3 control-label">Status TVA : </label>
							    <div class="col-sm-8">
							      <select class="form-control" id="produit_tva" name="produit_tva">
							      	<option value="">~~SELECT~~</option>
							      	<option value="1">Oui</option>
							      	<option value="2">Non</option>
							      </select>
							    </div>
				        </div> <!-- /form-group-->    	           	       

	        <div class="form-group">
	        	<label for="productName" class="col-sm-3 control-label">Nom du Produit : </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="productName" placeholder="Product Name" name="productName" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	    

	        <div class="form-group">
	        	<label for="quantity" class="col-sm-3 control-label">Pieces/Cartons : </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="pieceCarton" placeholder="Pieces/Cartons" name="pieceCarton" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->      	 

	        <div class="form-group">
	        	<label for="rate" class="col-sm-3 control-label">Prix Achat : </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="prix_achat" placeholder="Prix Achat" name="prix_achat" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	 
	        <div class="form-group">
	        	<label for="rate" class="col-sm-3 control-label">Prix Vente : </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="rate" placeholder="Prix Vente" name="rate" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	    	        

	        <div class="form-group">
	        	<label for="brandName" class="col-sm-3 control-label">Fournisseur : </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="brandName" name="brandName">
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

	        <div class="form-group">
	        	<label for="categoryName" class="col-sm-3 control-label">Categorie : </label>
				    <div class="col-sm-8">
				      <select type="text" class="form-control" id="categoryName"  name="categoryName" >
				      	<option value="">~~SELECT~~</option>

				      	<script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#brandName', function(){
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var brandName = $(this).val();
										   		//alert(action);
										   		var result = '';
										   		if(action == "brandName")
											   {
											    result ="categoryName";
											   }

											   	$.ajax({
													url:"php_action/fetCategoryMarque.php",
											      	method:"POST",
													data:{brandName:brandName,action : action},
													dataType:"json",
													success:function(data){
														$('#'+result).html(data);
													}

												});
											}
			  							});
			  							
			  						});
			  						
			  					</script>

				      	<?php 
				      
								
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->					        	         	       

	        <div class="form-group">
	        	<label for="productStatus" class="col-sm-3 control-label">Status : </label>
				    <div class="col-sm-8">
				      <select class="form-control" id="productStatus" name="productStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Disponible</option>
				      	<option value="2">Indisponible</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	         	        
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Ferme</button>
	        
	        <button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
	      </div> <!-- /modal-footer -->	      
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->


<!-- ------------------------------------edit categories brand----------------------------------------- -->
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	    	
	      <div class="modal-header btn-warning">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Modifier</h4>
	      </div>
	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div class="div-loading">
	      		<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
	      	</div>

	      	<div class="div-result">

				  <!-- Nav tabs -->
				  <ul class="nav nav-tabs" role="tablist">
				    <li role="presentation" class="active"><a href="#photo" aria-controls="home" role="tab" data-toggle="tab"> <span class="fa fa-image"></span> Photo</a></li>
				    <li role="presentation"><a href="#productInfo" aria-controls="profile" role="tab" data-toggle="tab"><span class="fa fa-ruble"></span> Information sur le Produit</a></li>    
				  </ul>

				  <!-- Tab panes -->
				  <div class="tab-content">

				  	
				    <div role="tabpanel" class="tab-pane active" id="photo">
				    	<form action="php_action/editProductImage.php" method="POST" id="updateProductImageForm" class="form-horizontal" enctype="multipart/form-data">

				    	<br />
				    	<div id="edit-productPhoto-messages"></div>

				    	<div class="form-group">
			        	<label for="editProductImage" class="col-sm-3 control-label">Image du Produit: </label>
			        	
						    <div class="col-sm-8">							    				   
						      <img src="" id="getProductImage" class="thumbnail" style="width:250px; height:250px;" />
						    </div>
			        </div> <!-- /form-group-->	     	           	       
				    	
			      	<div class="form-group">
			        	<label for="editProductImage" class="col-sm-3 control-label">Select Photo: </label>
			        	
						    <div class="col-sm-8">
							    <!-- the avatar markup -->
									<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
							    <div class="kv-avatar center-block">					        
							        <input type="file" class="form-control" id="editProductImage" placeholder="Product Name" name="editProductImage" class="file-loading" style="width:auto;"/>
							    </div>
						      
						    </div>
			        </div> <!-- /form-group-->	     	           	       

			        <div class="modal-footer editProductPhotoFooter">
				        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Ferme</button>
				        
				        <!-- <button type="submit" class="btn btn-success" id="editProductImageBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> Save Changes</button> -->
				      </div>
				      <!-- /modal-footer -->
				      </form>
				      <!-- /form -->
				    </div>
				    <!-- product image -->
				    <div role="tabpanel" class="tab-pane" id="productInfo">
				    	<form class="form-horizontal" id="editProductForm" action="php_action/editProduct.php" method="POST">				    
				    	<br />

				    	<div id="edit-product-messages"></div>

				    	<div class="form-group">
				        	<label for="editProductStatus" class="col-sm-3 control-label">Status TVA </label>
				        
							    <div class="col-sm-8">
							      <select class="form-control" id="editProduit_tva" name="editProduit_tva">
							      	<option value="">~~SELECT~~</option>
							      	<option value="1">Oui</option>
							      	<option value="2">Non</option>
							      </select>
							    </div>
				        </div> <!-- /form-group-->	

				    	<div class="form-group">
			        		<label for="editProductName" class="col-sm-3 control-label">Nom du produit </label>
			        		
						    <div class="col-sm-8">
						      <input type="text" class="form-control" id="editProductName" placeholder="Product Name" name="editProductName" autocomplete="off">
						    </div>
			        	</div> <!-- /form-group-->	  
				        <div class="form-group">
				        	<label for="quantity" class="col-sm-3 control-label">Pieces/Cartons </label>
				        	
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="editpieceCarton" placeholder="Pieces/Cartons" name="editpieceCarton" autocomplete="off">
							    </div>
				        </div> <!-- /form-group-->  

				     
				         <div class="form-group">
				        	<label for="editRate" class="col-sm-3 control-label">Prix Achat </label>
				        
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="editprix_achat" placeholder="Prix Achat" name="editprix_achat" autocomplete="off">
							    </div>
				        </div> <!-- /form-group-->	        	 

				        <div class="form-group">
				        	<label for="editRate" class="col-sm-3 control-label">Prix Vente </label>
				        	
							    <div class="col-sm-8">
							      <input type="text" class="form-control" id="editRate" placeholder="Rate" name="editRate" autocomplete="off">
							    </div>
				        </div> <!-- /form-group-->	     	        

				        <div class="form-group">
				        	<label for="editBrandName" class="col-sm-3 control-label">Fournisseur </label>
				        	
							    <div class="col-sm-8">
							      <select class="form-control" id="editBrandName" name="editBrandName">
							      	<option value="">~~SELECT~~</option>
							      	<?php 
							      	$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1";
											$result = $connect->query($sql);

											while($row = $result->fetch_array()) {
												echo "<option value='".$row[0]."'>".$row[1]."</option>";
											} // while
											
							      	?>
							      </select>
							    </div>
				        </div> <!-- /form-group-->	

				        <div class="form-group">
				        	<label for="editCategoryName" class="col-sm-3 control-label">Categorie: </label>
				        	
							    <div class="col-sm-8">
							      <select type="text" class="form-control" id="editCategoryName" name="editCategoryName" >
							      	<option value="">~~SELECT~~</option>
							      	<?php 
							      	$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1";
											$result = $connect->query($sql);

											while($row = $result->fetch_array()) {
												echo "<option value='".$row[0]."'>".$row[1]."</option>";
											} // while
											
							      	?>
							      </select>
							    </div>
				        </div> <!-- /form-group-->					        	         	       

				        <div class="form-group">
				        	<label for="editProductStatus" class="col-sm-3 control-label">Status: </label>
				        	
							    <div class="col-sm-8">
							      <select class="form-control" id="editProductStatus" name="editProductStatus">
							      	<option value="">~~SELECT~~</option>
							      	<option value="1">Disponible</option>
							      	<option value="2">Indisponible</option>
							      </select>
							    </div>
				        </div> <!-- /form-group-->	         	        

				        <div class="modal-footer editProductFooter">
					        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Ferme</button>
					        
					        <button type="submit" class="btn btn-warning" id="editProductBtn" data-loading-text="Loading..."> <i class="fa fa-save"></i> Enregistre</button>
					      </div> <!-- /modal-footer -->				     
			        </form> <!-- /.form -->				     	
				    </div>    
				    <!-- /product info -->
				  </div>

				</div>
	      	
	      </div> <!-- /modal-body -->
	      	      
     	
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- /categories brand -->

<!-- -----------------------------------------------categories brand----------------------------------------------- -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeProductModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Supprime</h4>
      </div>
      <div class="modal-body">

      	<div class="removeProductMessages"></div>

         <p>Voulez-vous vraiment supprimer cette Produit :<b> <span id="supprimer"></span> </b> ?</p>
      </div>
      <div class="modal-footer removeProductFooter">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-remove"></i> Ferme</button>
        <button type="button" class="btn btn-danger" id="removeProductBtn" data-loading-text="Loading..."> <i class="fa fa-save"></i> Enregistre</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand -->
<?php }else if($_GET['o'] == 'stockAgence') {

 ?>


	<div class="div-action pull pull-right" style="padding-bottom: 10px;" >
					<button class="btn btn-primary button1" data-toggle="modal" id="addAgenceProductModalBtn" data-target="#addAgenceProductModal"> <i class="fa fa-plus"></i> Ravitaille un dépôt </button>
				</div> <!-- /div-action -->	
				<div class="remove-messages"></div>
		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-list"></i> Gestion de Produit dans les dépôt  <span id="agence"></span></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">
			
	         <br>	
	        <br>
				<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageProductAgenceTable">
					<thead>
						<tr>
							<th class="text-center" >Dépôt depart</th>
							<th class="text-center" >Dépôt Arrive</th>						
							<th class="text-center" >Produit</th>
							<th class="text-center" >Quantite</th>							
							<th class="text-center" >P.V</th>							
							<th class="text-center" >P.V.T</th>
							<th class="text-center" >B.T</th>
							<th style="width:15%;" class="text-center" >Options</th>
						</tr>
					</thead>
				</table>
			</div>

<script type="text/javascript" language="javascript" >
$(document).ready(function(){
 
var dataTable;
 	// manage brand table
	 dataTable = $("#manageProductAgenceTable").DataTable({
		"processing":true,
		"serverSide":false,
		'order': [],
		'ajax': 'php_action/fetchDetailAgence.php',
		"columnDefs":[  
                {  
                    "targets":[7],  
                    "orderable":false,    
                },  
           ],
	});
});
</script>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->
<div class="modal fade" id="addAgenceProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

    	<form class="form-horizontal" id="submiAgencetProductForm" action="php_action/createAgenceProduct.php" method="POST" enctype="multipart/form-data">
	      <div class="modal-header btn-primary">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Ravitaille Une Agence</h4>
	      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div id="add-productAgence-messages"></div>

	      	
	      	 <div class="form-group">
	        	<label for="username" class="col-sm-2 control-label">Dépôt Depart :</label>
	        	
				    <div class="col-sm-4">
				        <select class="form-control" id="id_agence" name="id_agence">
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT id_agence, agence FROM agence  ORDER BY agence ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				    </div>
				    <label for="username" class="col-sm-2 control-label">Dépôt Arrive:</label>
	        	
				    <div class="col-sm-4">
				        <select class="form-control" id="id_agence_arrive" name="id_agence_arrive">
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT id_agence, agence FROM agence  ORDER BY agence ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	
	       <div class="form-group">
	       	<label for="brandName" class="col-sm-2 control-label">Fournisseur : </label>
				    <div class="col-sm-4">
				      <select class="form-control" id="brandName" name="brandName">
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
	        	<label for="categoryName" class="col-sm-2 control-label">Categorie : </label>
				    <div class="col-sm-4">
				      <select type="text" class="form-control" id="categoryName"  name="categoryName" >
				      	<option value="">~~SELECT~~</option>

				      	<script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#brandName', function(){
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var brandName = $(this).val();
										   		//alert(action);
										   		var result = '';
										   		if(action == "brandName")
											   {
											    result ="categoryName";
											   }

											   	$.ajax({
													url:"php_action/fetCategoryMarque.php",
											      	method:"POST",
													data:{brandName:brandName,action : action},
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
	        </div> <!-- /form-group-->					        	         	       
   	           	       

	        <div class="form-group">
	        	<label for="productName" class="col-sm-2 control-label">Nom du Produit : </label>
				    <div class="col-sm-4">
				      <select type="text" class="form-control" id="produitName"  name="produitName" >
				      	<option value="">~~SELECT~~</option>

				      	<script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#categoryName', function(){
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var categoryName = $(this).val();
										   		//alert(action);
										   		var result = '';
										   		if(action == "categoryName")
											   {
											    result ="produitName";
											   }

											   	$.ajax({
													url:"php_action/fetCategoryMarque.php",
											      	method:"POST",
													data:{categoryName:categoryName,action : action},
													dataType:"json",
													success:function(data){
														$('#'+result).html(data);
													}

												});
											}
			  							});
			  							$(document).on('change', '#produitName', function(){
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var produitName = $(this).val();
										   		var id_agence =  $("#id_agence").val();
										   		//alert(id_agence);
										   		var result = '';
										   		

											   	$.ajax({
													url:"php_action/fetCategoryMarque.php",
											      	method:"POST",
													data:{produitName:produitName,action : action, id_agence : id_agence},
													dataType:"json",
													success:function(data){
														$('#rate').val(data.rate);
														$('#prix_vente').val(data.rate);
														$('#prix_achat').val(data.prix_achat);
														$('#quantiteStocks').val(data.quantity_total_agence);
														$('#pieces').val(data.produit_pieceCarton);
														$('#quantiteStocksRest').val(data.quantity_total_agence);
														$('#stockId').val(data.produitAgence_id);
													}

												});
											}
			  							});

			  							
			  						});
			  						
			  					</script>

				      	
				      </select>
				    </div>
				    <label for="quantity" class="col-sm-2 control-label">Quantite : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="quantity" placeholder="Quantity" name="quantity" autocomplete="off" onkeyup="quantiteReste()">
				    </div>
	        </div> <!-- /form-group-->	    

	      
	        
	        <div class="form-group">
	        	<label for="rate" class="col-sm-2 control-label">Prix Vente : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="rate" placeholder="Prix Vente" name="rate" autocomplete="off" disabled="true">
				       <input type="hidden" class="form-control" id="prix_vente" placeholder="Prix Vente" name="prix_vente" autocomplete="off" >
				      <input type="hidden" class="form-control" id="prix_achat" name="prix_achat" autocomplete="off" >

				    </div>
				    <label for="productStatus" class="col-sm-2 control-label">Quantité Stock : </label>
				 
				    <div class="col-sm-4">
				       <input type="text" class="form-control" id="quantiteStocks" placeholder="Quantité en Stock " name="quantiteStocks" autocomplete="off" disabled="true">
				       <input type="hidden" class="form-control" id="quantiteStocksRest" placeholder="Quantité en Stock " name="quantiteStocksRest" autocomplete="off" >
				    </div>
				    
	        </div> <!-- /form-group-->	    	        
	         <div class="form-group">
	        	<label for="rate" class="col-sm-2 control-label"> pièces : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="pieces" placeholder="Nombre des pièces" name="pieces" autocomplete="off" disabled="true">

				    </div>
				    <label for="productStatus" class="col-sm-2 control-label">Quantité Reste : </label>
				    <script type="text/javascript">
				    	function quantiteReste() {
							var grandTotal = $("#quantiteStocksRest").val();

							if(grandTotal) {
								var stocksRest = Number($("#quantiteStocksRest").val()) - Number($("#quantity").val());
								
								$("#stocksRestAffiche").val(stocksRest);
								$("#stocksRest").val(stocksRest);
							} // /if
						} // /paid amoutn function
				    </script>
				 
				    <div class="col-sm-4">
				        <input type="text" class="form-control" id="stocksRestAffiche" placeholder="Quantité Reste" name="stocksRestAffiche" autocomplete="off" disabled="true">
				         <input type="hidden" class="form-control" id="stocksRest" placeholder="Quantité Reste" name="stocksRest" autocomplete="off">
				          <input type="text" class="form-control" id="stockId" placeholder="Quantité Reste" name="stockId" autocomplete="off">
				    </div>
				    
	        </div> <!-- /form-group-->	  	        
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Ferme</button>
	        
	        <button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
	      </div> <!-- /modal-footer -->	      
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<!-- /add categories -->

<div class="modal fade" id="viewAgenceProductModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

    	<form class="form-horizontal" id="ViewAgencetProductForm"  enctype="multipart/form-data">
	      <div class="modal-header btn-info">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Information sur cette produit dans le dépôt : <span id="nom_agene"></span></h4>
	      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      	<div id="add-product-messages"></div>

	      	
	      	 <div class="form-group">
	        	<label for="username" class="col-sm-2 control-label">Dépôt Depart :</label>
	        	
				    <div class="col-sm-4">
				       <input type="text" class="form-control" id="id_agenceView"   autocomplete="off" disabled="true"> 
				    </div>
				    <label for="username" class="col-sm-2 control-label">Dépôt Arrive:</label>
	        	
				    <div class="col-sm-4">
				       <input type="text" class="form-control" id="id_agence_arriveView"  autocomplete="off" disabled="true"> 
				    </div>
	        </div> <!-- /form-group-->	
	       <div class="form-group">
	       	<label for="brandName" class="col-sm-2 control-label">Fournisseur : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="brandNameView"  autocomplete="off" disabled="true">
				    </div>
	        	<label for="categoryName" class="col-sm-2 control-label">Categorie : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="categoryNameView"  autocomplete="off" disabled="true">
				    </div>
	        </div> <!-- /form-group-->					        	         	       
   	           	       

	        <div class="form-group">
	        	<label for="productName" class="col-sm-2 control-label">Nom du Produit : </label>
				    <div class="col-sm-4">
				     <input type="text" class="form-control" id="produitNameView"  autocomplete="off" disabled="true">
				    </div>
				    <label for="quantity" class="col-sm-2 control-label">Quantite Total: </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="quantityTotalView"  autocomplete="off" disabled="true">
				    </div>
	        </div> <!-- /form-group-->	    

	      
	        
	        <div class="form-group">
	        	<label for="rate" class="col-sm-2 control-label">Prix Vente : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="rateView"  autocomplete="off" disabled="true">
				       

				    </div>
				    <label for="rate" class="col-sm-2 control-label"> pièces : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="piecesView"  autocomplete="off" disabled="true">

				    </div>
				  
				    
	        </div> <!-- /form-group-->	    	        

	        <div class="form-group">
	        	<label for="rate" class="col-sm-2 control-label">Prix Vente Total : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="prix_total_venteView"  autocomplete="off" disabled="true">
				       

				    </div>
				   <label for="rate" class="col-sm-2 control-label">Benefie Total : </label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="benefice_totalView"  autocomplete="off" disabled="true">
				       

				    </div>
				    
	        </div> <!-- /form-group-->	
  	        
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Ferme</button>
	        
	   
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<?php }else if($_GET['o'] == 'stockParAgence') {

 ?>


	<div class="remove-messages"></div>
		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i> Valeur des stocks par dépôt </div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">
				<div class="col-md-12">
					<div class="col-sm-4">
				        <select class="form-control" id="id_agence_arriveTotal" name="id_agence_arriveTotal">
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT id_agence, agence FROM agence  ORDER BY agence ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				    </div>
				    <br><br><br>
				</div>



				   
			<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageValeurAgenceTableTotal">
					<thead>
						<tr>						
							<th class="text-center">Nom dépôt</th>						
							<th class="text-center">Valeur du Stock</th>
							<th class="text-center">beneficie du stock</th>
						</tr>
					</thead>
				</table>
			</div>

			<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageValeurAgenceTable">
					<thead>
						<tr>						
							<th class="text-center">Produits</th>						
							<th class="text-center">Quantités</th>
							<th class="text-center">Quantités T.</th>
							<th class="text-center">Achat T.</th>
							<th class="text-center">Vente T.</th>
							<th class="text-center">Béneficies</th>
						</tr>
					</thead>
				</table>
			</div>

	       
				<script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#id_agence_arriveTotal', function(){
			  								var dataTable ;
			  								if($(this).val()  != ""){
										  		//dataTable.destroy();
										   		var id_agence_arriveTotal = $(this).val();
										   		
											  	dataTable = $('#manageValeurAgenceTableTotal').DataTable({
											  	destroy: true,
												   "processing":true,
												   "serverSide":false,
												   searching: false,
												   paginate:false,
												   "order":[],
												   "ajax":{
												    url:"php_action/fetchAgenceProduit.php",
												    type:"POST",
												    data:{id_agence_arriveTotal:id_agence_arriveTotal}
												   },
												   "columnDefs":[
												    {
												     "targets":[0,1,2],
												     "orderable":false,
												    },
												   ],
												  });

											  	dataTable = $('#manageValeurAgenceTable').DataTable({
											  		destroy: true,
												   "processing":true,
												   "serverSide":false,
												   "order":[],
												   "ajax":{
												    url:"php_action/fetchAgenceProduitListe.php",
												    type:"POST",
												    data:{id_agence_arriveTotal:id_agence_arriveTotal}
												   },
												   "columnDefs":[
												    {
												     "targets":[0],
												     "orderable":false,
												    },
												   ],
												  });
											}
			  							});
			  							
			  						});
			  						
			  					</script>
				<!-- /table -->

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->


<!-- /add categories -->

<?php }else if ($_GET["o"] == "stock") {?>



	<div class="div-action pull pull-right" style="padding-bottom: 10px;" >
					<button class="btn btn-primary button1" data-toggle="modal" id="addStockProductModalBtn" data-target="#addStockProductModal"> <i class="fa fa-plus"></i> Ajout un nouveau </button>
				</div> <!-- /div-action -->	
				<div class="remove-messages"></div>
		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-list"></i> Gestion de Produit de le dépôt  <span id="agence"></span></div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">
			
	         <br>	
	        <br>
				<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageStockTable">
					<thead>
						<tr>						
							<th class="text-center" >Produit</th>
							<th class="text-center" >Quantite Total</th>						
							<th class="text-center" >P.A.T</th>							
							<th class="text-center" >P.V.T</th>
							<th class="text-center" >B.T</th>
							<th style="width:15%;" class="text-center" >Options</th>
						</tr>
					</thead>
				</table>
			</div>
				<!-- /table -->
				
			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
		<div class="modal fade" id="addStockProductModal" tabindex="-1" role="dialog">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">

    	<form class="form-horizontal" id="stockProductForm"  enctype="multipart/form-data" method="POST" action="php_action/createStock.php">
		      <div class="modal-header btn-primary">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title"><i class="fa fa-plus"></i> AJOUTE AU STOCK</span></h4>
		      </div>

	      <div class="modal-body" style="max-height:450px; overflow:auto;">

	      		<div id="add-stock-messages"></div>

		      	<div class="form-group">
		        	<label for="username" class="col-sm-3 control-label"><span class="text-danger">*</span>Fornisersseur :</label>
		        	
					    <div class="col-sm-8">
					       <select class="form-control" id="brandName" name="brandName">
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
	       		<div class="form-group">
		        	<label for="categoryName" class="col-sm-3 control-label"><span class="text-danger">*</span>Categorie : </label>
					    <div class="col-sm-8">
				      		<select type="text" class="form-control" id="categoryName"  name="categoryName" >
				      			<option value="">~~SELECT~~</option>

						      	<script type="text/javascript">
					  						$(document).ready(function() {
					  							//var factureTva =0;
					  							$(document).on('change', '#brandName', function(){
					  								if($(this).val()  != ""){
												  		var action = $(this).attr("id");
												   		var brandName = $(this).val();
												   		//alert(action);
												   		var result = '';
												   		if(action == "brandName")
													   {
													    result ="categoryName";
													   }

													   	$.ajax({
															url:"php_action/fetCategoryMarque.php",
													      	method:"POST",
															data:{brandName:brandName,action : action},
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
	        	</div> <!-- /form-group-->			        	         	       
   	           	       

	          	<div class="form-group">
	        		<label for="produitNom" class="col-sm-3 control-label"><span class="text-danger">*</span>Nom du Produit : </label>
				    <div class="col-sm-8">
				      <select type="text" class="form-control" id="produitNom"  name="produitNom" >
				      	<option value="">~~SELECT~~</option>

				      	<script type="text/javascript">
			  						$(document).ready(function() {
			  							//var factureTva =0;
			  							$(document).on('change', '#categoryName', function(){
			  								if($(this).val()  != ""){
										  		var action = $(this).attr("id");
										   		var categoryName = $(this).val();
										   		//alert(action);
										   		var result = '';
										   		if(action == "categoryName")
											   {
											    result ="produitNom";
											   }

											   	$.ajax({
													url:"php_action/fetCategoryMarque.php",
											      	method:"POST",
													data:{categoryName:categoryName,action : action},
													dataType:"json",
													success:function(data){
														$('#'+result).html(data);
													}

												});
											}
			  							});

			  							$(document).on('change', '#produitNom', function(){
			  								if($(this).val()  != ""){
										   		var productId = $(this).val();
										   		//alert(action);
										   		
											   	$.ajax({
													url:"php_action/fetchSelectedProductStock.php",
											      	method:"POST",
													data:{productId:productId},
													dataType:"json",
													success:function(data){

														$("#prix_total_venteView").val(data.quantity_total);
														
													}

												});
											}
			  							});
			  							
			  						});
			  						
			  					</script>

				      	<?php 
				      
								
				      	?>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	  

	      
	        
	        <div class="form-group">
	        	<label for="quantity" class="col-sm-3 control-label"><span class="text-danger">*</span>Quantité Total: </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="quantity" name="quantity" autocomplete="off" >
				    </div>
				    
	        </div> <!-- /form-group-->	    	        
	         
	        <div class="form-group">
	        	<label for="rate" class="col-sm-3 control-label">Quantité en stock : </label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="prix_total_venteView"  autocomplete="off" disabled="true">
				       

				    </div>
				  
	        </div> <!-- /form-group-->	
	                
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer submitButtonFooter">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Ferme</button>
	        <button type="submit" class="btn btn-primary" id="createProductBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
	      </div>
	       
	   
     	</form> <!-- /.form -->	
     	 </div>     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
<div class="modal fade" id="stockModalView" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header text-center btn-info">
        <h5 class="modal-title " id="titre">HISTORIQUE PRODUIT</h5>
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
<!----------- Modifier quantite Stock ------------->
<div class="modal fade" id="editStockModalView" tabindex="-1" role="dialog" >
  <div class="modal-dialog ">
    <div class="modal-content">
      <div class="modal-header text-center btn-primary">
        <h5 class="modal-title " id="titre">AJOUTE LA QUANTITE DANS LE STOCK</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >

      	<form class="form-horizontal" id="stockProductQuantiteForm"  enctype="multipart/form-data" method="POST" action="php_action/editQuantiteStock.php">
      		<div class="form-group">
      		
	        	<label for="rate" class="col-sm-4 control-label">Produit : </label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" id="product_name" autocomplete="off" disabled="true" >
				    </div>
				  
	        </div> <!-- /form-group-->
      	<div class="form-group">
      		
	        	<label for="rate" class="col-sm-4 control-label">Nouveau Quantité : </label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" id="quantiteNew" name="quantiteNew"  autocomplete="off" >
				      <input type="hidden" class="form-control" id="product_idStock" name="product_idStock" autocomplete="off" >
				       

				    </div>
				  
	        </div> <!-- /form-group-->
      		<div class="form-group">
	        	<label for="rate" class="col-sm-4 control-label">Quantité en stock : </label>
				    <div class="col-sm-6">
				      <input type="text" class="form-control" id="quantiteStock"  autocomplete="off" disabled="true">
				      <input type="hidden" class="form-control" id="quantiteStockValue" name="quantiteStockValue"  autocomplete="off">
				      <input type="hidden" class="form-control" id="dateValue" name="dateValue"  autocomplete="off">
				       

				    </div>
				  
	        </div> <!-- /form-group-->

	        <div class="modal-footer">
      			
        		<button type="button" class="btn btn-danger" data-dismiss="modal"> <i class=" fa fa-trash"></i> Close</button>
        		<button type="submit" class="btn btn-primary" id="quantiteStockBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
      		</div>
	        </form> <!-- /.form -->	
 			
      </div>

    </div>
  </div>
</div>

<?php } ?>




<script src="custom/js/product.js"></script>
<script src="custom/js/product_agence.js"></script>
<script src="custom/js/stock.js"></script>

<?php require_once 'includes/footer.php'; ?>