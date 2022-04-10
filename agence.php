<?php 

require_once 'includes/header.php'; 
if($_GET['o'] == 'addUser') { 
// add order
	echo "<div class='div-request div-hide'>addUser</div>";
} else if($_GET['o'] == 'manOnline') { 
	echo "<div class='div-request div-hide'>manOnline</div>";
} else if($_GET['o'] == 'societe') { 
	echo "<div class='div-request div-hide'>societe</div>";
} // /else manage order

else if($_GET['o'] == 'agence') { 
	echo "<div class='div-request div-hide'>agence</div>";
} // /else manage order

?>


<div class="row">
	<div class="col-md-12">

		<ol class="breadcrumb">
		  <li><a href="dashboard.php">Tableau de Bord</a></li>		  
		  <li >société</li>
		  <li class="active">
  			<?php if($_GET['o'] == 'societe') { ?>
  				Gestion des information de la société
				<?php } else if($_GET['o'] == 'agence') { ?>
					Gestion des modifications des informations des la société
				<?php } // /else manage order ?>
  </li>
		</ol>


					<?php if($_GET['o'] == 'agence') { 
			// add order
					
			?>

			
			<div class="row">
				<!-- fin add bouton -->
				<div class="col-md-12">

					<div id="add-agence-messages"></div>

					
					<div class="div-action pull pull-right" style="padding-bottom:20px;">
				<button class="btn btn-primary button1" data-toggle="modal" id="addAgenceModalBtn" data-target="#agenceModal"> <i class="glyphicon glyphicon-plus-sign"></i> Ajoute une Agence</button>
			</div>

		
					<div class="panel panel-primary">
						<div class="panel-heading">
							<i class="glyphicon glyphicon-check"></i>	Listes des Agences
						</div>
				<!-- /panel-heading -->
						<div class="panel-body">
							<div class="box-body table-responsive no-padding" style="max-width:1124px;">
				<table id="manageAgenceTable" class="table  table-bordered table-hover ">
					<thead>
						<tr class="tableheader">

							<th >Agence</th>
							<th >Tél.</th>
							<th >Resp.</th>
							<th >Province - commune - Quartier - avenue - numero</th>
							<th >Action</th>
							
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
<!-- /row -->
<!-- -----------------------------   addd ------------------------- -->
<div class="modal fade" tabindex="-1" role="dialog" id="agenceModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i> IDENTIFICATION DE L'AGENCE</h4>
      </div>
      <div class="modal-body">
        	<form class="form-horizontal" action="php_action/createAgence.php" method="post" id="getAgenceInfomationForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de l'agence</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="agence" name="agence" placeholder="Nom de l'agence" autocomplete="off"   />
							    	</div>
							    	
							  	</div>
							  	<div class="form-group">
							    	<label for="tele_societe" class="col-sm-2 control-label">Téléphone  : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_agence" name="tele_agence" placeholder="Téléphone " autocomplete="off"  />
							    	</div>
							    	<label for="pays" class="col-sm-2 control-label">Province : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="province_agence" name="province_agence" placeholder="Province" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	
							    	<label for="province" class="col-sm-2 control-label">Commune :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="commune_agence" name="commune_agence" placeholder="Commune" autocomplete="off"    />
							    	</div>
							    	<label for="commune_societe" class="col-sm-2 control-label">Quartier :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="quartier_agence" name="quartier_agence" placeholder="Quartier" autocomplete="off"   />
							    	</div>
							  	</div>
							  <div class="form-group">
							    	
							    	<label for="quartier" class="col-sm-2 control-label">Avenue :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="avenue_agence" name="avenue_agence" placeholder="Avenue" autocomplete="off"   />
							    	</div>
							    	<label for="avenue" class="col-sm-2 control-label">Numéro : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="numero_agence" name="numero_agence" placeholder="Numéro" autocomplete="off"  />
							    	</div>
							  	</div>
							  
							  	
							  	
							  	<div class="form-group">
							    	<label for="	centre_fiscal" class="col-sm-2 control-label">Responsable : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="resp_agence" name="resp_agence" placeholder="Responsable" autocomplete="off"  />
							    	</div>
							    	<label for="forme_juridique" class="col-sm-2 control-label">Tél. Resp. : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_resp_agence" name="tele_resp_agence" placeholder="Téléphone du Responsqble" autocomplete="off"   />
							    	</div>

							  	</div>
							  	
							  	
							  	<div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="createAgenceBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- -----------------------------   / addd ------------------------- -->

<div class="modal fade" tabindex="-1" role="dialog" id="agenceModalEdit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i> MODIFICATION DES INFORMATION DE L'AGENCE : <span id="nom_agence"></span></h4>
      </div>
      <div class="modal-body">
        	<form class="form-horizontal" action="php_action/editAgence.php" method="post" id="editAgenceInfomationForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de l'agence</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="agenceEdit" name="agenceEdit" placeholder="Nom de l'agence" autocomplete="off"   />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="tele_societe" class="col-sm-2 control-label">Tél  : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_agenceEdit" name="tele_agenceEdit" placeholder="Téléphone " autocomplete="off"  />
							    	</div>
							    	<label for="pays" class="col-sm-2 control-label">Province : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="province_agenceEdit" name="province_agencEdite" placeholder="Province" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	
							    	<label for="province" class="col-sm-2 control-label">Commune :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="commune_agenceEdit" name="commune_agenceEdit" placeholder="Commune" autocomplete="off"    />
							    	</div>
							    	<label for="commune_societe" class="col-sm-2 control-label">Quartier :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="quartier_agenceEdit" name="quartier_agenceEdit" placeholder="Quartier" autocomplete="off"   />
							    	</div>
							  	</div>
							  <div class="form-group">
							    	
							    	<label for="quartier" class="col-sm-2 control-label">Avenue :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="avenue_agenceEdit" name="avenue_agenceEdit" placeholder="Avenue" autocomplete="off"   />
							    	</div>
							    	<label for="avenue" class="col-sm-2 control-label">Numéro : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="numero_agenceEdit" name="numero_agenceEdit" placeholder="Numéro" autocomplete="off"  />
							    	</div>
							  	</div>
							  
							  	
							  	
							  	<div class="form-group">
							    	<label for="	centre_fiscal" class="col-sm-2 control-label">Responsable : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="resp_aganceEdit" name="resp_aganceEdit" placeholder="Responsable" autocomplete="off"  />
							    	</div>
							    	<label for="forme_juridique" class="col-sm-2 control-label">Tél. Resp. : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_resp_agenceEdit" name="tele_resp_agenceEdit" placeholder="Téléphone du Responsqble" autocomplete="off"   />
							    	</div>

							  	</div>
							  	
							  	
							  	<div class="modal-footer">
							  		<input type="hidden" name="agenceIdEdit" id="agenceIdEdit">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

							        
							        <button type="submit" class="btn btn-primary" id="ediotAgenceBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- -----------------------------   / addd ------------------------- -->

<div class="modal fade" tabindex="-1" role="dialog" id="agenceModalView">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-info">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-eye"></i> LES INFORMATION DE L'AGENCE : <span id="nom_agenceInfo"></span></h4>
      </div>
      <div class="modal-body">
        	<form class="form-horizontal" action="" method="post" id="viewAgenceInfomationForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de l'agence</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="agenceInfo"  placeholder="Nom de l'agence" autocomplete="off"   disabled="true"/>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="tele_societe" class="col-sm-2 control-label">Tél  : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_agenceInfo"  placeholder="Téléphone " autocomplete="off" disabled="true" />
							    	</div>
							    	<label for="pays" class="col-sm-2 control-label">Province : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="province_agenceInfo"  placeholder="Province" autocomplete="off"  disabled="true"/>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	
							    	<label for="province" class="col-sm-2 control-label">Commune :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="commune_agenceInfo"  placeholder="Commune" autocomplete="off"   disabled="true" />
							    	</div>
							    	<label for="commune_societe" class="col-sm-2 control-label">Quartier :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="quartier_agenceInfo"  placeholder="Quartier" autocomplete="off"  disabled="true" />
							    	</div>
							  	</div>
							  <div class="form-group">
							    	
							    	<label for="quartier" class="col-sm-2 control-label">Avenue :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="avenue_agenceInfo"  placeholder="Avenue" autocomplete="off"   disabled="true"/>
							    	</div>
							    	<label for="avenue" class="col-sm-2 control-label">Numéro : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="numero_agenceInfo"  placeholder="Numéro" autocomplete="off"  disabled="true"/>
							    	</div>
							  	</div>
							  
							  	
							  	
							  	<div class="form-group">
							    	<label for="	centre_fiscal" class="col-sm-2 control-label">Responsable : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="resp_aganceInfo"  placeholder="Responsable" autocomplete="off" disabled="true" />
							    	</div>
							    	<label for="forme_juridique" class="col-sm-2 control-label">Tél. Resp. : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_resp_agenceInfo"  placeholder="Téléphone du Responsqble" autocomplete="off"   disabled="true" />
							    	</div>

							  	</div>
							  	
							  	
							  	<div class="modal-footer">
							  		<input type="hidden" name="agenceIdEdit" id="agenceIdEdit">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>

							        
							       
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="removeAgenceModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-danger">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-trash"></i> Supprimer la marque</h4>
      </div>
      <div class="modal-body">
        <p>Voulez-vous vraiment supprimer cette Agence :<b> <span id="supprimer"></span> </b> ?</p>
      </div>
      <div class="modal-footer removeBrandFooter">
        <button type="button" class="btn btn-primary" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Ferme</button>
        <button type="button" class="btn btn-danger" id="removeAgenceBtn" data-loading-text="Loading..."> <i class="glyphicon glyphicon-trash"></i> Supprime</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->
			<?php
					}
			?>


							
<script src="custom/js/agence.js"></script>

<?php require_once 'includes/footer.php'; ?>