<style type="text/css">
    table { 
        width: 95%; 
        color: #717375; 
        font-family: helvetica; 
        line-height: 5mm; 
        border-collapse: collapse; 
    }
    h2 { margin: 0; padding: 0; }
    p { margin: 5px; }
 
    .border th { 
        border: 1px solid #000;  
        color: white; 
        background: #000; 
        padding: 5px; 
        font-weight: normal; 
        font-size: 14px; 
        text-align: center; 
        }

        .bordeRed th { 
        border: 1px solid #000;  
        color: white; 
        background: red; 
        padding: 5px; 
        font-weight: normal; 
        font-size: 14px; 
        text-align: center; 
        }
    .border td { 
        border: 1px solid #CFD1D2; 
        padding: 5px 10px 10px 5px; 
        text-align: center; 
    }

     .0 td { 
        border: 1px solid #CFD1D2; 
        padding: 5px 10px 10px 5px; 
        text-align: center; 
    }
    .no-border { 
        border-right: 1px solid #CFD1D2; 
        border-left: none; 
        border-top: none; 
        border-bottom: none;
    }
    .space { padding-top: 250px; }
 
    .10p { width: 10%; } .15p { width: 15%; } 
    .25p { width: 25%; } .50p { width: 50%; } 
    .60p { width: 60%; } .75p { width: 75%; }
</style>


<?php 
require_once 'core.php';
$startDate      = $_POST["startDateCaisse"];
$endDate        = $_POST["endDateCaisse"];

// Create new PDF
    $startDate = $_POST['startDateCaisse'];
    $date = DateTime::createFromFormat('m/d/Y',$startDate);
    $start_date = $date->format("Y-m-d");


    $endDate = $_POST['endDateCaisse'];
    $format = DateTime::createFromFormat('m/d/Y',$endDate);
    $end_date = $format->format("Y-m-d");


   // ----- ------------------ ------------ Savoinor  TVA  ------------------------ --->
    $sql = "SELECT id_commande, ref_commande, date_commande, brand_name, prix_total_achat, status,  user_add, date_add FROM boncommande INNER JOIN brands ON brand_id = id_marque  WHERE date_commande >= '$start_date' AND date_commande <= '$end_date'  GROUP BY ref_commande";

      $query = $connect->query($sql);

      $table = "";

 include("../includes/headerSociete.php");

 $table .='<p> <h2 align="center"><u><b>Livre de caisse '. $date->format("d/m/y").' AU '.$format->format("d/m/y").'</b></u></h2></p>

<p> <h4 align="center">Liste Des Commandes</h4></p>';

