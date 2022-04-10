<?php 

require_once 'includes/header.php'; 
if($_GET['o'] == 'classe') { 
// add order
	echo "<div class='div-request div-hide'>classe</div>";
} else if($_GET['o'] == 'commptePrincipal') { 
	echo "<div class='div-request div-hide'>commptePrincipal</div>";
}  // /else manage order

else if($_GET['o'] == 'sousCompte') { 
	echo "<div class='div-request div-hide'>sousCompte</div>";
} // /else manage order

?>

<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Tableau de Bord</a></li>		  
		  <li ><a href="comptabilite.php?o=classe">Comptabilité</a></li>
		  	<li class="active">
  				<?php if($_GET['o'] == 'classe') { ?>
  					Gestion des classes comptable
				<?php } else if($_GET['o'] == 'commptePrincipal') { ?>
					Gestion des comptes principal
				<?php } else if($_GET['o'] == 'sousCompte'){ ?>
					Gestion des sous comptes comptable
				<?php } ?>
  			</li>
		</ol>
		<div class="div-action pull pull-center" style="padding-bottom:20px;">
				
			 <a href="comptabilite.php?o=commptePrincipal" class="btn btn-primary btn-sm"> <i class="fa fa-plus"></i> Ajoute une Compte Principale</a> 

			 <a href="comptabilite.php?o=sousCompte" class="btn btn-info btn-sm"> <i class="fa fa-plus"></i> Ajoute une Sous Compte</a> 
				

			</div>
			<div class="div-action pull pull-center" style="padding-bottom:20px;">
				
			</div>
		<?php if($_GET['o'] == 'classe') { ?>

			<div class="row">
				<!-- fin add bouton -->
				<div class="col-md-12">

					<div id="add-classe-messages"></div>

					
					<div class="div-action pull pull-right" style="padding-bottom:20px;">
				<button class="btn btn-primary button1" data-toggle="modal" id="addClasseModalBtn" data-target="#classeModal"> <i class="glyphicon glyphicon-plus-sign"></i> Ajoute une Classe</button>
			</div>

		
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="fa fa-list"></i>	Listes des Classes
						</div>
				<!-- /panel-heading -->
						<div class="panel-body">
							<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="manageClasseTable" class="table  table-bordered table-hover text-center">
					<thead>
						<tr class="tableheader">

							<th class="text-center">Libelle</th>
							<th class="text-center">Action</th>
							
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

						</div>
				<!-- /panel-body -->
					</div>
				</div>
	<!-- /col-dm-12 -->
			</div>
<div class="modal fade" tabindex="-1" role="dialog" id="classeModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> AJOUTE UNE CLASSE</h4>
      </div>
      <div class="modal-body">
        	<form class="form-horizontal" action="php_action/createClasse.php" method="post" id="getAClasseForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de la classe</label>
							    	<div class="col-sm-8">
							      		<input type="text" class="form-control" id="libelle_classe" name="libelle_classe" placeholder="Nom de la classe" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
							  	<div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="createClasseBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="classeEditModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i> AJOUTE UNE CLASSE</h4>
      </div>
      <div class="modal-body">
        	<form class="form-horizontal" action="php_action/editClasse.php" method="post" id="editAClasseForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de la classe</label>
							    	<div class="col-sm-8">
							      		<input type="text" class="form-control" id="libelle_classeEdit" name="libelle_classeEdit" placeholder="Nom de la classe" autocomplete="off"   />
							      		<input type="hidden" class="form-control" id="id_classeEdit" name="id_classeEdit" placeholder="Nom de la classe" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
							  	<div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="editClasseBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="removeClasseModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> SUPPRIMER UNE CLASSE</h4>
      </div>
    <div class="modal-body">
        <p>Voulez-vous vraiment supprimer cette Classe :<b> <span id="supprimer"></span> </b> ?</p>
      </div>
      <div class="modal-footer removeBrandFooter">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Ferme</button>
        <button type="button" class="btn btn-danger" id="removeAgenceBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-trash"></i> Supprime</button>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



		<?php } else if($_GET['o'] == 'commptePrincipal') { ?>

			<div class="row">
				<!-- fin add bouton -->
				<div class="col-md-12">
					<div id="add-classe-messages"></div>

					
					<div class="div-action pull pull-right" style="padding-bottom:20px;">
				<button class="btn btn-primary button1" data-toggle="modal" id="addCompteModalBtn" data-target="#compteModal"> <i class="fa fa-plus"></i> Ajoute un Compte</button>
			</div>

		
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="fa fa-list"></i>	Listes des Compte
						</div>
				<!-- /panel-heading -->
						<div class="panel-body">
							<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="manageCompteTable" class="table  table-bordered table-hover text-center">
					<thead>
						<tr class="tableheader">

							<th class="text-center">Code compte</th>
							<th class="text-center">Libelle du compte</th>
							<th class="text-center">Classe</th>
							<th class="text-center">Action</th>
							
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

						</div>
				<!-- /panel-body -->
					</div>
				</div>
	<!-- /col-dm-12 -->
			</div>
<div class="modal fade" tabindex="-1" role="dialog" id="compteModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-plus"></i> AJOUTE UN COMPTE</h4>
      </div>
      <div class="modal-body">
      	<div id="add-compte-messages"></div>
        	<form class="form-horizontal" action="php_action/createCompte.php" method="post" id="getCompteForm">
        						<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de classe</label>
							    	<div class="col-sm-8">
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
							    	
							  	</div>
							  	<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Code du compte</label>
							    	<div class="col-sm-8">
							      		<input type="text" class="form-control" id="code_compte" name="code_compte" placeholder="Code du compte" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom du compte</label>
							    	<div class="col-sm-8">
							      		<input type="text" class="form-control" id="libelle_compte" name="libelle_compte" placeholder="Nom de la classe" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
							  	<div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="createCompteBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="compteEditModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i> MODIFIER UN COMPTE</h4>
      </div>
      <div class="modal-body">
        	<form class="form-horizontal" action="php_action/editCompte.php" method="post" id="editACompteForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de classe</label>
							    	<div class="col-sm-8">
							      		<select class="form-control" id="id_classeEdit" name="id_classeEdit">
									      	<option value="">~~SELECT~~</option>
									      	<?php 
									      	$sql = "SELECT id, libelle_classe FROM comptabilite_classe_compte WHERE status=1 ORDER BY libelle_classe ASC";
													$result = $connect->query($sql);

													while($row = $result->fetch_array()) {
														echo "<option value='".$row[0]."'>".$row[1]." - CLASSE ".$row[0]."</option>";
													} // while
													
									      	?>
									      </select>
							    	</div>
							    	
							  	</div>
							  	<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Code du compte</label>
							    	<div class="col-sm-8">
							      		<input type="text" class="form-control" id="code_compteEdit" name="code_compteEdit" placeholder="Code du compte" autocomplete="off"   />
							      		<input type="hidden" class="form-control" id="id_compte_principalEdit" name="id_compte_principalEdit" placeholder="Code du compte" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom du compte</label>
							    	<div class="col-sm-8">
							      		<input type="text" class="form-control" id="libelle_compteEdit" name="libelle_compteEdit" placeholder="Nom de la classe" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
							  	<div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="editCompteBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="removeCompteModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> SUPPRIMER UN COMPTE</h4>
      </div>
    <div class="modal-body">
        <p>Voulez-vous vraiment supprimer ce compte :<b> <span id="supprimer"></span> </b> ?</p>
      </div>
      <div class="modal-footer removeBrandFooter">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Ferme</button>
        <button type="button" class="btn btn-danger" id="removeAgenceBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-trash"></i> Supprime</button>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


		<?php }else if($_GET['o'] == 'sousCompte') { ?>

			<div class="row">
				<!-- fin add bouton -->
				<div class="col-md-12">

					<div id="add-sousClasse-messages"></div>

					
					<div class="div-action pull pull-right" style="padding-bottom:20px;">
				<button class="btn btn-primary button1" data-toggle="modal" id="addSousCompteModalBtn" data-target="#sousCompteModal"> <i class="fa fa-list"></i> Ajoute un sous compte</button>
			</div>

		
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="fa fa-list"></i>	Listes des sous Comptes
						</div>
				<!-- /panel-heading -->
						<div class="panel-body">
							<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="manageSousCompteTable" class="table  table-bordered table-hover ">
					<thead>
						<tr class="tableheader">

							<th class="text-center">Code Sous Compte</th>
							<th class="text-center">Libelle Sous Compte</th>
							<th class="text-center">Compte</th>
							<th class="text-center">Action</th>
							
						</tr>
					</thead>
					<tbody></tbody>
				</table>
			</div>

						</div>
				<!-- /panel-body -->
					</div>
				</div>
	<!-- /col-dm-12 -->
			</div>
<div class="modal fade" tabindex="-1" role="dialog" id="sousCompteModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i> AJOUTE UN SOUS COMPTE</h4>
      </div>
      <div class="modal-body">
      	<div id="add-Souscompte-messages"></div>
        	<form class="form-horizontal" action="php_action/createSousCompte.php" method="post" id="getSousCompteForm">
        						<div class="form-group">
							    	<label for="nom_societe" class="col-sm-3 control-label">Nom de classe</label>
							    	<div class="col-sm-9">
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
							    	
							  	</div>
							  	<div class="form-group">
							    	<label for="nom_societe" class="col-sm-3 control-label">Nom du compte</label>
							    	<div class="col-sm-9">
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
							    	<label for="nom_societe" class="col-sm-3 control-label">Code du sous compte</label>
							    	<div class="col-sm-9">
							      		<input type="text" class="form-control" id="code_sous_compte" name="code_sous_compte" placeholder="Code du sous compte" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-3 control-label">Nom du sous  compte</label>
							    	<div class="col-sm-9">
							      		<input type="text" class="form-control" id="libelle_sous_compte" name="libelle_sous_compte" placeholder="Nom du sous  compte" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
							  	<div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="createSousCompteBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" tabindex="-1" role="dialog" id="sousCompteEditModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i> MODIFIER UN SOUS COMPTE</h4>
      </div>
      <div class="modal-body">
        	<form class="form-horizontal" action="php_action/editSousCompte.php" method="post" id="editSousCompteForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de classe</label>
							    	<div class="col-sm-8">
							      		<select class="form-control" id="id_classeEdit" name="id_classeEdit">
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
							    	
							  	</div>
							  	<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom du compte</label>
							    	<div class="col-sm-8">
							    		<div class="auto-widget">
							      		<select class="form-control" id="id_CompteEdit" name="id_CompteEdit">
									      	<option value="">~~SELECT~~</option>
									      	<?php 
									      $sql = "SELECT id_compte_principal, code_compte,libelle_compte FROM comptabilite_compte_principal WHERE status = 1  ORDER BY code_compte ASC ";
													$result = $connect->query($sql);

													while($row = $result->fetch_array()) {
														echo "<option value='".$row['id_compte_principal']."' id='id_compte".$row['id_compte_principal']."'>".$row['code_compte']."-".$row['libelle_compte']." </option>";
													} // while
													
									      	?>
									      </select>
							      	</div>
									    <script type="text/javascript">
				  						   
  
										</script>
							    	</div>
							    	
							  	</div>
							  	<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Code du sous compte</label>
							    	<div class="col-sm-8">
							      		<input type="text" class="form-control" id="code_sous_compteEdit" name="code_sous_compteEdit" placeholder="Code du compte" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom sous du compte</label>
							    	<div class="col-sm-8">
							      		<input type="text" class="form-control" id="libelle_sous_compteEdit" name="libelle_sous_compteEdit" placeholder="Nom sous du compte" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
							  	<div class="modal-footer">
							  		<input type="hidden" name="id_compte_sousEdit" id="id_compte_sousEdit" class="form-control" autocomplete="off"/>
							  		
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="fa fa-remove"></i> Fermer</button>
							        
							        <button type="submit" class="btn btn-primary" id="editCompteBtn" data-loading-text="Loading..." autocomplete="off"> <i class="fa fa-save"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" tabindex="-1" role="dialog" id="removeSousCompteModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> SUPPRIMER UN SOUS COMPTE</h4>
      </div>
    <div class="modal-body">
        <p>Voulez-vous vraiment supprimer ce sous compte :<b> <span id="supprimer"></span> </b> ?</p>
      </div>
      <div class="modal-footer removeBrandFooter">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Ferme</button>
        <button type="button" class="btn btn-danger" id="removeSousCompteBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-trash"></i> Supprime</button>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php } ?>
	</div>
</div>

<script src="custom/js/compte.js"></script>
<script src="custom/js/classe.js"></script>
<script src="custom/js/sousCompte.js"></script>
