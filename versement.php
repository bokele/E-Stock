<?php require_once 'includes/header.php'; ?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Home</a></li>		  
		  <li class="active">Versement</li>
		</ol>
		<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-primary button1" data-toggle="modal" data-target="#addBrandModel"> <i class="glyphicon glyphicon-plus-sign"></i>Ajoute Un nouveau versement </button>
				</div> <!-- /div-action -->		
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="fa fa-list"></i> Liste des versements</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				<div class="remove-messages"></div>

					<div class="box-body table-responsive no-padding" style="max-width:1124px;">	
				
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageVersementTable" width="100%" cellspacing="0">
			
					<thead>
						<tr>
							<th class="text-center" >Date versemnt</th>
							<th  class="text-center" >Banque</th>
							<th class="text-center" >Montant verse</th>
							<th  class="text-center" >Compte</th>						
							<th class="text-center" >Type</th>
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
    	
    	<form class="form-horizontal" id="submitVersementForm" action="php_action/createVersement.php" method="POST">
	      <div class="modal-header btn-primary">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Ajoute Un nouveau versement</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-brand-messages"></div>

	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Banque</label>

				    <div class="col-sm-4">
				      <select class="form-control" id="id_banque" name="id_banque">
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT id_banque, nom_banque FROM banque WHERE banque_status = 1 ORDER BY nom_banque ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				      
				    </div>
				    <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Numéro compte</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="numero_compte_banque" placeholder="Muméro de compte" name="numero_compte_banque" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->
	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Type vesrment</label>
	        	<div class="col-sm-4">
	        	 <select class="form-control" id="type_versement" name="type_versement">
				      	<option value="">~~SELECT~~</option>
				      		<option value="1">Cash</option>
				      		<option value="2">Chèque</option>
				      </select>
				  </div>
	        	
				    <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Montant verse</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="montant_verse" placeholder="Numéro de compte" name="montant_verse" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Date bordereau</label>

				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="date_bordereau" placeholder="Date du bordereau" name="date_bordereau" autocomplete="off">
				      
				    </div>
				    <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>N° berdereau</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="numero_bordereau" placeholder="N° du berdereau" name="numero_bordereau" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
	        <div class="form-group">
	        <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Nom Personne</label>

				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="nom_personne_verse" placeholder="Nom de la personne qui a verse" name="nom_personne_verse" autocomplete="off">
				      
				    </div>         	                	        

	      </div> <!-- /modal-body -->
	  </div>
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-trash"></i> Ferme</button>
	        
	        <button type="submit" class="btn btn-primary" id="createVersementBtn" data-loading-text="Loading..." autocomplete="off"><i class="fa fa-save"></i> Enregistre</button>
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
	     	<form class="form-horizontal" id="submitVersementViewForm"  method="POST">
	      <div class="modal-header btn-info">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Information sur versemnent</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-brand-messages"></div>

	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Banque</label>

				    <div class="col-sm-4">
				      <select class="form-control" id="id_banqueEdit" name="id_banqueEdit" disabled="true">
				      	<option value="">~~SELECT~~</option>
				      	<?php 
				      	$sql = "SELECT id_banque, nom_banque FROM banque WHERE banque_status = 1 ORDER BY nom_banque ASC";
								$result = $connect->query($sql);

								while($row = $result->fetch_array()) {
									echo "<option value='".$row[0]."'>".$row[1]."</option>";
								} // while
								
				      	?>
				      </select>
				      
				    </div>
				    <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Numéro compte</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="numero_compte_banqueEdit" placeholder="Muméro de compte" name="numero_compte_banqueEdit" autocomplete="off" disabled="true">
				    </div>
	        </div> <!-- /form-group-->
	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Type vesrment</label>
	        	<div class="col-sm-4">
	        	 <select class="form-control" id="type_versementEdit" name="type_versementEdit" disabled="true">
				      	<option value="">~~SELECT~~</option>
				      		<option value="1">Cash</option>
				      		<option value="2">Chèque</option>
				      </select>
				  </div>
	        	
				    <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Montant verse</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="montant_verseEdit" placeholder="Numéro de compte" name="montant_verseEdit" autocomplete="off" disabled="true">
				    </div>
	        </div> <!-- /form-group-->	
	        <div class="form-group">
	        	<label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Date bordereau</label>

				    <div class="col-sm-4">
				      <input type="date" class="form-control" id="date_bordereauEdit" placeholder="Date du bordereau" name="date_bordereauEdit" autocomplete="off" disabled="true">
				      
				    </div>
				    <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>N° berdereau</label>
				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="numero_bordereauEdit" placeholder="N° du berdereau" name="numero_bordereauEdit" autocomplete="off" disabled="true">
				    </div>
	        </div> <!-- /form-group-->	
	        <div class="form-group">
	        <label for="nom_banque" class="col-sm-2 control-label"><span class="text-danger">*</span>Nom Personne</label>

				    <div class="col-sm-4">
				      <input type="text" class="form-control" id="nom_personne_verseEdit" placeholder="Nom de la personne qui a verse" name="nom_personne_verseEdit" autocomplete="off" disabled="true">
				      
				    </div>         	                	        

	      </div> 
	      </div><!-- /modal-body -->

	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-trash"></i> Ferme</button>
	        
	        <button type="submit" class="btn btn-primary" id="createVersementBtn" data-loading-text="Loading..." autocomplete="off" disabled="true" ><i class="fa fa-save" ></i> Enregistre</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>

    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- / add modal -->
<!-- /edit brand -->


<!-- /remove brand -->

<script src="custom/js/versement.js"></script>

<?php require_once 'includes/footer.php'; ?>