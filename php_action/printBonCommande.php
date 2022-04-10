<?php 	

require_once 'core.php';
require_once '../lib/fpdf/fpdf.php';
include '../lib/phpqrcode/qrlib.php';
date_default_timezone_set('Africa/Bujumbura');

$id_commande = $_GET['commandeId'];

$societe_id = 1;

$SERVERFILEPATH = '../assests/images/qrcodeCommande/';
if (!file_exists($SERVERFILEPATH)) {
    mkdir($SERVERFILEPATH);
}

$sql = "SELECT id_commande, ref_commande, date_commande, brand_name,  prix_total_achat, status,  user_add, date_add FROM boncommande INNER JOIN brands ON brand_id = id_marque  WHERE status != 4 AND id_commande = $id_commande";

$commnadeResult = $connect->query($sql);
$CommnadeData = $commnadeResult->fetch_array();

$id_commande 		= $CommnadeData[0];
$date_commande 		= new DateTime( $CommnadeData[2]);
$ref_commande 		= $CommnadeData[1];
$brand_name 		= $CommnadeData[3];
$quantite_total		= $CommnadeData[4];
$prix_total_achat	= $CommnadeData[5]; 

$sql = "SELECT code_compte, boncommande_paye.montant, type_paiement, status_paiement, date_paiement, boncommande_paye.observation FROM  boncommande_paye INNER JOIN boncommande  ON boncommande.id_commande = boncommande_paye.id_boncommande WHERE  boncommande_paye.id_boncommande =  $id_commande";
$sortiePayeResult = $connect->query($sql);

$vide="";
$code_compte 			= $vide;
$montantPaye 			= $vide;
$type_paiement 			= $vide;
$status_paiement 		= $vide;
$date_paiement 			= $vide;
$observation 			= $vide;
$status_payement		= $vide; 

if ($sortiePayeResult->num_rows > 0) {
	$sortiePayeData = $sortiePayeResult->fetch_array();
	$code_compte 			= $sortiePayeData[0];
	$montantPaye 			= $sortiePayeData[1];
	$type_paiement 			= $sortiePayeData[2];
	$status_paiement 		= $sortiePayeData[3];
	$date_paiement 			= new DateTime($sortiePayeData[4]);
	$observation 			= $sortiePayeData[5];
	//$status_payement		= $sortiePayeData[6]; 
}else{
	$code_compte 			= $vide;
	$montantPaye 			= $vide;
	$type_paiement 			= $vide;
	$status_paiement 		= $vide;
	$date_paiement 			= $vide;
	$observation 			= $vide;
	$status_payement		= $vide; 
}



if ($type_paiement == 1 ) {
 		$type = " Cheque";
 	}else if ($type_paiement == 2) {
 		$type = " Cash</label>";
 	}else if ($type_paiement == 3) {
 		$type = " Carte de Credit";
 	}
$status = "";
 	if ($status_paiement == 1 ) {
 		$status = "Paiement Total";

 	}else if ($status_paiement == 2) {
 		$status = "Paiement avec Avance";
 	}else{
 		$status = "Paiement avec Credit";
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

$qrtext =$brand_name;
$lien="Société :".$nom_societe."\nNIF :".$NIF_societe ."\nTél : ".$tele_societe."\nRéf No. : ".$ref_commande."\nDate : ".$date_commande->format('d/m/Y')."\nClient : ".$brand_name."\nPAT : ".$prix_total_achat ."\nImprime Par : ".$_SESSION['userName']." , Le ".date('d/m/Y H:m:s');

$text1= substr($qrtext, 0,9);
$file_name1 = $text1."-Qrcode" . rand(2,200) . ".png";
$file_name = $SERVERFILEPATH.$file_name1;
$qrcode = new Qrlib();
qrcode::png($lien, $file_name, $level, 4, 4);
decouper($file_name);

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

$pdf->SetFont('Arial','UB',10);
$pdf->SetTextColor(0,0,0);
$pdf->Cell(145,5,strtoupper(""),0,0,'C');
$pdf->Cell(0,5,"",0,1,'C');

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5 ,utf8_decode($province.", le ".$date_commande->format('d/m/Y')));


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
$pdf->Write(5 ,utf8_decode("Tél :".$tele_societe." / ".$tele_societeSecond));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nCentre Fiscal : ".$centre_fiscal));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5 ,utf8_decode("Commune : ".$commune_societe));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nSecteur d'activité : ".$secteur_activite));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5 ,utf8_decode("Quartier : ".$quartier));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nAssujetti à la TVA :"));

$pdf->SetFont('Arial','',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5,utf8_decode("Avenue de l'".$avenue ."  No ".$numero));