$table .='<table style="" class="border">
        <tr>
       		<th class="5p">Date</th>
            <th class="5p">Compte</th>
            <th class="15p">N<sup>o</sup>.</th>
            <th class="30p">Fournisseur</th>
             <th class="30p">Rroduit</th>
            <th class="5p">Quantité</th>
            <th class="10p">P.U</th>
            <th class="20p">P.T</th>
        </tr>';

 while ($result = $query->fetch_assoc()) { 
    $id_commande 		= $result['id_commande'];
    $date_commande 		= new DateTime( $result["date_commande"]);
	$ref_commande 		= $result["ref_commande"];
	$brand_name 		= $result["brand_name"];
	$prix_total_achat	= $result["prix_total_achat"]; 
	

	$sql = "SELECT code_compte, boncommande_paye.montant, type_paiement, status_paiement, date_paiement, boncommande_paye.observation FROM  boncommande_paye INNER JOIN boncommande  ON boncommande.id_commande = boncommande_paye.id_boncommande WHERE  boncommande_paye.id_boncommande =  $id_commande";
	$sortiePayeResult = $connect->query($sql);

	$vide="";
	$code_compte 			= $vide;
	$montantPaye 			= $vide;
	$type_paiement 			= $vide;
	$status_paiement 		= $vide;
	$date_paiement 			= $vide;
	$observation 			= $vide;
	$status_payement		= $vide; 

	if ($sortiePayeResult->num_rows > 0) {
		$sortiePayeData = $sortiePayeResult->fetch_array();
		$code_compte 			= $sortiePayeData[0];
		$montantPaye 			= $sortiePayeData[1];
		$type_paiement 			= $sortiePayeData[2];
		$status_paiement 		= $sortiePayeData[3];
		$date_paiement 			= new DateTime($sortiePayeData[4]);
		$observation 			= $sortiePayeData[5];
		//$status_payement		= $sortiePayeData[6]; 
	}else{
		$code_compte 			= $vide;
		$montantPaye 			= $vide;
		$type_paiement 			= $vide;
		$status_paiement 		= $vide;
		$date_paiement 			= $vide;
		$observation 			= $vide;
		$status_payement		= $vide; 
	}



if ($code_compte != "") {
	$compteSql = "SELECT comptabilite_sous_compte.code_sous_compte, comptabilite_sous_compte.libelle_sous_compte, comptabilite_compte_principal.code_compte, comptabilite_compte_principal.libelle_compte
 FROM comptabilite_sous_compte
	INNER JOIN comptabilite_compte_principal ON comptabilite_compte_principal.id_compte_principal = comptabilite_sous_compte.id_compte_principal 
 WHERE comptabilite_sous_compte.id_sous_compte = '$code_compte'";

 $compteResult = $connect->query($compteSql);

$row = $compteResult->fetch_array();
	$compte = $row[0];
	
}else{
	$compte = "";
}




	$commandeItemSql = "SELECT boncommande_item.id_commande, boncommande_item.quantite, boncommande_item.prix_achat, boncommande_item.prix_achat_total, product.product_name FROM boncommande_item
	INNER JOIN product ON boncommande_item.id_produit = product.product_id 
 	WHERE boncommande_item.id_commande = $id_commande";

	
	$orderItemResult = $connect->query($commandeItemSql);
    $lineRow = $orderItemResult->num_rows;

	$table .=' <tr>
		<td rowspan="'.$lineRow.'">'.$date_commande->format("d/m/Y").'</td>
        <td rowspan="'.$lineRow.'">'.$compte.'</td>
        <td rowspan="'.$lineRow.'">'.$ref_commande.'</td>
        <td rowspan="'.$lineRow.'">'.$brand_name.'</td>';

	$x = 1;
	$commandeItemResult = $connect->query($commandeItemSql);
	while($row = $commandeItemResult->fetch_assoc()) {	

		 $table .='<td >'.$row["product_name"].'</td>
                <td >'.$row["quantite"].'</td>
                <td >'.$row["prix_achat"].' </td>
                <td >'.$row["prix_achat_total"].' </td>
            </tr>';
               $table .=' </tr>';

                            //$totalTVAC +=$totalAmount; // total 
                           // $totalTVA +=$vat; // total de tva
                           // $totalHTVA +=$subTotal; // total hors tva
	}



}
$table .='</table>';

$startDate      = $_POST["startDateCaisse"];
$endDate        = $_POST["endDateCaisse"];

// Create new PDF
    $startDate = $_POST['startDateCaisse'];
    $date = DateTime::createFromFormat('m/d/Y',$startDate);
    $start_date = $date->format("Y-m-d");


    $endDate = $_POST['endDateCaisse'];
    $format = DateTime::createFromFormat('m/d/Y',$endDate);
    $end_date = $format->format("Y-m-d");


   // ----- ------------------ ------------ Savoinor  TVA  ------------------------ --->
    $sql = "SELECT id_commande, ref_commande, date_commande, brand_name, prix_total_achat, status,  user_add, date_add FROM boncommande INNER JOIN brands ON brand_id = id_marque  WHERE date_commande >= '$start_date' AND date_commande <= '$end_date'  GROUP BY ref_commande";

      $query = $connect->query($sql);

      $table .= "<br/><br/><br/>";


