<?php 
require_once 'core.php';
require_once ("../lib/html2pdf/src/Html2Pdf.php");
require_once '../lib/html2pdf/vendor/autoload.php';

ob_start(); 
use Spipu\Html2Pdf\Html2Pdf;
$productStatus              = $_POST["productStatusClientAgence"];
$startDate                  = $_POST["startDateClientAgence"];
$endDate                    = $_POST["endDateClientAgence"];
$productStatusClient        = $_POST["productStatusAgence"];



// Create new PDF
    $startDate = $_POST['startDateClientAgence'];
    $date = DateTime::createFromFormat('m/d/Y',$startDate);
    $start_date = $date->format("Y-m-d");


    $endDate = $_POST['endDateClientAgence'];
    $format = DateTime::createFromFormat('m/d/Y',$endDate);
    $end_date = $format->format("Y-m-d");

// ----- ------------------ ------------ Savoinor  TVA  ------------------------ --->
    $sql = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND factureTva=11 AND  agenceId = $productStatusClient";
    $query = $connect->query($sql);
    $totalAmount ="";
// ----- ------------------ ------------ Savoinor Sans TVA  ------------------------ --->
     $sql21 = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND factureTva=21 AND  agenceId = $productStatusClient";
    $query21 = $connect->query($sql21);
    $totalAmount21 ="";
// ----- ------------------ ------------ Liquids  TVA  ------------------------ --->
    $sql12 = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND factureTva=12 AND  agenceId = $productStatusClient";
    $query12 = $connect->query($sql12);
    $totalAmount12 ="";
// ----- ------------------ ------------ Liquids Sans TVA  ------------------------ --->
    $sql22 = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND factureTva=22 AND  agenceId = $productStatusClient";
    $query22 = $connect->query($sql22);
    $totalAmount22 ="";
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

$table = "";
 include("../includes/headerSociete.php");
$table .='<p> <h2 align="center"><u><b>LISTE DES VENTES DU '. $startDate.' AU '.$endDate.'</b></u></h2></p>';


##<!-- ------------------------- Savoinor  TVA  ------------------------ --->
$table .='<p> <h4 align="center">Liste Des Ventes Savonor Avec TVA</h4></p>
<table style="margin-top: 30px;" class="border">
        <tr>
            <th class="10p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
            <th class="50p">Client</th>
             <th class="10p">Téléphone</th>
            <th class="15p">Montant</th>
        </tr>';

 while ($result = $query->fetch_assoc()) { 
    $order_date = new DateTime($result["order_date"]);
        $table .=' <tr>
                <td>'.$order_date->format('d/m/Y').'</td>
                <td>'.$result['numeroFacture'].'</td>
                <td>'.$result['client_name'].'</td>
                <td>'. $result['client_contact'].'</td>
                <td>'.$result['grand_total'].'</td>
            </tr> ';  
           $totalAmount += $result['grand_total']; 
            }//endwhile
  
        $table .='<tr>
            <td colspan="4">Total Général</td>
            <td>'.$totalAmount.'</td>
        </tr>
      
</table>';
###!-- ------------------------- Savoinor Sans TVA  ------------------------ --->
 $table .='<p> <h4 align="center"><u>Liste Des Ventes Savonor Sans TVA</u></h4></p>
<table style="margin-top: 30px;" class="border">
        <tr>
            <th class="10p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
            <th class="50p">Client</th>
             <th class="10p">Téléphone</th>
            <th class="15p">Montant</th>
        </tr>';

     while ($result = $query21->fetch_assoc()) { 
          $order_date = new DateTime($result["order_date"]);
        $table .=' <tr>
                <td>'.$order_date->format('d/m/Y').'</td>
                <td>'. $result['numeroFacture'].'</td>
                <td>'.$result['client_name'].'</td>
                <td>'.$result['client_contact'].'</td>
                <td>'.$result['grand_total'].'</td>
            </tr> ';
         
           $totalAmount21 += $result['grand_total']; 
            }//endwhile
        
       $table .=' <tr>
            <td colspan="4">Total Général</td>
            <td>'.$totalAmount21.'</td>
        </tr>
      
</table>';
##<!-- ------------------------- Liquids  TVA  ------------------------ --->
        $table .='
<p><h4 align="center"><u>Liste Des Ventes Liquides Avec TVA</u></h4></p>
<table style="margin-top: 30px;" class="border">
        <tr>
            <th class="10p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
            <th class="50p">Client</th>
             <th class="10p">Téléphone</th>
            <th class="15p">Montant</th>
        </tr>';

       while ($result = $query12->fetch_assoc()) {
        $order_date = new DateTime($result["order_date"]);
        $table .=' <tr>
                <td>'.$order_date->format('d/m/Y').'</td>
                <td>'. $result['numeroFacture'].'</td>
                <td>'.$result['client_name'].'</td>
                <td>'.$result['client_contact'].'</td>
                <td>'.$result['grand_total'].'</td>
            </tr> ';
           
           $totalAmount12 += $result['grand_total']; 
            }//endwhile
        
        $table .='<tr>
            <td colspan="4">Total Général</td>
            <td>'.$totalAmount12.'</td>
        </tr>
      
</table>';
##<!-- ------------------------- Liquids sans TVA  ------------------------ --->
$table .='<p><h4 align="center"><u>Liste Des Ventes Liquides Sans TVA</u></h4></p>
<table style="margin-top: 30px;" class="border">
        <tr>
            <th class="10p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
            <th class="50p">Client</th>
             <th class="10p">Téléphone</th>
            <th class="15p">Montant</th>
        </tr>';

       while ($result = $query22->fetch_assoc()) { 
         $order_date = new DateTime($result["order_date"]);
        $table .=' <tr>
                <td>'.$order_date->format('d/m/Y').'</td>
                <td>'. $result['numeroFacture'].'</td>
                <td>'. $result['client_name'].'</td>
                <td>'.$result['client_contact'].'</td>
                <td>'.$result['grand_total'].'</td>
            </tr> ';
          
           $totalAmount22 += $result['grand_total']; 
            }//endwhile
        
        $table .='<tr>
            <td colspan="4">Total Général</td>
            <td>'.$totalAmount22.'</td>
        </tr>
      
</table>';

echo $table;

?>