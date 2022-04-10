<?php 	

require_once 'core.php';
require_once '../lib/fpdf/fpdf.php';
include '../lib/phpqrcode/qrlib.php';

$orderId = $_GET['orderId'];
//$orderId = $_GET['orderId'];

$societe_id = 1;

$SERVERFILEPATH = '../assests/images/qrcode/';
if (!file_exists($SERVERFILEPATH)) {
    mkdir($SERVERFILEPATH);
 }

$sql = "SELECT order_date, nom_client, prenom_client, sub_total, vat, total_amount, discount, grand_total, paid, due,order_id, nif_client, client_tva, adresse_client, numeroFacture, telephone_client FROM orders INNER JOIN client ON id_client = client_id WHERE order_id = $orderId";

$orderResult = $connect->query($sql);
$orderData = $orderResult->fetch_array();

$orderDate 			= new DateTime( $orderData[0]);
$clientName 		= $orderData[1]." ".$orderData[2];
$clientContact 		= $orderData[15]; 
$subTotal 			= $orderData[3];
$vat 				= $orderData[4];
$totalAmount		= $orderData[5]; 
$discount 			= $orderData[6];
$grandTotal 		= $orderData[7];
$paid 				= $orderData[8];
$due 				= $orderData[9];
$order_id 			= $orderData[10];
$nif_client 		= $orderData[11];
$client_tva 		= $orderData[12];
$client_residence 	= $orderData[13];
$numeroFacture 		= $orderData[14];

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

$centre_fiscal = $societeData[15];
$forme_juridique = $societeData[16];
$secteur_activite = $societeData[17];
$logoSociete 		= $societeData[18];



date_default_timezone_set('Africa/Bujumbura');

$orderItemSql = "SELECT order_item.product_id, order_item.rate, order_item.quantity, order_item.total,
product.product_name FROM order_item
	INNER JOIN product ON order_item.product_id = product.product_id 
 WHERE order_item.order_id = $orderId";
$orderItemResult = $connect->query($orderItemSql);

$level ="M"; // niveau de la qualite du qrcode

$qrtext =$clientName;
$lien="\nFact. N°. : ".$numeroFacture."\nDate : ".$orderDate->format('d/m/Y')."\nClient : ".$clientName."\nPV-TVAC : ".$totalAmount ."\nImprime Par : ".$_SESSION['userName']." , Le ".date('d/m/Y H:m:s');

$text1= substr($qrtext, 0,9);
$file_name1 = $text1."-Qrcode" . rand(2,200) . ".png";
$file_name = $SERVERFILEPATH.$file_name1;
$qrcode = new Qrlib();
qrcode::png($lien, $file_name, $level, 4, 4);
decouper($file_name);


$pdf = new FPDF();
$size=array(105,148);
$pdf = new FPDF('P','mm',$size);
$pdf->AcceptPageBreak();
$pdf->SetAutoPageBreak(0,0);
$pdf->AddPage();
$pdf->SetFont('Arial','B',3);			
$pdf->Write(1,"\n");
$pdf->Image($file_name,78,28,18);// affichage du qrcode 

$pdf->SetFont('Arial','B',7);
$pdf->SetTopMargin(0);
$pdf->SetLeftMargin(25);
$pdf->Write(3,utf8_decode(strtoupper("FACTURE N° : ".$numeroFacture)));

$pdf->SetFont('Arial','',7);
$pdf->SetLeftMargin(70);
$pdf->Write(3," Date : ".$orderDate->format('d/m/Y'));
$pdf->Write(1,"\n");
$pdf->SetFont('Arial','B',4);
$pdf->SetTextColor(20,20,20);

$pdf->SetFont('Arial','B',3);			
$pdf->Write(1,"\n");
$pdf->Image($logoSociete,5,2,20);


$pdf->SetFillColor(224,235,255);
$pdf->SetFont('Arial','B',7);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode(strtoupper("\nA. IDENTIFICATION DU VENDEUR")));

$pdf->SetFont('Arial','B',7);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode(strtoupper("\n".$nom_societe)));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(50);
$pdf->Write(3 ,utf8_decode("Centre Fiscal : ".$centre_fiscal));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nDépôt DVD"));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(50);
$pdf->Write(3 ,utf8_decode("Secteur d'activité : ".$secteur_activite));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode(strtoupper("\nNIF : ".$NIF_societe)));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(50);
$pdf->Write(3 ,utf8_decode("Forme Juridique : ".$forme_juridique));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nR.C : ".$Registre_commerce.", B.P : ".$postBP." ".$province."-".$pays));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nTél :".$tele_societe." / ".$tele_societeSecond));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nCommune : ".$commune_societe .", Quartier : ".$quartier ));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(5);
$pdf->Write(3,utf8_decode("\nAvenue de l'".$avenue ."  No ".$numero));

