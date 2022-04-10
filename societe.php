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

$sql = "SELECT nom_societe, siegle_societe, tele_societe, tele_societeSecond, postBP, pays, province, commune_societe, quartier, avenue, numero, email_societe, assujetti_tva, NIF_societe, Registre_commerce, centre_fiscal, forme_juridique, secteur_activite,societe_id, logoSociete FROM societe";
$result = $connect->query($sql);
$dataLine = $result->num_rows;
$nom_societeInfo; 
$siegle_societeInfo; 
$tele_societeInfo;
$tele_societeSecondInfo;
$postBPInfo;
$paysInfo;
$provinceInfo; 
$commune_societeInfo; 
$quartierInfo;
$avenueInfo;
$numeroInfo;
$email_societeInfo; 
$assujetti_tvaInfo;
$NIF_societeInfo;
$Registre_commerceInfo; 
$centre_fiscalInfo;
$forme_juridiqueInfo;
$secteur_activiteInfo;
$tva;
$societe_id;
$logoSociete;
while($data = $result->fetch_row()){
$nom_societeInfo 		= $data[0]; 
$siegle_societeInfo 	= $data[1]; 
$tele_societeInfo 		= $data[2];
$tele_societeSecondInfo	= $data[3];
$postBPInfo 			= $data[4];
$paysInfo 				= $data[5];
$provinceInfo 			= $data[6];
$commune_societeInfo 	= $data[7];
$quartierInfo 			= $data[8];
$avenueInfo				= $data[9];
$numeroInfo 			= $data[10];
$email_societeInfo 		= $data[11];
$assujetti_tvaInfo 		= $data[12];
$NIF_societeInfo 		= $data[13];
$Registre_commerceInfo 	= $data[14];
$centre_fiscalInfo 		= $data[15];
$forme_juridiqueInfo 	= $data[16];
$secteur_activiteInfo 	= $data[17];
$societe_id 			= $data[18];
$logoSociete 			= $data[19];

	if ($assujetti_tvaInfo == 1) {
		$tva = "Oui";
	}else{
		$tva = "Non";
	}

}






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
		  <li >société</li>
		  <li class="active">
  			<?php if($_GET['o'] == 'societe') { ?>
  				Gestion des information de la société
				<?php } else if($_GET['o'] == 'manOnline') { ?>
					Gestion des modifications des informations des la société
				<?php } // /else manage order ?>
  </li>
		</ol>


					<?php if($_GET['o'] == 'societe') { 
			// add order
					
			?>

			
			<div class="row">
				<!-- fin add bouton -->
				<div class="col-md-12">

					<div id="add-societe-messages"></div>
					<div class="div-action pull pull-right" style="padding-bottom:20px;">
				<button class="btn btn-primary button1" data-toggle="modal" id="addSocieteLogoModalBtn" data-target="#societeLogoModal"> <i class="glyphicon glyphicon-plus-sign"></i> Ajouter un Logo</button> 
			</div>

					<?php if ($dataLine == 0) {
						# la creation des informmation de la societe c fait une seule fois le reste passe en mode modification
					 ?>
					<div class="div-action pull pull-right" style="padding-bottom:20px;">
				<button class="btn btn-info button1" data-toggle="modal" id="addSocieteModalBtn" data-target="#societeModal"> <i class="glyphicon glyphicon-plus-sign"></i> Information Societe</button>
			</div>

		<?php }else {
			?>
			<div class="div-action pull pull-right" style="padding-bottom:20px;">

				<a type="button" data-toggle="modal" data-target="#societeModalEdit" id="editSocieteModalBtn" onclick="editSociete('<?php echo $societe_id; ?>')" class="btn btn-info button1"> <i class="glyphicon glyphicon-pencil"></i> Modification</a>	
				
			</div>
			<?php
		}
			?>		



			<div class="panel panel-info">
						<div class="panel-heading">
							<i class="glyphicon glyphicon-check"></i>	INFORMATION DE LA SOCIETE
						</div>
				<!-- /panel-heading -->
						<div class="panel-body">
							<img  src="stock/<?php echo $logoSociete; ?>" width="200px" >

							<form class="form-horizontal" action="" method="post" id="getInformationForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de la société</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="nom_societeInfo" name="nom_societeInfo" placeholder="Nom de la société" autocomplete="off" value="<?php echo $nom_societeInfo;  ?>" disabled="true" />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="siegle_societe" class="col-sm-2 control-label">Siègle</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="siegle_societeInfo" name="siegle_societeInfo" placeholder="Siègle" autocomplete="off" disabled="true" value="<?php echo $siegle_societeInfo;  ?>" />
							    	</div>
							    	<label for="bp" class="col-sm-2 control-label">B.P </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="postBPInfo" name="postBPInfo" placeholder="B.P" autocomplete="off" disabled="true"   value="<?php echo $postBPInfo;  ?>"/>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="tele_societe" class="col-sm-2 control-label">Tél 1  </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_societeInfo" name="tele_societeInfo" placeholder="Téléphone 1" autocomplete="off" disabled="true"  value="<?php echo $tele_societeInfo;  ?>"/>
							    	</div>
							    	<label for="tele_societe" class="col-sm-2 control-label">Tél 2 </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_societeInfo2" name="tele_societeInfo2" placeholder="Téléphone 2" autocomplete="off"  disabled="true"  value="<?php echo $tele_societeSecondInfo;  ?>" />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="pays" class="col-sm-2 control-label">Pays</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="paysInfo" name="paysInfo" placeholder="Pays" autocomplete="off" disabled="true"  value="<?php echo $paysInfo;  ?>"/>
							    	</div>
							    	<label for="province" class="col-sm-2 control-label">Province </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="provinceInfo" name="provinceInfo" placeholder="Province" autocomplete="off"  disabled="true"  value="<?php echo $provinceInfo;  ?>"/>
							    	</div>
							  	</div>
							  <div class="form-group">
							    	<label for="commune_societe" class="col-sm-2 control-label">Commune</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="commune_societeInfo" name="commune_societeInfo" placeholder="Commune" autocomplete="off" disabled="true"  value="<?php echo $commune_societeInfo;  ?>"/>
							    	</div>
							    	<label for="quartier" class="col-sm-2 control-label">Quartier </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="quartierInfo" name="quartierInfo" placeholder="Quartier" autocomplete="off"  disabled="true"  value="<?php echo $quartierInfo;  ?>"/>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="avenue" class="col-sm-2 control-label">Avenue</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="avenueInfo" name="avenueInfo" placeholder="Avenue" autocomplete="off" disabled="true"  value="<?php echo $avenueInfo;  ?>"/>
							    	</div>
							    	<label for="numero" class="col-sm-2 control-label">Numéro </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="numeroInfo" name="numeroInfo" placeholder="Numéro" autocomplete="off"  disabled="true"  value="<?php echo $numeroInfo;  ?>"/>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="email_societe" class="col-sm-2 control-label">E-mail</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="email_societeInfo" name="email_societeInfo" placeholder="E-mail" autocomplete="off" disabled="true"  value="<?php echo $email_societeInfo;  ?>"/>
							    	</div>
							    	<label for="assujetti_tva" class="col-sm-2 control-label">TVA </label>
							    	<div class="col-sm-4">
							      		<input type="te4t" class="form-control" id="assujetti_tvaInfo" name="assujetti_tvaInfo" placeholder="TVA" autocomplete="off" disabled="true"  value="<?php echo $tva;  ?>"/>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="NIF_societe" class="col-sm-2 control-label">NIF</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="NIF_societeInfo" name="NIF_societeInfo" placeholder="NIF" autocomplete="off" disabled="true"  value="<?php echo $NIF_societeInfo;  ?>"/>
							    	</div>
							    	<label for="Registre_commerce" class="col-sm-2 control-label">RC </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="Registre_commerceInfo" name="Registre_commerceInfo" placeholder="Registre du Commerce" autocomplete="off" disabled="true"  value="<?php echo $Registre_commerceInfo;  ?>"/>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="	centre_fiscal" class="col-sm-2 control-label">Centre Fiscal</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="centre_fiscalInfo" name="centre_fiscalInfo" placeholder="Centre Fiscal" autocomplete="off" disabled="true"  value="<?php echo $centre_fiscalInfo;  ?>"/>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="forme_juridique" class="col-sm-2 control-label">Forme Juridique </label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="forme_juridiqueInfo" name="forme_juridiqueInfo" placeholder="Forme Juridique" autocomplete="off" disabled="true"  value="<?php echo $forme_juridiqueInfo;  ?>"/>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="secteur_activite" class="col-sm-2 control-label">Secteur d'activité </label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="secteur_activiteInfo" name="secteur_activiteInfo" placeholder="Secteur d'activité " autocomplete="off" disabled="true"  value="<?php echo $secteur_activiteInfo;  ?>"/>
							    	</div>
							  	</div>
							 </form>

						</div>
				<!-- /panel-body -->
					</div>
				</div>
	<!-- /col-dm-12 -->
			</div>
<!-- /row -->
<!-- -----------------------------   addd ------------------------- -->
<div class="modal fade" tabindex="-1" role="dialog" id="societeModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa"></i> IDENTIFICATION DE LA SOCIETE</h4>
      </div>
      <div class="modal-body">
        	<form class="form-horizontal" action="php_action/createSociete.php" method="post" id="getSocieteInfomationForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de la société </label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="nom_societe" name="nom_societe" placeholder="Nom de la société" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="siegle_societe" class="col-sm-2 control-label">Siègle :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="siegle_societe" name="siegle_societe" placeholder="Siègle" autocomplete="off" />
							    	</div>
							    	<label for="bp" class="col-sm-2 control-label">B.P :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="bp" name="bp" placeholder="B.P" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="tele_societe" class="col-sm-2 control-label">Tél 1 : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_societe" name="tele_societe" placeholder="Téléphone 1" autocomplete="off" />
							    	</div>
							    	<label for="tele_societeSecond" class="col-sm-2 control-label">Tél 2 :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_societeSecond" name="tele_societeSecond" placeholder="Téléphone 2" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="pays" class="col-sm-2 control-label">Pays :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="pays" name="pays" placeholder="Pays" autocomplete="off" />
							    	</div>
							    	<label for="province" class="col-sm-2 control-label">Province :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="province" name="province" placeholder="Province" autocomplete="off"  />
							    	</div>
							  	</div>
							  <div class="form-group">
							    	<label for="commune_societe" class="col-sm-2 control-label">Commune :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="commune_societe" name="commune_societe" placeholder="Commune" autocomplete="off" />
							    	</div>
							    	<label for="quartier" class="col-sm-2 control-label">Quartier :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="quartier" name="quartier" placeholder="Quartier" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="avenue" class="col-sm-2 control-label">Avenue :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="avenue" name="avenue" placeholder="Avenue" autocomplete="off" />
							    	</div>
							    	<label for="numero" class="col-sm-2 control-label">Numéro :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="numero" name="numero" placeholder="Numéro" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="email_societe" class="col-sm-2 control-label">E-mail :</label>
							    	<div class="col-sm-4">
							      		<input type="email" class="form-control" id="email_societe" name="email_societe" placeholder="E-mail" autocomplete="off"  />
							    	</div>
							    	<label for="assujetti_tva" class="col-sm-2 control-label">TVA :</label>
							    	<div class="col-sm-4">
							      		
							      		 <select class="form-control" id="assujetti_tva" name="assujetti_tva">
									      	<option value="">~~SELECT~~</option>
									      	<option value="1">OUi</option>
									      	<option value="2">Non</option>
									      </select>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="NIF_societe" class="col-sm-2 control-label">NIF :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="NIF_societe" name="NIF_societe" placeholder="NIF" autocomplete="off"  />
							    	</div>
							    	<label for="Registre_commerce" class="col-sm-2 control-label">RC :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="Registre_commerce" name="Registre_commerce" placeholder="Registre du Commerce" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="	centre_fiscal" class="col-sm-2 control-label">Centre Fiscal :</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="centre_fiscal" name="centre_fiscal" placeholder="Centre Fiscal" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="forme_juridique" class="col-sm-2 control-label">Forme Juridique :</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="forme_juridique" name="forme_juridique" placeholder="Forme Juridique" autocomplete="off" />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="secteur_activite" class="col-sm-2 control-label">Secteur d'activité</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="secteur_activite" name="secteur_activite" placeholder="Secteur d'activité " autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="modal-footer">
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="createSocieteBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- -----------------------------   / addd ------------------------- -->

<div class="modal fade" tabindex="-1" role="dialog" id="societeModalEdit">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header btn-warning">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="glyphicon glyphicon-pencil"></i> MODIFICATION DES INFORMATION DE LA SOCIETE</h4>
      </div>
      <div class="modal-body">
        	<form class="form-horizontal" action="php_action/editSociete.php" method="post" id="editSocieteInfomationForm">
				 				<div class="form-group">
							    	<label for="nom_societe" class="col-sm-2 control-label">Nom de la société </label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="nom_societeEdit" name="nom_societeEdit" placeholder="Nom de la société" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="siegle_societe" class="col-sm-2 control-label">Siègle :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="siegle_societeEdit" name="siegle_societeEdit" placeholder="Siègle" autocomplete="off" />
							    	</div>
							    	<label for="bp" class="col-sm-2 control-label">B.P :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="bpEdit" name="bpEdit" placeholder="B.P" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="tele_societe" class="col-sm-2 control-label">Tél 1 : </label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_societEdite" name="tele_societEdite" placeholder="Téléphone 1" autocomplete="off" />
							    	</div>
							    	<label for="tele_societeSecond" class="col-sm-2 control-label">Tél 2 :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="tele_societeSecondEdit" name="tele_societeSecondEdit" placeholder="Téléphone 2" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="pays" class="col-sm-2 control-label">Pays :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="paysEdit" name="paysEdit" placeholder="Pays" autocomplete="off" />
							    	</div>
							    	<label for="province" class="col-sm-2 control-label">Province :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="provinceEdit" name="provinceEdit" placeholder="Province" autocomplete="off"  />
							    	</div>
							  	</div>
							  <div class="form-group">
							    	<label for="commune_societe" class="col-sm-2 control-label">Commune :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="commune_societeEdit" name="commune_societeEdit" placeholder="Commune" autocomplete="off" />
							    	</div>
							    	<label for="quartier" class="col-sm-2 control-label">Quartier :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="quartierEdit" name="quartierEdit" placeholder="Quartier" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="avenue" class="col-sm-2 control-label">Avenue :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="avenueEdit" name="avenueEdit" placeholder="Avenue" autocomplete="off" />
							    	</div>
							    	<label for="numero" class="col-sm-2 control-label">Numéro :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="numeroEdit" name="numeroEdit" placeholder="Numéro" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="email_societe" class="col-sm-2 control-label">E-mail :</label>
							    	<div class="col-sm-4">
							      		<input type="email" class="form-control" id="email_societeEdit" name="email_societeEdit" placeholder="E-mail" autocomplete="off"  />
							    	</div>
							    	<label for="assujetti_tva" class="col-sm-2 control-label">TVA :</label>
							    	<div class="col-sm-4">
							      		
							      		 <select class="form-control" id="assujetti_tvaEdit" name="assujetti_tvaEdit">
									      	<option value="">~~SELECT~~</option>
									      	<option value="1">OUi</option>
									      	<option value="2">Non</option>
									      </select>
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="NIF_societe" class="col-sm-2 control-label">NIF :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="NIF_societeEdit" name="NIF_societeEdit" placeholder="NIF" autocomplete="off"  />
							    	</div>
							    	<label for="Registre_commerce" class="col-sm-2 control-label">RC :</label>
							    	<div class="col-sm-4">
							      		<input type="text" class="form-control" id="Registre_commerceEdit" name="Registre_commerceEdit" placeholder="Registre du Commerce" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="	centre_fiscal" class="col-sm-2 control-label">Centre Fiscal :</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="centre_fiscalEdit" name="centre_fiscalEdit" placeholder="Centre Fiscal" autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="forme_juridique" class="col-sm-2 control-label">Forme Juridique :</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="forme_juridiqueEdit" name="forme_juridiqueEdit" placeholder="Forme Juridique" autocomplete="off" />
							    	</div>
							  	</div>
							  	<div class="form-group">
							    	<label for="secteur_activite" class="col-sm-2 control-label">Secteur d'activité</label>
							    	<div class="col-sm-10">
							      		<input type="text" class="form-control" id="secteur_activiteEdit" name="secteur_activiteEdit" placeholder="Secteur d'activité " autocomplete="off"  />
							    	</div>
							  	</div>
							  	<div class="modal-footer">
							  		<input type="hidden" value="<?php echo $societe_id; ?>"  id="editSociete_id" name="societeId"/>
							        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Close</button>
							        
							        <button type="submit" class="btn btn-primary" id="editSocieteBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
							     </div> <!-- /modal-footer -->	 
							 </form>
      					</div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

			<?php
					}
			?>



