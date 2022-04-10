<?php 
require_once 'core.php';
require_once ("../lib/html2pdf/src/Html2Pdf.php");
require_once '../lib/html2pdf/vendor/autoload.php';

//ob_start(); 
use Spipu\Html2Pdf\Html2Pdf;
$productStatus  = $_POST["productStatus"];
$startDate      = $_POST["startDate"];
$endDate        = $_POST["endDate"];




// Create new PDF
    $startDate = $_POST['startDate'];
    $date = DateTime::createFromFormat('m/d/Y',$startDate);
    $start_date = $date->format("Y-m-d");


    $endDate = $_POST['endDate'];
    $format = DateTime::createFromFormat('m/d/Y',$endDate);
    $end_date = $format->format("Y-m-d");

// ----- ------------------ ------------ Liquids  TVA  ------------------------ --->
    $sql12 = "SELECT * FROM produit_history INNER JOIN product ON produit_history.product_id = product.product_id  WHERE date(produit_history.date_add) >= date('$start_date') AND date(produit_history.date_add) <= date('$end_date') AND product.brand_id = 2 GROUP BY produit_history.product_id";
    $query12 = $connect->query($sql12);
    $totalAmount12 ="";

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
<?php

$table ="";
 include("../includes/headerSociete.php");

$table .='
<p> <h2 align="center"><u><b>Produits Liquids du '. $startDate.' au '. $endDate.'</b></u></h2></p>
<table style="margin-top: 30px;" class="border">
        <tr>
             <th class="45p">Produit</th>
            <th class="10p">Date</th>
            <th class="6p">Enc.Qte</th>
             <th class="6p">Nou.Qte</th>
            <th class="10p">P.A</th>
            <th class="10p">P.V</th>
            <th class="10p">Enc.Montant</th>
            <th class="10p">Nou.Montant</th>
            <th class="10p">Beneficie</th>
        </tr>';
        while ($result = $query12->fetch_assoc()) { 
         	$productId = $result['product_id'];
         	$sql122 = "SELECT * FROM produit_history  WHERE date(produit_history.date_add) >= date('$start_date') AND date(produit_history.date_add) <= date('$end_date') AND product_id = $productId";
             $query222 = $connect->query($sql122);
    		// while ($result12 = $query->fetch_assoc()) { 
	         	   $line = $query222->num_rows; // nombre de ligne retourn pour un produit selectionne
            $table .= ' 
         

         	   <tr>
                    <td rowspan="'. $line.'">'.$result['product_name'].'</td>

                    ';
                
                 while($result = $query222->fetch_array()) { 

                        $prixEnc    = $result['pass_quantite'] * $result['prix_vente']; // prix total des produit avant mise a jour 
                        
                        $prixEx     = $result['new_quantite'] * $result['prix_vente']; // prix total des produits dans le stock
                        $benefice    =  $prixEnc  - $prixEx ; // pris total des nouveau produit
                    $table .='
                      
             	 	    <td >'. $result['date_add'].'</td>
                            <td >'.$result['pass_quantite'].'</td>
                            <td >'.$result['new_quantite'].'</td>
                            <td >'. $result['prix_achat'].'</td>
                            <td >'.$result['prix_vente'].'</td>
                            <td >'.$prixEnc.'</td>
                            <td >'. $prixEx.'</td>
                            <td >'. $benefice.'</td>
                  ';   
                  $table .='</tr>';    
           } 
       $table .='</tr>';
   
        } // end while produit
  
 $table .='</table>';
echo $table;

    ?>