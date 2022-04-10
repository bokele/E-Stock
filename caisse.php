<?php require_once 'includes/header.php'; ?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Caisse</li>
		</ol>
		<div id="add-brand-messages"></div>	
		<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-danger button1" data-toggle="modal" data-target="#addCaisseModel"> <i class="fa fa-plus"></i> Génére le livre du caisse</button>
				</div> <!-- /div-action -->	
					
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-list"></i> Historique de montants en caisse</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

					<div class="box-body table-responsive no-padding" style="max-width:1124px;">	
				
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageCaisseTable" width="100%" cellspacing="0">
			
					<thead>
						<tr>							
							<th class="text-center" >Date</th>
							<th class="text-center" >Montant en caisse</th>
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

<div class="modal fade" id="addCaisseModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="submitCaisseForm" action="php_action/createCaisse.php" method="POST">
	      <div class="modal-header btn-primary">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Génére le livre de caisse</h4>
	      </div>
	      <div class="modal-body">

	      

	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-4 control-label">Date</label>

				    <div class="col-sm-8">
				      <input type="text" class="form-control" id="date_caisse" placeholder="La date " name="date_caisse" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	         	                	        

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-trash"></i> Ferme</button>
	        
	        <button type="submit" class="btn btn-primary" id="createCaisseBtn" data-loading-text="Loading..." autocomplete="off"><i class="fa fa-save"></i> Générer</button>
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
<div class="modal fade" id="editBrandModel" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="editBanqueForm" action="php_action/editBanque.php" method="POST">
	      <div class="modal-header btn-warning">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Modification d' une banque</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="edit-brand-messages"></div>

	      	<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>

		      <div class="edit-brand-result">
		      	<div class="form-group">
		        	<label for="editnom_banque" class="col-sm-4 control-label">Nom de la Bnaque </label>
					    <div class="col-sm-8">
					      <input type="text" class="form-control" id="editnom_banque" placeholder="Nom de la Banque" name="editnom_banque" autocomplete="off">
					    </div>
		        </div> <!-- /form-group-->	         	        
		      </div>         	        
		      <!-- /edit brand result -->

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer editBrandFooter">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Ferme</button>
	        
	        <button type="submit" class="btn btn-warning" id="editBanqueBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
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
<!-- /edit brand -->

<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeMemberModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-trash"></i> Supprimer la banque</h4>
      </div>
      <div class="modal-body">
        <p>Voulez-vous vraiment supprimer cette Banque :<b> <span id="supprimer"></span> </b> ?</p>
      </div>
      <div class="modal-footer removeBrandFooter">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="fa fa-remove"></i> Ferme</button>
        <button type="button" class="btn btn-danger" id="removeBrandBtn" data-loading-text="Loading..."> <i class="fa fa-trash"></i> Supprime</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->

<script src="custom/js/caisse.js"></script>

<?php require_once 'includes/footer.php'; ?>