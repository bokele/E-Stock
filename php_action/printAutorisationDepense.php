<?php 	

require_once 'core.php';
require_once '../lib/fpdf/fpdf.php';
include '../lib/phpqrcode/qrlib.php';
date_default_timezone_set('Africa/Bujumbura');

$id_depense = $_GET['depenseId'];

$societe_id = 1;

$SERVERFILEPATH = '../assests/images/qrcodeDepense/';
if (!file_exists($SERVERFILEPATH)) {
    mkdir($SERVERFILEPATH);
}

$sql = "SELECT  id_depense, ref_depense, prix_total_depense, date_depense, demende_depense, autorisation_depense,depenses.status_payement, status FROM depenses WHERE status != 2 AND depenses.id_depense = $id_depense";

$depesneResult = $connect->query($sql);
$depenseData = $depesneResult->fetch_array();

$id_depense				= $depenseData[0];
$date_depense 			= new DateTime( $depenseData[3]);
$ref_depense 			= $depenseData[1];
$prix_total_depense 	= $depenseData[2];
$demende_depense		= $depenseData[4];
$autorisation_depense	= $depenseData[5]; 
$status_payement		= $depenseData[6]; 

$sql = "SELECT depense_paye.id_depense , code_compte, numero_facture_depense, montant, type_paiement, status_paiement, date_paiement, observation  FROM depense_paye  INNER JOIN depenses ON depense_paye.id_depense = depenses.id_depense   WHERE status != 2 AND depenses.id_depense = $id_depense";

$depesneResult = $connect->query($sql);
$depensePayeLigne = $depesneResult->num_rows;

if ($depensePayeLigne > 0) {
	$depenseData = $depesneResult->fetch_array();

	$code_compte 			= $depenseData[1]; 
	$numero_facture_depense = $depenseData[2];
	$montant 				= $depenseData[3];
	$type_paiement 			= $depenseData[4]; 
	$status_paiement 		= $depenseData[5]; 
	$date_paiement 			= new DateTime($depenseData[6]);
	$observation 			= $depenseData[7];
}else{
	$code_compte 			= ""; 
	$numero_facture_depense = "";
	$montant 				= "";
	$type_paiement 			= "";; 
	$status_paiement 		= ""; 
	$date_paiement 			= "";
	$observation 			="";
}



if ($type_paiement == 1 ) {
 		$type = " Cheque";

 	}else if ($type_paiement == 2) {
 		$type = " Cash</label>";
 	}else if ($type_paiement == 3) {
 		$type = " Carte de Credit";
 	}

 	if ($status_paiement == 1 ) {
 		$status = " Payement Total";

 	}else if ($status_paiement == 2) {
 		$status = "Avance";
 	}else if ($status_paiement == 3) {
 		$status = "Credit";
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




$level ="M"; // niveau de la qualite du qrcode

$qrtext =$ref_depense;
$lien="Société :".$nom_societe."\nNIF :".$NIF_societe ."\nTél : ".$tele_societe."\nRéf No. : ".$ref_depense."\nDate : ".$date_depense->format('d/m/Y')."\Demande : ".$demende_depense."\nAutoriseé".$autorisation_depense."\nPAT : ".$prix_total_depense ."\nImprime Par : ".$_SESSION['userName']." , Le ".date('d/m/Y H:m:s');

$text1= substr($qrtext, 0,9);
$file_name1 = $text1."-Qrcode" . rand(2,200) . ".png";
$file_name = $SERVERFILEPATH.$file_name1;
$qrcode = new Qrlib();
qrcode::png($lien, $file_name, $level, 4, 4);
decouper($file_name);



$compte ="";
if ($code_compte != "") {
	$compteSql = "SELECT comptabilite_sous_compte.code_sous_compte, comptabilite_sous_compte.libelle_sous_compte, comptabilite_compte_principal.code_compte, comptabilite_compte_principal.libelle_compte
 FROM comptabilite_sous_compte
	INNER JOIN comptabilite_compte_principal ON comptabilite_compte_principal.id_compte_principal = comptabilite_sous_compte.id_compte_principal 
 WHERE comptabilite_sous_compte.id_sous_compte = '$code_compte'";

 $compteResult = $connect->query($compteSql);

$row = $compteResult->fetch_array();
	$compte = $row[0];
	
}else{
	$compte = "...............";
}




$pdf = new FPDF();
$pdf = new FPDF('P','mm','A4');
$pdf->AcceptPageBreak();
$pdf->SetAutoPageBreak(0,0);
$pdf->AddPage();
$pdf->SetFont('Arial','B',3);			
$pdf->Write(1,"\n");
$pdf->Image($file_name,180,270,25);// affichage du qrcode 
$pdf->SetFont('Arial','B',3);			
$pdf->Write(1,"\n");
$pdf->Image($logoSociete,10,10,45);

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5 ,utf8_decode($province.", le ".$date_depense->format('d/m/Y')));


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
$pdf->SetLeftMargin(150);
$pdf->Write(5 ,utf8_decode("B.P : ".$postBP." ".$province."-".$pays));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nR.C : ".$Registre_commerce));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5 ,utf8_decode("Tél : ".$tele_societe." / ".$tele_societeSecond));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nExercice Comptable : ".date("Y")));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5 ,utf8_decode("Commune : ".$commune_societe));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nImputation Budgétaire : ".$compte));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5 ,utf8_decode("Quartier : ".$quartier));


