<?php require_once 'includes/header.php'; ?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Tableau de bord</a></li>		  
		  <li class="active">Client</li>
		</ol>

			<div id="edit-brand-messages"></div>

		<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-primary button1" data-toggle="modal" data-target="#addBrandModel"> <i class="glyphicon glyphicon-plus-sign"></i>Ajoute Un nouveau Client </button>
				</div> <!-- /div-action -->		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-list"></i> Liste des clients</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

					<div class="box-body table-responsive no-padding" style="max-width:1124px;">	
				
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageClientTable" width="100%" cellspacing="0">
			
					<thead>
						<tr>
							<th class="text-center" >Numero du Client</th>
							<th  class="text-center" >Téléphone</th>
							<th class="text-center" >NIF</th>
							<th  class="text-center" >Addresse</th>						
							<th  class="text-center" >Options</th>
						</tr>
					</thead>
					<tbody></tbody>
				</table>
				<!-- /table -->
		</div>

			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

<div class="modal fade" id="addBrandModel" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="submitVersementForm" action="php_action/createClient.php" method="POST">
	      <div class="modal-header btn-primary">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Ajoute Un nouveau client</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-brand-messages"></div>

	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Nom</label>

				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="nom_client" placeholder="Nom du client" name="nom_client" autocomplete="off">
				      
				    </div>
				    <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Prénom</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="prenom_client" placeholder="Prénom du client" name="prenom_client" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->
	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Téléphone</label>
	        	<div class="col-sm-4">
	        		<input type="text" class="form-control" id="telephone_client" placeholder="Téléphone du client" name="telephone_client" autocomplete="off">
				  </div>
	        	
				    <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>NiF client</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="nif_client" placeholder="NIF du client" name="nif_client" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
	
	        <div class="form-group">
	        <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Adresse</label>

				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="adresse_client" placeholder="Address du client" name="adresse_client" autocomplete="off">
				      
				    </div>         	                	        

	      </div> <!-- /modal-body -->
	  </div>
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-trash"></i> Ferme</button>
	        
	        <button type="submit" class="btn btn-primary" id="createClientBtn" data-loading-text="Loading..." autocomplete="off"><i class="fa fa-save"></i> Enregistre</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->

<!-- edit brand -->
<div class="modal fade" id="viewVersementModel" tabindex="" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
    	
    	    
	     <!-- /.form -->
	     	<form class="form-horizontal" id="submitClietEditForm" action="php_action/editClient.php" method="POST">
	       <div class="modal-header btn-warning">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-pencil"></i> Modification D'information d'un client</h4>
	      </div>
	      <div class="modal-body">

	      

	      	<div class="col-md-6">
	      		
	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-4 control-label"><span class="text-danger">*</span>Nom</label>

				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="nom_clientEdit" placeholder="Nom du client" name="nom_clientEdit" autocomplete="off">
				      
				    </div>
				    
	        </div> <!-- /form-group-->
	           <div class="form-group">
	        	<label for="nom_banque" class="col-sm-4 control-label"><span class="text-danger">*</span>Téléphone</label>
	        	<div class="col-sm-8">
	        		<input type="text" class="form-control" id="telephone_clientEdit" placeholder="Téléphone du client" name="telephone_clientEdit" autocomplete="off">
				  </div>
	        	
				    
	        </div> <!-- /form-group-->
	      	</div>
	      	<div class="col-md-6">
	      		
	      		    <div class="form-group">
				    <label for="nom_banque" class="col-sm-4 control-label"><span class="text-danger">*</span>Prénom</label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="prenom_clientEdit" placeholder="Prénom du client" name="prenom_clientEdit" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->
	        <div class="form-group">
	        	
				    <label for="nom_banque" class="col-sm-4 control-label"><span class="text-danger">*</span>NiF client</label>
				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="nif_clientEdit" placeholder="NIF du client" name="nif_clientEdit" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->
	      	</div>


	    
	        	
	
	        <div class="form-group">
	        <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Adresse</label>

				    <div class="col-sm-10">
				      <input type="text" class="form-control" id="adresse_clientEdit" placeholder="Address du client" name="adresse_clientEdit" autocomplete="off">
				      
				    </div>         	                	        
	      </div> <!-- /modal-body -->
	  </div>

	      <div class="modal-footer editBrandFooter">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-trash"></i> Ferme</button>
	        
	        <button type="submit" class="btn btn-warning" id="createClientEditBtn" data-loading-text="Loading..." autocomplete="off"><i class="fa fa-save"></i> Enregistre</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>

    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>



<!-- /remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeClientModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-trash"></i> Supprimer ce client</h4>
      </div>
      <div class="modal-body">
        <p>Voulez-vous vraiment supprimer ce client :<b> <span id="supprimer"></span> </b> ?</p>
      </div>
      <div class="modal-footer removeBrandFooter">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-remove"></i> Ferme</button>
        <button type="button" class="btn btn-danger" id="removeClientBtn" data-loading-text="Loading..."> <i class="fa fa-trash"></i> Supprime</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->

<script src="custom/js/client.js"></script>

<?php require_once 'includes/footer.php'; ?>