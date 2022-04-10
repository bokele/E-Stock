<?php 
require_once 'core.php';

$productStatus  = $_POST["productStatusClientReport"]; 
$startDate      = $_POST["startDateClientReport"];
$endDate        = $_POST["endDateClientReport"];

// Create new PDF
    $startDate = $_POST['startDateClientReport'];
    $date = DateTime::createFromFormat('m/d/Y',$startDate);
    $start_date = $date->format("Y-m-d");


    $endDate = $_POST['endDateClientReport'];
    $format = DateTime::createFromFormat('m/d/Y',$endDate);
    $end_date = $format->format("Y-m-d");
$query;

      // ----- ------------------ ------------ Savoinor  TVA  ------------------------ --->
    $sql = "SELECT order_id, SUM(grand_total) AS grand_total, nom_client, prenom_client FROM orders 
    INNER JOIN client ON id_client = client_id 

    WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND orders.client_id=$productStatus GROUP BY numeroFacture";
    $queryClient = $connect->query($sql);

    
// ----- ------------------ ------------ Savoinor  TVA  ------------------------ --->
    $sql = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND factureTva=11 AND orders.client_id=$productStatus GROUP BY numeroFacture";
    $query = $connect->query($sql);
    $total ="";
    $totalHTVA =0;
    $totalTVA =0;
    $totalTVAC =0;
    
// ----- ------------------ ------------ Savoinor Sans TVA  ------------------------ --->
     $sql21 = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND factureTva=21 AND orders.client_id=$productStatus";
    $query21 = $connect->query($sql21);
    $totalHTVA21 =0;
    $totalTVA21 =0;
    $totalTVAC21 =0;
// ----- ------------------ ------------ Liquids  TVA  ------------------------ --->
    $sql12 = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND factureTva=12 AND orders.client_id=$productStatus";
    $query12 = $connect->query($sql12);
    $totalHTVA12 =0;
    $totalTVA12 =0;
    $totalTVAC12 =0;
// ----- ------------------ ------------ Liquids Sans TVA  ------------------------ --->
    $sql22 = "SELECT * FROM orders WHERE order_date >= '$start_date' AND order_date <= '$end_date' and order_status = 1 AND factureTva=22 AND orders.client_id=$productStatus";
    $query22 = $connect->query($sql22);
    $totalHTVA22 =0;
    $totalTVA22 =0;
    $totalTVAC22 =0;
?>

 

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
 $resultClient = $queryClient->fetch_assoc();
$table .='<p> <h2 align="center"><u><b>RAPPORT DU CLIENT : '. $resultClient['nom_client'].' '.$resultClient['prenom_client'].'</b></u></h2></p>

<p> <h4 align="center">Chiffre d\'affaire du : Mois '. $date.'</h4></p>';

/*$table .='<table style="" class="border">
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

        $table .='</table>';*/
$table .='<p> <h4 align="center"><u><b>LISTE DES VENTES DU '. $startDate.' AU '.$endDate.'</b></u></h4></p>

<p> <h4 align="center">Liste Des Ventes Savonor Avec TVA</h4></p>';

$table .='<table style="" class="border">
        <tr>
            <th class="5p">Date</th>
            <th class="15p">N°. Facture</th>
             <th class="30p">produit</th>
            <th class="5p">Quantité</th>
            <th class="10p">P.U</th>
            <th class="20p">P.T</th>
        </tr>';

        while ($result = $query->fetch_assoc()) { 
                   $orderId = $result['order_id'];

                    $orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
                    product.product_name FROM order_item
                        INNER JOIN product ON order_item.product_id = product.product_id 
                        WHERE order_item.order_id = $orderId";
                        $orderItemResult = $connect->query($orderItemSql);
                        $lineRow = $orderItemResult->num_rows;
                        $subTotal = $result["sub_total"];
                        $vat = $result["vat"];
                        $totalAmount = $result["total_amount"]; 
                         $order_date = new DateTime($result['order_date']);
                   

$table .=' <tr>
                <td rowspan="'.  $lineRow.'">'. $order_date->format('d/m/Y').'</td>
                <td rowspan="'.  $lineRow.'">'.$result['numeroFacture'].'</td>';


                 while($row = $orderItemResult->fetch_array()) {    

                    $table .='<td >'.$row[4].'</td>
                                <td >'.$row[2].'</td>
                                <td >'.$row[1].' FBI</td>
                                <td >'.$row[3].' FBI</td>
                            </tr>';

                            } //endwhile items


                            $table .=' </tr>';
                            $total +=$totalAmount;
                            $totalTVAC +=$totalAmount; // total 
                            $totalTVA +=$vat; // total de tva
                            $totalHTVA +=$subTotal; // total hors tva
                        }

                    $table .='</table>';


                    $table .='<p> <h4 align="center">Liste Des Ventes Savonor Sans TVA</h4></p>';

