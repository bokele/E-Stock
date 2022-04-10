#
############################################ Savonor  Sans TVA #################################################################################
$table .='<p> <h4 align="center">Liste Des Commandes Savonor Sans TVA</h4></p>';

$table .='<table style="" class="border">
        <tr>
            <th class="5p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
            <th class="30p">Client</th>
             <th class="30p">produit</th>
            <th class="5p">Quantité</th>
            <th class="10p">P.U</th>
            <th class="20p">P.T</th>
        </tr>';
while ($result21 = $query->fetch_assoc()) { 
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
$table .=' <tr>
                <td rowspan="'.  $lineRow.'">'. $result21['order_date'].'</td>
                <td rowspan="'.  $lineRow.'">'.$result21['numeroFacture'].'</td>
                <td rowspan="'. $lineRow.'">'.$result21['client_name'].' - '.$result21['client_contact'].'</td>';


                 while($row = $orderItemResult21->fetch_array()) {    

                    $table .='  <td >'.$row[4].'</td>
                                <td >'.$row[2].'</td>
                                <td >'.$row[1].' FBI</td>
                                <td >'.$row[3].' FBI</td>
                            </tr>';

                            } //endwhile items


                            $table .=' </tr>';
                            $totalTVAC21 +=$totalAmount21; // total 
                            $totalTVA21 +=$vat21; // total de tva
                            $totalHTVA21 +=$subTotal21; // total hors tva
                        }


                    $table .='</table><br>';


########################################### liquids Avec TVA #################################################################################
                    $table .='<p> <h4 align="center">Liste Des Commandes Liquids Avec TVA</h4></p>';

$table .='<table style="" class="border">
        <tr>
            <th class="5p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
            <th class="30p">Client</th>
             <th class="30p">produit</th>
            <th class="5p">Quantité</th>
            <th class="10p">P.U</th>
            <th class="20p">P.T</th>
        </tr>';
while ($result12 = $query->fetch_assoc()) { 
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
$table .=' <tr>
                <td rowspan="'.  $lineRow.'">'. $result12['order_date'].'</td>
                <td rowspan="'.  $lineRow.'">'.$result12['numeroFacture'].'</td>
                <td rowspan="'. $lineRow.'">'.$result12['client_name'].' - '.$result12['client_contact'].'</td>';


                 while($row = $orderItemResult12->fetch_array()) {    

                    $table .='  <td >'.$row[4].'</td>
                                <td >'.$row[2].'</td>
                                <td >'.$row[1].' FBI</td>
                                <td >'.$row[3].' FBI</td>
                            </tr>';

                            } //endwhile items


                            $table .=' </tr>';
                            $totalTVAC12 +=$totalAmount21; // total 
                            $totalTVA12 +=$vat21; // total de tva
                            $totalHTVA12 +=$subTotal21; // total hors tva

                        }
                        

                    $table .='</table><br>';

############################################ liquids Avec TVA 

#################################################################################
                    $table .='<p> <h4 align="center">Liste Des Commandes Liquids Avec TVA</h4></p>';

$table .='<table style="" class="border">
        <tr>
            <th class="5p">Date</th>
            <th class="15p">N<sup>o</sup>. Facture</th>
            <th class="30p">Client</th>
             <th class="30p">produit</th>
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
$table .=' <tr>
                <td rowspan="'.  $lineRow.'">'. $result22['order_date'].'</td>
                <td rowspan="'.  $lineRow.'">'.$result22['numeroFacture'].'</td>
                <td rowspan="'. $lineRow.'">'.$result22['client_name'].' - '.$result22['client_contact'].'</td>';


                 while($row = $orderItemResult22->fetch_array()) {    

                    $table .='  <td >'.$row[4].'</td>
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