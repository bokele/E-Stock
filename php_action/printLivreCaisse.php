<?php 	

require_once 'core.php';
require_once '../lib/fpdf/fpdf.php';
include '../lib/phpqrcode/qrlib.php';
date_default_timezone_set('Africa/Bujumbura');

$caisseId = $_GET['caisseId'];

$societe_id = 1;

$SERVERFILEPATH = '../assests/images/qrcodeCommande/';
if (!file_exists($SERVERFILEPATH)) {
    mkdir($SERVERFILEPATH);
}

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



$sql = "SELECT id_caisse,date_caisse, montant_caisse FROM caisse   WHERE id_caisse = {$caisseId} ";
$caisseResult = $connect->query($sql);
$caisseData = $caisseResult->fetch_array();

$id_caisse 				= $caisseData[0];
$date_caisse_verifier 	= $caisseData[1];
$montant_caisse 		= $caisseData[2];



$date_caisse 		= new DateTime( $caisseData[1]);

$level ="M"; // niveau de la qualite du qrcode

$qrtext =$nom_societe;
$lien="Société :".$nom_societe."\nNIF :".$NIF_societe ."\nTél : ".$tele_societe."\nDate : ".$date_caisse->format('d/m/Y')."\nImprime Par : ".$_SESSION['userName']." , Le ".date('d/m/Y H:m:s');

$text1= substr($qrtext, 0,9);
$file_name1 = $text1."-Qrcode" . rand(2,200) . ".png";
$file_name = $SERVERFILEPATH.$file_name1;
$qrcode = new Qrlib();
qrcode::png($lien, $file_name, $level, 4, 4);
decouper($file_name);


$pdf = new FPDF();
$pdf = new FPDF('L','mm','A4');
$pdf->AcceptPageBreak();
$pdf->SetAutoPageBreak(0,0);
$pdf->AddPage();
$pdf->SetFont('Arial','B',3);			
$pdf->Write(1,"\n");
$pdf->Image($file_name,180,270,25);// affichage du qrcode 
$pdf->SetFont('Arial','B',3);			
$pdf->Write(1,"\n");
$pdf->Image($logoSociete,10,10,45);