$table .='<table style="" class="border">
        <tr>
            <th class="5p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
             <th class="30p">produit</th>
            <th class="5p">Quantité</th>
            <th class="10p">P.U</th>
            <th class="20p">P.T</th>
        </tr>';
while ($result21 = $query21->fetch_assoc()) { 
            $orderId21 = $result21['order_id'];

                    $orderItemSql21 = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
                    product.product_name FROM order_item
                        INNER JOIN product ON order_item.product_id = product.product_id 
                        WHERE order_item.order_id = $orderId21";
                        $orderItemResult21  = $connect->query($orderItemSql21);
                        $lineRow            = $orderItemResult21->num_rows;// nombre de ligne
                        $subTotal21         = $result21["sub_total"]; // total general
                        $vat21              = $result21["vat"]; // total TVA
                        $totalAmount21      = $result21["total_amount"];  // Taotal avec TVA
           $order_date = new DateTime($result['order_date']);
                   

$table .=' <tr>
                <td rowspan="'. $lineRow.'">'.$order_date->format('d/m/Y').'</td>
                <td rowspan="'. $lineRow.'">'.$result21['numeroFacture'].'</td>';


                 while($row = $orderItemResult21->fetch_array()) {    
                   
                    $table .=' 
                                <td>'.$row[4].'</td>
                                <td >'.$row[2].'</td>
                                <td >'.$row[1].' </td>
                                <td >'.$row[3].' 
                                </td>
                            </tr>';

                            } //endwhile items

                            $table .=' </tr>';
                            $totalTVAC21 +=$totalAmount21; // total 
                            $totalTVA21 +=$vat21; // total de tva
                            $totalHTVA21 +=$subTotal21; // total hors tva
                        }


                    $table .='</table><br>';

 $table .='<p> <h4 align="center">Liste Des Ventes Liquids Avec TVA</h4></p>';

$table .='<table style="" class="border">
        <tr>
            <th class="5p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
             <th class="30p">produit</th>
            <th class="5p">Quantité</th>
            <th class="10p">P.U</th>
            <th class="20p">P.T</th>
        </tr>';
while ($result12 = $query12->fetch_assoc()) { 
            $orderId12 = $result12['order_id'];

                    $orderItemSql12= "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
                    product.product_name FROM order_item
                        INNER JOIN product ON order_item.product_id = product.product_id 
                        WHERE order_item.order_id = $orderId12";
                        $orderItemResult12  = $connect->query($orderItemSql12);
                        $lineRow            = $orderItemResult12->num_rows;// nombre de ligne
                        $subTotal21         = $result12["sub_total"]; // total general
                        $vat21              = $result12["vat"]; // total TVA
                        $totalAmount21      = $result12["total_amount"];  // Taotal avec TVA
                         $order_date = new DateTime($row["order_date"]);
$table .=' <tr>
                <td rowspan="'.  $lineRow.'">'. $order_date->format('d/m/Y').'</td>
                <td rowspan="'.  $lineRow.'">'.$result12['numeroFacture'].'</td>';


                 while($row = $orderItemResult12->fetch_array()) {    

                   
                    $table .=' 
                                <td>'.$row[4].'</td>
                                <td >'.$row[2].'</td>
                                <td >'.$row[1].' FBI</td>
                                <td >'.$row[3].' FBI</td>
                            </tr>';

                            } //endwhile items


                            
                            $totalTVAC12 +=$totalAmount21; // total 
                            $totalTVA12 +=$vat21; // total de tva
                            $totalHTVA12 +=$subTotal21; // total hors tva

                        }
                        
$table .=' </tr>';
                    $table .='</table><br>';

                    ############################################ liquids Avec TVA #################################################################################
                    $table .='<p> <h4 align="center">Liste Des Ventes Liquids Avec TVA</h4></p>';

$table .='<table style="" class="border">
        <tr>
            <th class="5p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
            <th class="30p">Produit</th>
            <th class="5p">Quantité</th>
            <th class="10p">P.U</th>
            <th class="20p">P.T</th>
        </tr>';