$left_margin=40;
$check ="";
$boolean_variable = $assujetti_tva ;
$checkbox_size = 4;
$pdf->SetX($left_margin);
//if($boolean_variable == true)
//$check = "5"; else $check ="";

$pdf->SetFont('ZapfDingbats','', 8);
$pdf->cell($checkbox_size, $checkbox_size,$check, 1, 0);
$pdf->SetFont('Arial','', 10);
$pdf->write(5,"Oui");

$left_margin=55;
$boolean_variable = false;
$checkbox_size = 4;
$check ="";
$pdf->SetX($left_margin);

//if($boolean_variable == true)
//$check = "5"; else $check ="";
$pdf->SetFont('ZapfDingbats','', 8);
$pdf->cell($checkbox_size, $checkbox_size,$check, 1, 0);
$pdf->SetFont('Arial','', 10);
$pdf->write(5,"Non");

$pdf->SetFont('Arial','BU',15);
$pdf->SetMargins(50,5,0);
$pdf->Write(5 ,utf8_decode(strtoupper("\n\nBon de commande ")."No : ".$ref_commande));

$pdf->SetFont('Arial','B',10);
$pdf->SetMargins(50,5,0);
$pdf->Write(7 ,utf8_decode(strtoupper("\nFournisseur : ".$brand_name)));

$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\n\n"));
################################
$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(5);
$pdf->Write(3 ,utf8_decode("\nListe des produits  commandés:"));




$pdf->SetFont('Arial','UB',10);
$pdf->SetTextColor(0,0,200);
$pdf->Cell(145,5,strtoupper(""),0,0,'C');
$pdf->Cell(0,5,"",0,1,'C');
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(20,5,utf8_decode("No."),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(100,5,utf8_decode("Désignation  "),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(40,5,utf8_decode("Quantité."),1,1,'C',true);
################################
/*$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(40,5,utf8_decode("Prix Achat ( Bif )"),1,0,'C',true);
################################
$pdf->SetFillColor(224,235,255);
$pdf->SetLineWidth(.3);
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,utf8_decode("Prix Achat Total ( Bif )"),1,1,'C',true);*/

$commandeItemSql = "SELECT boncommande_item.id_commande, boncommande_item.quantite, boncommande_item.prix_achat, boncommande_item.prix_achat_total,
product.product_name FROM boncommande_item
	INNER JOIN product ON boncommande_item.id_produit = product.product_id 
 WHERE boncommande_item.id_commande = $id_commande";
$commandeItemResult = $connect->query($commandeItemSql);

$x = 1;
while($row = $commandeItemResult->fetch_array()) {	
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(20,5,utf8_decode($x),1,0,'C');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(100,5,utf8_decode(substr($row[4], 0,25)),1,0,'L');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,5,utf8_decode($row[1]),1,1,'R');
	################################
	/*$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(40,5,utf8_decode($row[2]),1,0,'R');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(45,5,utf8_decode($row[3]),1,1,'R');*/
	$x++;
}
	/*$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(155,5,utf8_decode("TOTAL GENERAL"),1,0,'L');
	################################
	$pdf->SetFillColor(224,235,255);
	$pdf->SetLineWidth(.3);
	$pdf->SetTextColor(0,0,0);
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(45,5,utf8_decode($prix_total_achat),1,1,'R');

$fmt = new NumberFormatter('fr', NumberFormatter::SPELLOUT);

$pdf->SetFont('Arial','i',10);
$pdf->SetLeftMargin(5);
$pdf->Write(5 ,utf8_decode("\nNous disons ".$fmt->format($prix_total_achat)." francs burundais."));*/






$pdf->SetFont('Arial','B',10);
$pdf->SetLeftMargin(5);
$pdf->Write(12 ,utf8_decode("\n"));

$pdf->SetFont('Arial','BU',10);
$pdf->SetLeftMargin(150);
$pdf->Write(5 ,utf8_decode("La Direction\n"));



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
	$pdf->SetLeftMargin(5);
	$pdf->Write(5 ,utf8_decode("\n\n\nExercice Comptable : ".date("Y")));

	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(130);
	$pdf->Write(5 ,utf8_decode("Date Facture : ".$date_paiement->format('d/m/Y')));

	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(5);
	$pdf->Write(5 ,utf8_decode("\nImputation Budgétaire : ".$compte));

	

	$pdf->SetFont('Arial','',10);
	$pdf->SetLeftMargin(130);
	$pdf->Write(5 ,utf8_decode("Type de paiement : ".$type));

	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(255,0,0);
	$pdf->SetLeftMargin(130);
	$pdf->Write(5 ,utf8_decode("\nStatus de paiement : ".$status));


	$pdf->SetFont('Arial','',10);
	$pdf->SetTextColor(0,0,0);
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