$pdf->SetFont('Arial','UB',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(145,5,strtoupper(""),0,0,'C');
$pdf->Cell(0,5,"",0,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(240);
$pdf->Write(5 ,utf8_decode($province.", le ".$date_caisse->format('d/m/Y')));


$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(5);
$pdf->Write(12 ,utf8_decode("\n\n"));


$pdf->SetFont('Arial','UB',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(145,5,strtoupper(""),0,0,'C');
$pdf->Cell(0,5,"",0,1,'C');
################################



$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(4 ,utf8_decode(strtoupper("\nNIF : ".$NIF_societe)));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(230);
$pdf->Write(5 ,utf8_decode("B.P : ".$postBP." ".$province."-".$pays));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nR.C : ".$Registre_commerce));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(230);
$pdf->Write(5 ,utf8_decode("Tél :".$tele_societe." / ".$tele_societeSecond));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nCentre Fiscal : ".$centre_fiscal));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(230);
$pdf->Write(5 ,utf8_decode("Commune : ".$commune_societe));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nSecteur d'activité : ".$secteur_activite));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(230);
$pdf->Write(5 ,utf8_decode("Quartier : ".$quartier));



$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(230);
$pdf->Write(5,utf8_decode("\nAvenue : de l'".$avenue ."  N° ".$numero));

$left_margin=40;
$check ="";
$boolean_variable = $assujetti_tva ;
$checkbox_size = 4;
$pdf->SetX($left_margin);
//if($boolean_variable == true)
//$check = "5"; else $check ="";



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


$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\n\nLIVRE DE CAISSE DU ".$date_caisse->format('d/m/Y')));




$pdf->SetFont('Arial','UB',10);
$pdf->SetTextColor(0,0,200);
$pdf->Cell(145,5,strtoupper(""),0,0,'C');
$pdf->Cell(0,5,"",0,1,'C');
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(55,5,utf8_decode("Vente du jour"),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(55,5,utf8_decode("Vente à Crédit"),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,utf8_decode("Dépense"),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,utf8_decode("Sortie"),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,utf8_decode("Reboursement"),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(40,5,utf8_decode("Versement"),1,1,'C',true);

$sql = "SELECT SUM(grand_total) AS total_client, nom_client, prenom_client  FROM orders INNER JOIN client ON id_client = client_id  WHERE order_status = 1 AND order_date = '$date_caisse_verifier' GROUP BY client_id";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
if ($ligneback == 0) {
   $pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(55,5,utf8_decode(""),1,0,'C',true);
}else{
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);

   while ( $result = $ligne->fetch_assoc()) {
    	$pdf->Cell(55,5,utf8_decode($result["nom_client"]."-".$result["total_client"]),1,0,'C',true);
    } 

    
}

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
if ($ligneback == 0) {
   $pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(55,5,utf8_decode(""),1,0,'C',true);
}else{
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);

   while ( $result = $ligne->fetch_assoc()) {
    	$pdf->Cell(55,5,utf8_decode($result["nom_client"]."-".$result["total_client"]),1,0,'C',true);
    } 

    
}

/////////// reboursement a une date x 
$sql = "SELECT SUM(prix_total_depense) AS prix_total_depense, id_depense FROM depenses WHERE  date_depense = '$date_caisse_verifier'";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
$total_rembourse;
if ($ligneback == 0) {
  # code...
  $total_rembourse=0;
}else{
  $result = $ligne->fetch_assoc();
  $total_rembourse = floatval($result["prix_total_depense"]);
}

$sql = "SELECT SUM(prix_total_depense) AS prix_total_depense, id_depense  FROM depenses   WHERE  date_depense = '$date_caisse_verifier'";
$ligne = $connect->query($sql);

$ligneback = $ligne->num_rows;
if ($ligneback == 0) {
   $pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(45,5,utf8_decode(""),1,0,'C',true);
}else{

	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);
	$depense ="";

   while ( $result = $ligne->fetch_assoc()) {
   		$id_depense = $result["id_depense"];
   			$depenseItemSql = "SELECT depense_item.id_depense, depense_item.quantite_depense, depense_item.prix_achat_depense, depense_item.prix_achat_total_depense, depense_item.libelle_depense FROM depense_item
		INNER JOIN depenses ON depense_item.id_depense = depenses.id_depense 
 		WHERE depense_item.id_depense ='$id_depense'";
 		$depenseItemResult = $connect->query($depenseItemSql);
 		while($row = $depenseItemResult->fetch_assoc()) {

    		$depense .= $row["libelle_depense"]."-".$row["prix_achat_total_depense"]."\n";
    	}


    } 

    $pdf->Cell(45,30,utf8_decode($depense),1,0,'C',true);

    
}

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
if ($ligneback == 0) {
   $pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(45,5,utf8_decode(""),1,0,'C',true);
}else{
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);

   while ( $result = $ligne->fetch_assoc()) {
    	$pdf->Cell(45,5,utf8_decode($result["nom_client"]."-".$result["total_rembourse"]),1,0,'C',true);
    } 

    
}
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
if ($ligneback == 0) {
   $pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(45,5,utf8_decode(""),1,0,'C',true);
}else{
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);

   while ( $result = $ligne->fetch_assoc()) {
    	$pdf->Cell(45,5,utf8_decode($result["nom_client"]."-".$result["total_rembourse"]),1,0,'C',true);
    } 

    
}

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
if ($ligneback == 0) {
   $pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);
	$pdf->Cell(40,5,utf8_decode(""),1,0,'C',true);
}else{
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',9);

   while ( $result = $ligne->fetch_assoc()) {
    	$pdf->Cell(40,5,utf8_decode($result["nom_client"]."-".$result["total_rembourse"]),1,0,'C',true);
    } 

    
}

$pdf->Output();



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