$table .='<table style="" class="border">
        <tr>
       		<th class="5p">Date</th>
            <th class="5p">Compte</th>
            <th class="5p">Type</th>
            <th class="15p">N° Ref.</th>
            <th class="30p">N° Fact.</th>
            <th class="30p">Fournisseur</th>
            <th class="20p">P.T à Payer</th>
            <th class="20p">P.T Payé</th>
        </tr>';

 while ($result = $query->fetch_assoc()) { 
    $id_commande 		= $result['id_commande'];
    $date_commande 		= new DateTime( $result["date_commande"]);
	$ref_commande 		= $result["ref_commande"];
	$brand_name 		= $result["brand_name"];
	$prix_total_achat	= $result["prix_total_achat"]; 
	

	$sql = "SELECT code_compte, boncommande_paye.montant, type_paiement, status_paiement, date_paiement, boncommande_paye.observation, numero_facture_boncommande FROM  boncommande_paye INNER JOIN boncommande  ON boncommande.id_commande = boncommande_paye.id_boncommande WHERE  boncommande_paye.id_boncommande =  $id_commande";
	$sortiePayeResult = $connect->query($sql);

	$vide="";
	$code_compte 			= $vide;
	$montantPaye 			= $vide;
	$type_paiement 			= $vide;
	$status_paiement 		= $vide;
	$date_paiement 			= $vide;
	$observation 			= $vide;
	$status_payement		= $vide;
    $numero_facture_boncommande = $vide;
    $status=""; 

	if ($sortiePayeResult->num_rows > 0) {
		$sortiePayeData = $sortiePayeResult->fetch_array();
		$code_compte 			= $sortiePayeData[0];
		$montantPaye 			= $sortiePayeData[1];
		$type_paiement 			= $sortiePayeData[2];
		$status_paiement 		= $sortiePayeData[3];
		$date_paiement 			= new DateTime($sortiePayeData[4]);
		$observation 			= $sortiePayeData[5];
		$numero_facture_boncommande		= $sortiePayeData[6]; 
	}else{
		$code_compte 			= $vide;
		$montantPaye 			= $vide;
		$type_paiement 			= $vide;
		$status_paiement 		= $vide;
		$date_paiement 			= $vide;
		$observation 			= $vide;
		$status_payement		= $vide; 
	}

if ($type_paiement == 1 ) {
        $status = "<label class='label label-success text-center'> Chèque</label>";

    }else if ($type_paiement== 2) {
        $status = "<label class='label label-warning text-center'> Cash</label>";
    }else if ($type_paiement == 3) {
        $status = "<label class='label label-danger text-center'> Carte de Credit</label>";
    }

if ($code_compte != "") {
	$compteSql = "SELECT comptabilite_sous_compte.code_sous_compte, comptabilite_sous_compte.libelle_sous_compte, comptabilite_compte_principal.code_compte, comptabilite_compte_principal.libelle_compte
 FROM comptabilite_sous_compte
	INNER JOIN comptabilite_compte_principal ON comptabilite_compte_principal.id_compte_principal = comptabilite_sous_compte.id_compte_principal 
 WHERE comptabilite_sous_compte.id_sous_compte = '$code_compte'";

 $compteResult = $connect->query($compteSql);

$row = $compteResult->fetch_array();
	$compte = $row[0];
	
}else{
	$compte = "";
}




	$commandeItemSql = "SELECT boncommande_item.id_commande, boncommande_item.quantite, boncommande_item.prix_achat, boncommande_item.prix_achat_total, product.product_name FROM boncommande_item
	INNER JOIN product ON boncommande_item.id_produit = product.product_id 
 	WHERE boncommande_item.id_commande = $id_commande";

	
	$orderItemResult = $connect->query($commandeItemSql);
    $lineRow = $orderItemResult->num_rows;

	$table .=' <tr>
		<td >'.$date_commande->format("d/m/Y").'</td>
        <td >'.$compte.'</td>
         <td >'.$status.'</td>
        <td >'.$ref_commande.'</td>
         <td >'.$numero_facture_boncommande.'</td>
        <td >'.$brand_name.'</td>';
        
	$x = 1;
	$total="";
	$commandeItemResult = $connect->query($commandeItemSql);
	while($row = $commandeItemResult->fetch_assoc()) {	
		$totalAmount      = $row["prix_achat_total"];  // Taotal avec TVA
              $total +=$totalAmount;

                     
	}
	
  $table .='<td >'.number_format(intval($total),2).'</td>';
  $table .='<td >'.$montantPaye.'</td>';

}
$table .='</table>';
echo $table;

?>