$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5,utf8_decode("\nAvenue de l'".$avenue ."  N° ".$numero));




$pdf->SetFont('Arial','BU',15);
$pdf->SetMargins(50,5,0);
$pdf->Write(5 ,utf8_decode(strtoupper("\n\nbon de depense ")."N° : ".$ref_depense));



$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\n\n"));
################################
$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nListe:"));




$pdf->SetFont('Arial','UB',10);
$pdf->SetTextColor(0,0,200);
$pdf->Cell(145,5,strtoupper(""),0,0,'C');
$pdf->Cell(0,5,"",0,1,'C');
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(15,5,utf8_decode("N°"),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(80,5,utf8_decode("Désignation  "),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,5,utf8_decode("Quantité."),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(40,5,utf8_decode("Prix Achat ( Bif )"),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,utf8_decode("Prix Achat Total ( Bif )"),1,1,'C',true);

$depenseItemSql = "SELECT depense_item.id_depense, depense_item.quantite_depense, depense_item.prix_achat_depense, depense_item.prix_achat_total_depense, depense_item.libelle_depense FROM depense_item
	INNER JOIN depenses ON depense_item.id_depense = depenses.id_depense 
 WHERE depense_item.id_depense ='$id_depense'";
$depenseItemResult = $connect->query($depenseItemSql);

$x = 1;
while($row = $depenseItemResult->fetch_array()) {	
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(15,5,utf8_decode($x),1,0,'C');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(80,5,utf8_decode(substr($row[4], 0,25)),1,0,'L');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(20,5,utf8_decode($row[1]),1,0,'C');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,5,utf8_decode($row[2]),1,0,'R');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,5,utf8_decode($row[3]),1,1,'R');
	$x++;
}
$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(155,5,utf8_decode("TOTAL GENERAL"),1,0,'L');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(45,5,utf8_decode($prix_total_depense),1,1,'R');

//$fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);

/*$pdf->SetFont('Arial','i',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nNous disons ".$prix_total_depense." francs burundais."));*/

$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(5);
$pdf->Write(12 ,utf8_decode("\n"));


$pdf->SetFont('Arial','UB',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(145,5,strtoupper(""),0,0,'C');
$pdf->Cell(0,5,"",0,1,'C');
################################



$pdf->SetFont('Arial','BU',10);
$pdf->SetLeftMargin(5);
$pdf->Write(4 ,utf8_decode("\nPour établissement"));



$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\n".$demende_depense));

$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(5);
$pdf->Write(12 ,utf8_decode("\n"));

$pdf->SetFont('Arial','BU',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("ACCORD DE PAIEMENT"));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\n".$autorisation_depense));

if ($status_payement == 1) {
	$pdf->SetFont('Arial','B',12);
	$pdf->SetTextColor(255,0,0);
$pdf->SetLeftMargin(130);
$pdf->Write(5 ,utf8_decode("Mention : Payé"));
}

$compteSql = "SELECT comptabilite_sous_compte.code_sous_compte, comptabilite_sous_compte.libelle_sous_compte, comptabilite_compte_principal.code_compte, comptabilite_compte_principal.libelle_compte
 FROM comptabilite_sous_compte
	INNER JOIN comptabilite_compte_principal ON comptabilite_compte_principal.id_compte_principal = comptabilite_sous_compte.id_compte_principal 
 WHERE comptabilite_sous_compte.id_sous_compte = '$code_compte'";

 $compteResult = $connect->query($compteSql);

$row = $compteResult->fetch_array();

$compte = $row[0];

if ($code_compte != "") {

	$pdf->SetTextColor(0,0,0);

	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(130);
	$pdf->Write(5 ,utf8_decode("\n\n\nDate Facture : ".$date_paiement->format('d/m/Y')));

	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(130);
	$pdf->Write(5 ,utf8_decode("\nNumero Facture : ".$numero_facture_depense));

	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(130);
	$pdf->Write(5 ,utf8_decode("T\nType de paiement : ".$type));

	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(130);
	$pdf->Write(5 ,utf8_decode("\nStatus de paiement : ".$status));


	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(5);
	$pdf->Write(5 ,utf8_decode("\nObservation : ".$observation));

	
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