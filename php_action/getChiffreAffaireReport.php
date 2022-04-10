<?php 
require_once 'core.php';
require_once ("../lib/html2pdf/src/Html2Pdf.php");
require_once '../lib/html2pdf/vendor/autoload.php';

ob_start(); 
use Spipu\Html2Pdf\Html2Pdf;
$productStatusChiffre  = $_POST["productStatusChiffre"];
$startDateChiffre      = $_POST["startDateChiffre"];
$endDateChiffre        = $_POST["endDateChiffre"];




// Create new PDF
    $startDateChiffre = $_POST['startDateChiffre'];
    $date = DateTime::createFromFormat('m/d/Y',$startDateChiffre);
    $start_date = $date->format("Y-m-d");


    $endDateChiffre = $_POST['endDateChiffre'];
    $format = DateTime::createFromFormat('m/d/Y',$endDateChiffre);
    $end_date = $format->format("Y-m-d");

$sql = "SELECT id_commande, ref_commande, date_commande, brand_name,  prix_total_achat, status,  user_add, date_add FROM boncommande INNER JOIN brands ON brand_id = id_marque  WHERE date(boncommande.date_commande) >= date('$start_date') AND date(boncommande.date_commande) <= date('$end_date') AND status != 4 AND id_marque = $productStatusChiffre";


$commnadeResult = $connect->query($sql);





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
<?php $table = "";
$sqlSociete = "SELECT logoSociete FROM societe";
$societeResult = $connect->query($sqlSociete);
$societeData = $societeResult->fetch_array();
$logoSociete 		= $societeData[0];
include("../includes/headerSociete.php");




#################################################################################
$table .='

<p> <h2 align="center"><u><b>RAPPORT DU CHIFFRE d\'AFFAIRE DU '. $date->format("d/m/Y").' AU '.$format->format("d/m/Y").'</b></u></h2></p>


';



if($commnadeResult->num_rows > 0){
	$CommnadeData = $commnadeResult->fetch_array();
$id_commande 		= $CommnadeData[0];
$date_commande 		= new DateTime( $CommnadeData[2]);
$ref_commande 		= $CommnadeData[1];
$brand_name 		= $CommnadeData[3];
$quantite_total		= $CommnadeData[4];
$prix_total_achat	= $CommnadeData[5]; 
##<!-- ------------------------- Savoinor  TVA  ------------------------ --->
$table .='
<p> <h3 align="center"><u><b>Fournisseur :  '.$brand_name .'</b></u></h3></p> 
<table style="margin-top: 30px;" class="border">
        <tr>
            <th class="10p">Produits</th>
            <th class="15p">Quantités</th>
            <th class="15p">Montant (Bif)</th>
        </tr>';
$commandeItemSql = "SELECT boncommande_item.id_commande, SUM(boncommande_item.quantite) AS quantite, boncommande_item.prix_achat, SUM(boncommande_item.prix_achat_total) AS prixTotal,
product.product_name FROM boncommande_item
	INNER JOIN product ON boncommande_item.id_produit = product.product_id 
 WHERE boncommande_item.id_commande = $id_commande GROUP BY boncommande_item.id_produit";
$commandeItemResult = $connect->query($commandeItemSql);


if ($commandeItemResult->num_rows > 0) {
	$x = 1;
$totalAmount=0;
while($result = $commandeItemResult->fetch_array()) {	 
         $table .=' <tr>
                <td>' .$result['product_name'].'</td>
                <td>' .$result['quantite'].'</td>
                <td>' . number_format($result['prixTotal'],2).'</td>
            </tr> '; 
       
           $totalAmount += $result['prixTotal']; 
            }//endwhile
       
      $table .=' <tr>
            <td colspan="2">Total Général</td>
           <td>'. number_format($totalAmount,2).'</td>
       </tr>
      
</table>';
##<!-- ------------------------- Savoinor Sans TVA  ------------------------ --->
$fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);
 $table .='<br><br><p><i>Nous disons <b>'.$fmt->format($totalAmount).'</b> francs burundais</i>.</p>';
}
 echo $table;
} // fin if





?>