<?php 
require_once 'core.php';

$productStatus  = $_POST["productStatusClient"];
$startDate      = $_POST["startDateClient"];
$endDate        = $_POST["endDateClient"];

// Create new PDF
    $startDate = $_POST['startDateClient'];
    $date = DateTime::createFromFormat('m/d/Y',$startDate);
    $start_date = $date->format("Y-m-d");


    $endDate = $_POST['endDateClient'];
    $format = DateTime::createFromFormat('m/d/Y',$endDate);
    $end_date = $format->format("Y-m-d");
$query;

$sql = "SELECT brand_id, brand_name, brand_active, brand_status FROM brands WHERE brand_status = 1 AND brand_active = 1 AND brand_id=$productStatus";
    $result = $connect->query($sql);
    $row = $result->fetch_array();
    $brand_id = $row[0];


      // ----- ------------------ ------------ Savoinor  TVA  ------------------------ --->
    $sql = "SELECT SUM(grand_total) AS grand_total, nom_client, prenom_client FROM orders INNER JOIN client ON id_client = client_id WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND id_marque = $brand_id  GROUP BY client_id";
    $query = $connect->query($sql);
    $total ="";
    $totalHTVA =0;
    $totalTVA =0;
    $totalTVAC =0;

 /*$sqlDonavine = "SELECT SUM(prix_total_achat) AS grand_total FROM boncommande WHERE date_commande >= '$start_date' AND date_commande <= '$end_date' and status = 1 AND id_marque = $brand_id";
  $queryDonavine = $connect->query($sqlDonavine);
 $row = $queryDonavine->fetch_array();
 $montantTotalDonavine = $row["grand_total"];*/

    


 

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
$table = "";


 include("../includes/headerSociete.php");

 $date = $format->format("m-Y");
################################################################################
$table .='<p> <h2 align="center"><u><b>RAPPORT DU CHIFFRE D\'AFFAIRE DES SEMI-DISTRIBUTEURS</b></u></h2></p>

<p> <h4 align="center">Chiffre d\'affaire du : Mois '. $date.'</h4></p>';

$table .='<table style="" class="border">
        <tr>
            <th class="5p">Non du client</th>
            <th class="20p">Montant Total</th>
        </tr>';

        while ($result = $query->fetch_assoc()) { 
            $table .=' <tr>
                <td >'. $result['nom_client'].' '.$result['prenom_client'].'</td>
              
                <td >'.$result['grand_total'].'</td>';

                 $table .='</tr>';
        }

        $table .='</table>';

//$table .='<p> <h5>Mon chiffre d\' affaire est de  <b>'.$montantTotalDonavine.'</b></h2></p>';



echo $table;

?>