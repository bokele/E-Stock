<?php 	

require_once 'core.php';



$valid = array('sousCompteData' => array());


$sql = "SELECT id_sous_compte,  code_sous_compte, libelle_sous_compte, libelle_compte, comptabilite_sous_compte.id_compte_principal, comptabilite_sous_compte.status, comptabilite_sous_compte.user_add, comptabilite_sous_compte.date_add, id_classe FROM comptabilite_sous_compte INNER JOIN comptabilite_compte_principal ON  comptabilite_sous_compte.id_compte_principal = comptabilite_compte_principal.id_compte_principal 
INNER JOIN comptabilite_classe_compte ON  comptabilite_classe_compte.id = comptabilite_compte_principal.id_classe
WHERE comptabilite_sous_compte.status=1 ORDER BY code_sous_compte ASC";

$result = $connect->query($sql);
 //$x=1;
  while($row = $result->fetch_array()){
  	$id_sous_compte =$row[0];
 	$button = '<!-- Single button -->
 	

	<a type="button" data-toggle="modal" id="editSousCompteModalBtn" data-target="#sousCompteEditModal" onclick="editSousCompte('.$id_sous_compte.')" class ="btn btn-warning btn-sm"> <i class="btn-warning  glyphicon glyphicon-edit"></i> </a>

	    <a type="button" data-toggle="modal" data-target="#removeSousCompteModal" id="removeSousCompteModalBtn" onclick="removSousCompte('.$id_sous_compte.')" class ="btn btn-danger btn-sm"> <i class="btn-danger  glyphicon glyphicon-trash"></i></a></li>       
	 ';
	
 	$valid['data'][] = array( 
 		//$x,	
 		// code
 		$row[1],

 		// compte
 		$row[2],	
 		// classe
 		$row[3],
 		
 		// button
 		$button 		
 		); 

 		//$x++;	
 } // /while

echo mysqli_error($connect);

$connect->close();

echo json_encode($valid);

?>