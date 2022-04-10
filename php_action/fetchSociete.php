<?php 	

require_once 'core.php';



$valid = array('order' => array(), 'order_item' => array());
$societeId = $_POST["societeId"];

$sql = "SELECT nom_societe, siegle_societe, tele_societe, tele_societeSecond, postBP, pays, province, commune_societe, quartier, avenue, numero, email_societe, assujetti_tva, NIF_societe, Registre_commerce, centre_fiscal, forme_juridique, secteur_activite FROM societe WHERE societe_id={$societeId}";

$result = $connect->query($sql);
$data = $result->fetch_row();
$valid['order'] = $data;


$connect->close();

echo json_encode($valid);

?>