<?php 
require_once 'core.php';
$caisseId = $_GET['caisseId'];

?>
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
    .border td { 
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
<?php $table ="";

$sql = "SELECT id_caisse,date_caisse, montant_caisse FROM caisse   WHERE id_caisse = {$caisseId} ";
$caisseResult = $connect->query($sql);
$caisseData = $caisseResult->fetch_array();

$id_caisse              = $caisseData[0];
$date_caisse_verifier   = $caisseData[1];
$montant_caisse         = $caisseData[2];



$date_caisse        = new DateTime( $caisseData[1]);



$table .= '
<p> <h2 align="center"><u><b>LIVRE DE CAISSE DU '. $date_caisse->format('d/m/Y').'</b></u></h2></p>
<table style="margin-top: 30px;" class="border" border="1">
        <tr>
             <th class="45p" colspan="2">Ventes du jour</th>
            <th class="10p" colspan="2">Ventes à Crédit</th>
            <th class="6p" colspan="2">Dépenses</th>
             <th class="6p" colspan="2">Sorties</th>
            <th class="10p" colspan="2">Reboursements</th>
            <th class="10p" colspan="2">Versements</th>
        </tr>';

///// total de vente a une date x CAST(PROD_CODE) AS INT

$sql = "SELECT SUM(grand_total) AS total FROM orders WHERE order_status = 1 AND order_date = '$date_caisse_verifier'";
$ligne = $connect->query($sql);
$ligneback = $ligne->num_rows;
$order_total;
if ($ligneback == 0) {
# code...
    $order_total=0;
}else{
    $result = $ligne->fetch_assoc();
    $order_total = $result["total"];
}

$sql = "SELECT SUM(grand_total) AS total_client, nom_client, prenom_client  FROM orders INNER JOIN client ON id_client = client_id  WHERE order_status = 1 AND order_date = '$date_caisse_verifier' GROUP BY client_id";
$connect->query($sql);
$ligne = $connect->query($sql);
$resultClient = "";
$ligneback = $ligne->num_rows;
if ($ligneback == 0) {
    $resultClient = "";
  
}else{
    $resultClient .= "<table><tr><td>Nom client</td><td>Montant</td></tr>";
   while ( $result = $ligne->fetch_assoc()) {
        $resultClient .= "<tr><td>".$result["nom_client"]." ".$result["prenom_client"]." </td><td> ".$result["total_client"]."</td></tr>";
    } 
    $resultClient .='</table>';
    
}

$table .= ' 
    <tr>
        <td colspan="2">'.$resultClient.'</td>';



////////////// vente a credit pour une date x

$sql = "SELECT SUM(grand_total) AS total_credit FROM orders WHERE order_status = 1 AND payment_status = 3 AND order_date = '$date_caisse_verifier'";
$ligne = $connect->query($sql);
$ligneback = $ligne->num_rows;
$total_credit;
if ($ligneback == 0) {
# code...
    $total_credit=0;
}else{
    $result = $ligne->fetch_assoc();
    $total_credit = floatval($result["total_credit"]);
}

$sql = "SELECT SUM(grand_total) AS total_client, nom_client, prenom_client  FROM orders INNER JOIN client ON id_client = client_id  WHERE order_status = 1 AND payment_status = 3 AND order_date = '$date_caisse_verifier' GROUP BY client_id";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
$resultCredit="";
if ($ligneback == 0) {
    $resultCredit="";
}else{
        $resultCredit .= "<table><tr><td>Nom client</td><td>Montant</td></tr>";
   while ( $result = $ligne->fetch_assoc()) {
      $resultCredit .="<tr><td>".$result["nom_client"]." ".$result["prenom_client"]."</td><td>".$result["total_client"]."</td></tr>";
    } 
    $resultCredit .='</table>';

    
}

$table .= ' 
        <td colspan="2">'.$resultCredit.'</td>';


/////////// depense a une date x 
$sql = "SELECT SUM(prix_total_depense) AS prix_total_depense, id_depense FROM depenses WHERE  date_depense = '$date_caisse_verifier'";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
$total_depense;
if ($ligneback == 0) {
  # code...
  $total_depense=0;
}else{
  $result = $ligne->fetch_assoc();
  $total_depense = floatval($result["prix_total_depense"]);
}

$sql = "SELECT SUM(prix_total_depense) AS prix_total_depense, id_depense  FROM depenses   WHERE  date_depense = '$date_caisse_verifier'";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
$depense ="";
if ($ligneback == 0) {
    $depense ="";
}else{


   while ( $result = $ligne->fetch_assoc()) {
        $id_depense = $result["id_depense"];
            $depenseItemSql = "SELECT depense_item.id_depense, depense_item.quantite_depense, depense_item.prix_achat_depense, depense_item.prix_achat_total_depense, depense_item.libelle_depense FROM depense_item
        INNER JOIN depenses ON depense_item.id_depense = depenses.id_depense 
        WHERE date_depense = '$date_caisse_verifier'";
        $depenseItemResult = $connect->query($depenseItemSql);
         $depense .= "<table><tr><td>Désignation</td><td>Montant</td></tr>";
        while($row = $depenseItemResult->fetch_assoc()) {

            $depense .= "<tr><td>".$row["libelle_depense"]." </td><td> ".$row["prix_achat_total_depense"]."</td></tr>";
        }
        $depense .='</table>';
    } 

    
}



$table .= ' 
        <td colspan="2">'.$depense.'</td>';


/////////// Sortie a une date x 
$sql = "SELECT SUM(montant) AS prix_total_sortie, id_bonSortie FROM bon_sortie WHERE  date_sortie = '$date_caisse_verifier'";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
$total_sortie;
if ($ligneback == 0) {
  # code...
  $total_sortie=0;
}else{
  $result = $ligne->fetch_assoc();
  $total_sortie = floatval($result["prix_total_sortie"]);
}

$sql = "SELECT SUM(montant) AS prix_total_sortie, id_bonSortie  FROM bon_sortie   WHERE  date_sortie = '$date_caisse_verifier'";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
$sortie ="";
if ($ligneback == 0) {
    $sortie ="";
}else{

 $sortie .= "<table><tr><td>Désignation</td><td>Montant</td></tr>";
   while ( $result = $ligne->fetch_assoc()) {
        $id_bonSortie = $result["id_bonSortie"];
            $depenseItemSql = "SELECT bon_sortie_item.id_bonSortie, bon_sortie_item.quantite_sortie, bon_sortie_item.prix_achat_sortie, bon_sortie_item.prix_achat_total_sortie, bon_sortie_item.libelle_sortie FROM bon_sortie_item
             INNER JOIN bon_sortie ON bon_sortie_item.id_bonSortie = bon_sortie.id_bonSortie 
            WHERE   date_sortie = '$date_caisse_verifier'";
         $depenseItemResult = $connect->query($depenseItemSql);
        
        while($row = $depenseItemResult->fetch_assoc()) {

            $sortie .= "<tr><td>".$row["libelle_sortie"]." </td><td>".$row["prix_achat_total_sortie"]."</td></tr>";
        }

       
    } 

     $sortie .='</table>';
}



$table .= ' 
        <td colspan="2">'.$sortie.'</td>';

        /////////// reboursement a une date x 
$sql = "SELECT SUM(montant) AS total_remboursement FROM remborsement WHERE  date_remb = '$date_caisse_verifier'";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
$total_rembourse;
if ($ligneback == 0) {
  # code...
  $total_rembourse=0;
}else{
  $result = $ligne->fetch_assoc();
  $total_rembourse = floatval($result["total_remboursement"]);
}

$sql = "SELECT SUM(montant) AS total_rembourse, nom_client, prenom_client  FROM remborsement INNER JOIN client ON id_client = id_client_remb  WHERE  date_remb = '$date_caisse_verifier' GROUP BY id_client_remb";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
$resultResoursement="";
if ($ligneback == 0) {
    $resultResoursement="";
}else{

     $resultResoursement .= "<table><tr><td>Nom client</td><td>Montant</td></tr>";
   while ( $result = $ligne->fetch_assoc()) {
        $resultResoursement.="<tr><td>".$result["nom_client"]." ".$result["prenom_client"]." </td><td> ".$result["total_rembourse"]."</td></tr>";
    } 

     $resultResoursement .='</table>';
}


$table .= ' 
        <td colspan="2">'.$resultResoursement.'</td>';


///// versement a une date x CAST(PROD_CODE) AS INT

$sql = "SELECT SUM(montant_verse) AS total FROM versement WHERE  date_bordereau = '$date_caisse_verifier'";
$ligne = $connect->query($sql);
$ligneback = $ligne->num_rows;
$montant_verse;
if ($ligneback == 0) {
# code...
    $montant_verse=0;
}else{
    $result = $ligne->fetch_assoc();
    $montant_verse = $result["total"];
}

$sql = "SELECT montant_verse, numero_compte_banque, nom_banque  FROM versement INNER JOIN banque ON versement.id_banque = banque.id_banque  WHERE date_bordereau = '$date_caisse_verifier' GROUP BY numero_compte_banque";
$ligne = $connect->query($sql);
$resultVersement = "";
$ligneback = $ligne->num_rows;
if ($ligneback == 0) {
    $resultVersement = "";
  
}else{
   $resultVersement .= "<table><tr><td>Banque</td><td>Compte</td><td>Montant</td></tr>";
   while ( $result = $ligne->fetch_assoc()) {
    

        $resultVersement .= "<tr><td>".$result["nom_banque"]." </td><td>".$result["numero_compte_banque"]."</td><td>".$result["montant_verse"]."</td></tr>";
    } 

    $resultVersement .='</table>';
}

$table .= ' 

        <td colspan="2"> '.$resultVersement.'</td>';

$table .='</tr>'; 

 $table .='<tr> <th>Total</th> 
            <td>'.$order_total.'</td>
            <th></th> 
            <td>'.$total_credit.'</td>
            <th></th> 
            <td>'.$total_depense.'</td>
            <th></th> 
            <td>'.$total_sortie.'</td>
            <th></th> 
            <td>'.$total_rembourse.'</td>
            <th></th> 
            <td>'.$montant_verse.'</td>';

 $table .='</tr>'; 
$table .='</table>';

/*$table .= '<br>
<p> <h2 align="center"><u><b>TOTAL DU JOUR</b></u></h2></p>
<table style="margin-top: 30px;" class="border" border="1">
        <tr>
             <th class="20p">Vente du jour</th>
            <th class="10p">Vente à Crédit</th>
            <th class="10p">Dépense</th>
             <th class="10p">Sortie</th>
            <th class="10p">Reboursement</th>
            <th class="10p">Versement</th>
        </tr>';

$table .= '
        <tr>
            <td>'.$order_total.'</td>
            <td>'.$total_credit.'</td>
            <td>'.$total_depense.'</td>
            <td>'.$total_sortie.'</td>
            <td>'.$total_rembourse.'</td>
            <td>'.$montant_verse.'</td>
        </tr>';
$table .='</table>';*/

///////// montant caisse du jour demande

$sql = "SELECT SUM(montant_caisse) AS montant_caisse FROM caisse WHERE  date_caisse = '$date_caisse_verifier'";
$ligne = $connect->query($sql);
$ligneback = $ligne->num_rows;
$total_caisseJour;
if ($ligneback == 0) {
  # code...
  $total_caisseJour=0;
}else{
  $result = $ligne->fetch_assoc();
  $total_caisseJour= floatval($result["montant_caisse"]);
}

////////////// montant caisse du veille
$dayJuour = new DateTime($date_caisse_verifier);
$day = $dayJuour->format("d");
$mois = $dayJuour->format("m");
$anne = $dayJuour->format("Y");
$dayHier = $day - 1;
$dateComplete = "".$dayHier."-".$mois."-".$anne."";
$dateCompleHier = new DateTime("$dateComplete");
$dateCompleCherche = $dateCompleHier->format("Y-m-d");
$sql = "SELECT SUM(montant_caisse) AS montant_caisse FROM caisse WHERE  date_caisse = '$date_caisse_verifier'";
$ligne = $connect->query($sql);
$ligneback = $ligne->num_rows;
$total_caisseJour;
if ($ligneback == 0) {
  # code...
  $total_caisseJour=0;
}else{
  $result = $ligne->fetch_assoc();
  $total_caisseJour= floatval($result["montant_caisse"]);
}

$sql = "SELECT SUM(montant_caisse) AS montant_caisse FROM caisse WHERE  date_caisse = '$dateCompleCherche'";
$ligneHier = $connect->query($sql);
$ligneback = $ligneHier->num_rows;
$total_caisseHier;
if ($ligneback == 0) {
  # code...
  $total_caisseHier=0;
}else{
  $resultHier = $ligneHier->fetch_assoc();
  $total_caisseHier= floatval($resultHier["montant_caisse"]);
}

$table .= '<br>
<p> <h4 align="center"><u><b>MONTANT CAISSE</b></u></h4></p>
<table style="margin-top: 30px;" class="border" border="1">
        <tr>
             <th class="50p">Caisse matin du '.$dateCompleHier->format("d/m/Y").'</th>
              <th class="50p">Caisse du Jour</th>
            <th class="50p">Caisse soir </th>
        </tr>';
$caisseDuJour = floatval($order_total) - floatval($total_credit) - floatval($total_depense) - floatval($total_sortie) + floatval($total_rembourse) - floatval($montant_verse);
$table .= '
        <tr>
            <td>'.$total_caisseHier .'</td>
            <td>'.$caisseDuJour.'</td>
            <td>'.($total_caisseJour).'</td>
        </tr>';
$table .='</table>';
echo $table;