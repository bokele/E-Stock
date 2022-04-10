<?php 
require_once 'core.php';

$sqlSociete = "SELECT nom_societe, siegle_societe, tele_societe, tele_societeSecond, postBP, pays, province, commune_societe, quartier, avenue,numero,email_societe, assujetti_tva, NIF_societe,Registre_commerce, centre_fiscal, forme_juridique, secteur_activite, logoSociete FROM societe";
$societeResult = $connect->query($sqlSociete);
$societeData = $societeResult->fetch_array();

$nom_societe 		= $societeData[0];
$siegle_societe 	= $societeData[1];
$tele_societe		= $societeData[2]; 
$tele_societeSecond = $societeData[3];
$postBP 			= $societeData[4];
$pays 				= $societeData[5]; 
$province 			= $societeData[6];
$commune_societe 	= $societeData[7];
$quartier 			= $societeData[8];
$avenue 			= $societeData[9];
$numero 			= $societeData[10];
$email_societe 		= $societeData[11];
$assujetti_tva 		= $societeData[12];
$NIF_societe 		= $societeData[13];
$Registre_commerce 	= $societeData[14];

$centre_fiscal 		= $societeData[15];
$forme_juridique	= $societeData[16];
$secteur_activite 	= $societeData[17];
$logoSociete 		= $societeData[18];







?>

    <table style="vertical-align: top;">
        <tr>
            <td class="100p"><img  src="<?php echo  $logoSociete; ?>" width="200px" >
        </tr>
        <tr>
        	<td class="100p" align="left">
            	NIF : <?php echo  $NIF_societe; ?><br>
            	R.C : <?php echo  $Registre_commerce; ?><br>
            	Centre fiscal :  <?php echo  $centre_fiscal; ?><br>
            	Secteur d'activité :  <?php echo  $secteur_activite; ?><br>

        	</td>

        	<td class="100p" align="center">
            	<strong><h2></h2></strong>
        	</td>

        	<td class="100p" align="right" style="margin-left: 30px; ">
            	B.P : <?php echo  $postBP." ".$province."-".$pays; ?><br>
            	Tél : <?php echo  $tele_societe." / ".$tele_societeSecond; ?><br>
            	Commune :  <?php echo  $commune_societe; ?><br>
            	Quartier :  <?php echo  $quartier; ?><br>
            	Avenue : de l' <?php echo  $avenue; ?><br>
        	</td>
    	</tr>
    	

</table>