<!-- remove brand -->
<div class="modal fade" tabindex="-1" role="dialog" id="societeLogoModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header btn-primary">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><i class="fa fa-image"></i> Ajoute un Logo</h4>
      </div>
      <div class="modal-body">
      	<form class="form-horizontal" id="submitLogoForm" action="php_action/createLogo.php" method="POST" enctype="multipart/form-data">
       	<div class="form-group">
	        	<label for="productImage" class="col-sm-3 control-label">Logo : </label>
				    <div class="col-sm-8">
					    <!-- the avatar markup -->
						<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div>							
					    <div class="kv-avatar center-block">					        
					        <input type="file" class="form-control" id="logoImage" placeholder="Product Name" name="logoImage" class="file-loading" style="width:auto;"/>
					    </div>
					    <input type="hidden" name="societe_id" value="1">
				      
				    </div>
	        </div> <!-- /form-group-->
	          <div class="modal-footer removeBrandFooter">
		        <button type="button" class="btn btn-danger" data-dismiss="modal"> <i class="glyphicon glyphicon-remove-sign"></i> Fermer</button>
		        <button type="submit" class="btn btn-primary" id="createLogoBtn" data-loading-text="Loading..." autocomplete="off"> <i class="glyphicon glyphicon-ok-sign"></i> Enregistre</button>
		      </div>	
	    </form>
      </div>
    
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /remove brand -->
							
<script src="custom/js/societe.js"></script>
<script src="custom/js/logo.js"></script>
<?php require_once 'includes/footer.php'; ?>