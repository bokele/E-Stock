<?php require_once 'includes/header.php'; 

if($_GET['o'] == 'addUser') { 
// add order
	echo "<div class='div-request div-hide'>addUser</div>";
} else if($_GET['o'] == 'manOnline') { 
	echo "<div class='div-request div-hide'>manOnline</div>";
} else if($_GET['o'] == 'societe') { 
	echo "<div class='div-request div-hide'>societe</div>";
} // /else manage order

?>
<style type="text/css">

.user-circle-online {
    width: 15px!important;
    height: 25px!important;
    border-radius: 100%;
}

</style>

<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Tableau de Bord</a></li>		  
		  <li >Utilisateur</li>
		  <li class="active">
  			<?php if($_GET['o'] == 'addUser') { ?>
  				Gestion des utilisateurs
				<?php } else if($_GET['o'] == 'manOnline') { ?>
					Gestion des Connections
				<?php } // /else manage order ?>
  </li>
		</ol>


					<?php if($_GET['o'] == 'addUser') { 
			// add order
			?>
		<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-primary button1" data-toggle="modal" id="addutilisateurModalBtn" data-target="#addUtlisateurModal"> <i class="glyphicon glyphicon-plus-sign"></i>Ajoute Un Utilisateur </button>
				</div> <!-- /div-action -->	
				
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i>Gestion des utilisateurs</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				
					<div class="remove-messages"></div>
							
				<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageUtlisateurTable">
					<thead>
						<tr>
							<th class="text-center">Agence</th>							
							<th class="text-center">Nom</th>
							<th class="text-center">E-mail</th>
							<th class="text-center">Téléphone</th>
							<th class="text-center">Rôle</th>
							<th class="text-center">Status</th>
							<th class="text-center">En Ligne</th>
							<th style="width:15%;"  class="text-center">Options</th>
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
<div class="modal fade" id="addUtlisateurModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">

    	<form class="form-horizontal" id="submitUtilisateurForm" action="php_action/createUtilisateur.php" method="POST">
	      <div class="modal-header btn-primary">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-plus"></i> Ajoute Un utilisateur</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="add-utlisateur-messages"></div>
	      	 <div class="form-group">
	        	<label for="username" class="col-sm-4 control-label">Agence </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
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
	        </div> <!-- /form-group-->	

	        <div class="form-group">
	        	<label for="username" class="col-sm-4 control-label">Nom </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" id="username" placeholder="Nom" name="username" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	 
	         <div class="form-group">
	        	<label for="username" class="col-sm-4 control-label">E-mail </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <input type="email" class="form-control" id="email" placeholder="E-mail" name="email" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
	          <div class="form-group">
	        	<label for="username" class="col-sm-4 control-label">Téléphne </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <input type="telephone" class="form-control" id="telephone" placeholder="Téléphne" name="telephone" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
	        <div class="form-group">
	        	<label for="categoriesName" class="col-sm-4 control-label">Rôle </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				       <select class="form-control" id="role" name="role">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Directeur(trice)</option>
				      	<option value="2">Stock</option>
				      	<option value="3">Facturation</option>
				      	<option value="4">Comptable</option>
				      	<option value="5">Administreteur</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	        	        
	        <div class="form-group">
	        	<label for="categoriesStatus" class="col-sm-4 control-label">Status </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <select class="form-control" id="status" name="status">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Actif</option>
				      	<option value="2">Desactif</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	         	        
	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
	        
	        <button type="submit" class="btn btn-primary" id="createUtlisateurBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
	      </div> <!-- /modal-footer -->	      
     	</form> <!-- /.form -->	     
    </div> <!-- /modal-content -->    
  </div> <!-- /modal-dailog -->
</div> 
<!-- /add utlisateur -->

<!-- edit categories brand -->
<div class="modal fade" id="editCategoriesModal" tabindex="-1" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
    	
    	<form class="form-horizontal" id="editUtilisateurForm" action="php_action/editUtilisateur.php" method="POST">
	      <div class="modal-header btn-warning">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title"><i class="fa fa-edit"></i> Modifier l'Utilisateur</h4>
	      </div>
	      <div class="modal-body">

	      	<div id="edit-utilisateur-messages"></div>

	      	<div class="modal-loading div-hide" style="width:50px; margin:auto;padding-top:50px; padding-bottom:50px;">
						<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
						<span class="sr-only">Loading...</span>
					</div>


		      <div class="edit-utilisateur-result">
		      	<div class="form-group">
	        	<label for="username" class="col-sm-4 control-label">Agence </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				        <select class="form-control" id="editId_agence" name="editId_agence">
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
	        	<label for="username" class="col-sm-4 control-label">Nom </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" id="editUsername" placeholder="Nom" name="editUsername" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	 
	         <div class="form-group">
	        	<label for="username" class="col-sm-4 control-label">E-mail </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <input type="email" class="form-control" id="editEmail" placeholder="E-mail" name="editEmail" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
	          <div class="form-group">
	        	<label for="username" class="col-sm-4 control-label">Téléphne </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <input type="text" class="form-control" id="editTelephone" placeholder="Téléphne" name="editTelephone" autocomplete="off">
				    </div>
	        </div> <!-- /form-group-->	
	        <div class="form-group">
	        	<label for="categoriesName" class="col-sm-4 control-label">Rôle </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				       <select class="form-control" id="editRole" name="editRole">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Directeur(trice)</option>
				      	<option value="2">Stock</option>
				      	<option value="3">Facturation</option>
				      	<option value="4">Comptable</option>
				      	<option value="5">Administreteur</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	
	         <div class="form-group">
	        	<label for="categoriesStatus" class="col-sm-4 control-label">Status </label>
	        	<label class="col-sm-1 control-label">: </label>
				    <div class="col-sm-7">
				      <select class="form-control" id="editStatus" name="editStatus">
				      	<option value="">~~SELECT~~</option>
				      	<option value="1">Actif</option>
				      	<option value="2">Desactif</option>
				      </select>
				    </div>
	        </div> <!-- /form-group-->	
		      </div>         	        
		      <!-- /edit brand result -->

	      </div> <!-- /modal-body -->
	      
	      <div class="modal-footer editUtilisateurFooter">
	        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
	        
	        <button type="submit" class="btn btn-warning" id="editCategoriesBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
	      </div>
	      <!-- /modal-footer -->
     	</form>
	     <!-- /.form -->
    </div>
    <!-- /modal-content -->
  </div>
  <!-- /modal-dailog -->
</div>
<!-- /categories brand -->
<!-- categories brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeUtlisateurModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Supprime un utilisateur</h4>
      </div>
      <div class="modal-body">
        <p>Ets vous sûre de voiloir supprime cet utilisateur ?</p>
        <div id="utlisateurInfo" class="text-danger text-center"></div>
      </div>
      <div class="modal-footer removeCategoriesFooter">
        <button type="button" class="btn btn-default" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
        <button type="button" class="btn btn-primary" id="removeCategoriesBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-ok-sign"></i> OK</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /categories brand --> 
<?php } else if($_GET['o'] == 'manOnline'){ 
			// add order
			?>
			<div class="row">
	<div class="col-md-12">

	


			
		<div class="div-action pull pull-right" style="padding-bottom:20px;">
					<button class="btn btn-primary button1" data-toggle="modal" id="addutilisateurModalBtn" data-target="#addUtlisateurModal"> <i class="glyphicon glyphicon-plus-sign"></i>Ajoute Un Utilisateur </button>
				</div> <!-- /div-action -->	
				
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="page-heading"> <i class="glyphicon glyphicon-edit"></i>Gestion des utilisateurs</div>
			</div> <!-- /panel-heading -->
			<div class="panel-body">

				
					<div class="remove-messages"></div>
							
				<div class="col-md-12 table-responsive">
				<table class="table table-hover table-bordered table-striped table-outline mb-0 nowrap text-center" id="manageUtlisateurTableConnection">
					<thead>
						<tr>							
							<th class="text-center">Nom</th>
							<th class="text-center">Date Entre</th>
							<th class="text-center">Date Sortir</th>
							<th style="width:15%;"  class="text-center">Options</th>
						</tr>
					</thead>
				</table>
				<!-- /table -->
			</div>
			</div> <!-- /panel-body -->
		</div> <!-- /panel -->		
	</div> <!-- /col-md-12 -->
</div> <!-- /row -->

		<?php } 
			// add order
			?>


<?php 


?>

<script src="custom/js/utilisateur.js"></script>

<?php require_once 'includes/footer.php'; ?>