while ($result22 = $query22->fetch_assoc()) { 
            $orderId22 = $result22['order_id'];

                    $orderItemSql22 = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
                    product.product_name FROM order_item
                        INNER JOIN product ON order_item.product_id = product.product_id 
                        WHERE order_item.order_id = $orderId22";
                        $orderItemResult22  = $connect->query($orderItemSql22);
                        $lineRow            = $orderItemResult22->num_rows;// nombre de ligne
                        $subTotal22         = $result22["sub_total"]; // total general
                        $vat22              = $result22["vat"]; // total TVA
                        $totalAmount22      = $result22["total_amount"];  // Taotal avec TVA
           $order_date = new DateTime($result['order_date']);
                   

$table .=' <tr>
                <td rowspan="'.  $lineRow.'">'. $order_date->format('d/m/Y').'</td>
                <td rowspan="'.  $lineRow.'">'.$result22['numeroFacture'].'</td>';


                 while($row = $orderItemResult22->fetch_array()) {    

                    $table .=' 
                                <td>'.$row[4].'</td>
                                <td >'.$row[2].'</td>
                                <td >'.$row[1].' FBI</td>
                                <td >'.$row[3].' FBI</td>
                            </tr>';

                            } //endwhile items


                            $table .=' </tr>';
                            $totalTVAC22 +=$totalAmount22; // total 
                            $totalTVA22 +=$vat22; // total de tva
                            $totalHTVA22 +=$subTotal22; // total hors tva

                        }
                        

                    $table .='</table><br>';

############################################   SAVONOR AVEC TVA #################################################################################
$table .='<table style="" class="border">
        <tr>
            <th colspan="2">TOTAL GENERAL DES PRODUITS SAVONOR AVEC TVA DE 18%</th>
        </tr>
        <tr>
            <td class="50p">PV-THTVA</td>
            <td class="50p">'.$totalHTVA.'</td>
        </tr>
        <tr>
            <td class="50p">TVA</td>
            <td class="50p">'.$totalTVA.'</td>
        </tr>
        <tr>
            <td class="50p">PV-TTVAC</td>
            <td class="50p">'.$totalTVAC.'</td>
        </tr>
        </table><br>';
############################################   SAVONOR SANS TVA #################################################################################
    $table .='<table style="" class="border">
        <tr>
            <th colspan="2">TOTAL GENERAL DES PRODUITS SAVONOR SANS TVA DE 18%</th>
        </tr>
        <tr>
            <td class="50p">PV-THTVA</td>
            <td class="50p">'. $totalHTVA21.'</td>
        </tr>
        <tr>
            <td class="50p">TVA</td>
            <td class="50p">'.$totalTVA21.'</td>
        </tr>
        <tr>
            <td class="50p">PV-TTVAC</td>
            <td class="50p">'.$totalTVAC21.'</td>
        </tr>
        </table><br>';

        ############################################ liquids   AVEC TVA #################################################################################
    $table .='<table style="" class="border">
        <tr>
            <th colspan="2">TOTAL GENERAL DES PRODUITS LIQUIDS AVEC TVA DE 18%</th>
        </tr>
        <tr>
            <td class="50p">PV-THTVA</td>
            <td class="50p">'. $totalHTVA12.'</td>
        </tr>
        <tr>
            <td class="50p">TVA</td>
            <td class="50p">'.$totalTVA12.'</td>
        </tr>
        <tr>
            <td class="50p">PV-TTVAC</td>
            <td class="50p">'.$totalTVAC12.'</td>
        </tr>
        </table><br>';

            ############################################ liquids   SANS TVA #################################################################################
    $table .='<table style="" class="border">
        <tr>
            <th colspan="2">TOTAL GENERAL DES PRODUITS LIQUIDS SANS TVA DE 18%</th>
        </tr>
        <tr>
            <td class="50p">PV-THTVA</td>
            <td class="50p">'. $totalHTVA22.'</td>
        </tr>
        <tr>
            <td class="50p">TVA</td>
            <td class="50p">'.$totalTVA22.'</td>
        </tr>
        <tr>
            <td class="50p">PV-TTVAC</td>
            <td class="50p">'.$totalTVAC22.'</td>
        </tr>
        </table><br>';


         $table .='<table style="" class="border">
        <tr>
            <th colspan="2">TOTAL GENERAL DES VENTES</th>
        </tr>
        <tr>
            <td class="50p">SAVONOR</td>
            <td class="50p">'.($totalTVAC21 + $totalTVAC12).'</td>
        </tr>
        
        <tr>
            <td class="50p">LIQUIDS</td>
            <td class="50p">'.($totalTVAC12 + $totalTVAC22).'</td>
        </tr>
        </table><br>';

echo $table;

?>