$pdf->SetFont('Arial','',6.5);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nAssujetti à la TVA :"));

$left_margin=25;
$check ="";
$boolean_variable = $assujetti_tva ;
$checkbox_size = 2.2;
$pdf->SetX($left_margin);
//if($boolean_variable == true)
//$check = "5"; else $check ="";

$pdf->SetFont('ZapfDingbats','', 4);
$pdf->cell($checkbox_size, $checkbox_size,$check, 1, 0);
$pdf->SetFont('Arial','', 5);
$pdf->write(2,"Oui");

$left_margin=32;
$boolean_variable = false;
$checkbox_size = 2.2;
$check ="";
$pdf->SetX($left_margin);
//if($boolean_variable == true)
//$check = "5"; else $check ="";
$pdf->SetFont('ZapfDingbats','', 4);
$pdf->cell($checkbox_size, $checkbox_size,$check, 1, 0);
$pdf->SetFont('Arial','', 5);
$pdf->write(2,"Non");




$pdf->SetFont('Arial','B',7);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode(strtoupper("\nB. IDENTIFICATION DU CLIENT")));

$pdf->SetFont('Arial','B',6);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode(strtoupper("\nNom ou Raison Social : ".$clientName)));

$pdf->SetFont('Arial','',6);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode(strtoupper("\nNIF : ".$nif_client)));


$pdf->SetFont('Arial','',6);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nRésident à : ".$client_residence));

$pdf->SetFont('Arial','',6);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nTéléphone : ".$clientContact));

$pdf->SetFont('Arial','',5);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nAssujetti à la TVA :"));

$left_margin=25;

$tva ="";
if($client_tva == 0){
	$boolean_variable = true;
}else{
	$boolean_variable = false;
}
$checkbox_size = 2.2;
$pdf->SetX($left_margin);
//if($boolean_variable == true)
//$check = "5"; else $check ="";
$pdf->SetFont('ZapfDingbats','', 4);
$pdf->cell($checkbox_size, $checkbox_size,$check, 1, 0);
$pdf->SetFont('Arial','', 5);
$pdf->write(2,"Oui");

$left_margin=32;
$checkbox_size = 2.2;
$pdf->SetX($left_margin);
//if($boolean_variable == false)
//$check = "5"; else $check ="";
$pdf->SetFont('ZapfDingbats','', 4);
$pdf->cell($checkbox_size, $checkbox_size,$check, 1, 0);
$pdf->SetFont('Arial','', 5);
$pdf->write(2,"Non");

$pdf->SetFont('Arial','B',5);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nDoit pour ce qui suit:"));




$pdf->SetFont('Arial','UB',12);
$pdf->SetTextColor(0,0,200);
$pdf->Cell(145,5,strtoupper(""),0,0,'C');
$pdf->Cell(0,5,"",0,1,'C');
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(10,5,utf8_decode("N°"),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(35,5,utf8_decode("Produit  "),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(10,5,utf8_decode("Qt."),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,5,utf8_decode("P.U "),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,5,utf8_decode("PV-THTVA"),1,1,'C',true);


$x = 1;
while($row = $orderItemResult->fetch_array()) {	
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,5,utf8_decode($x),1,0,'C');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(35,5,utf8_decode(substr($row[4], 0,25)),1,0,'L');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(10,5,utf8_decode($row[2]),1,0,'R');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(20,5,utf8_decode($row[1]),1,0,'R');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(20,5,utf8_decode($row[3]),1,1,'R');
	$x++;
}

$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,5,utf8_decode("PV-THTVA"),1,0,'C');
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,utf8_decode($subTotal),1,1,'R');
	################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,5,utf8_decode("TVA(18%)"),1,0,'C');
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,utf8_decode($vat),1,1,'R');
	################################	

$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',8);
$pdf->Cell(75,5,utf8_decode("PV-TVAC"),1,0,'C');
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,utf8_decode($totalAmount),1,1,'R');
################################	

$pdf->SetFont('Arial','B',8);
$pdf->SetLeftMargin(40);
$pdf->Write(3 ,utf8_decode("\nMerci et à Bientôt"));

$pdf->Output();
$connect->close();

//echo $table;

function decouper($fil)
{
	$src=imagecreatefrompng($fil);

	list($width,$height)=getimagesize($fil);
	$newwidth=$width - 18;
	$newheight=$height - 18;

	$resz = imagecreatetruecolor($newwidth,$newheight);

	$width=$width - 18;
	$height=$height - 18;

	imagecopyresized($resz,$src,0, 0, 9, 9, $newwidth, $newheight, $width, $height);
	imagepng($resz,$fil);
}