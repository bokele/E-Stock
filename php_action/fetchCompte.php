<?php 	

require_once 'core.php';



$valid = array('compteData' => array());


$sql = "SELECT id_compte_principal, id_classe, libelle_classe, code_compte, libelle_compte, comptabilite_compte_principal.status, comptabilite_compte_principal.user_add, comptabilite_compte_principal.date_add FROM comptabilite_compte_principal INNER JOIN comptabilite_classe_compte ON  comptabilite_compte_principal.id_classe = comptabilite_classe_compte.id WHERE comptabilite_compte_principal.status=1 ORDER BY code_compte ASC";

$result = $connect->query($sql);
 $x=1;
  while($row = $result->fetch_array()){
  	$id_compte_principal =$row[0];
 	$button = '<!-- Single button -->
 	

	<a type="button" data-toggle="modal" id="editCompteModalBtn" data-target="#compteEditModal" onclick="editCompte('.$id_compte_principal.')" class ="btn btn-warning btn-sm"> <i class="btn-warning  glyphicon glyphicon-edit"></i> </a>

	    <a type="button" data-toggle="modal" data-target="#removeCompteModal" id="removeCompteModalBtn" onclick="removeCompte('.$id_compte_principal.')" class ="btn btn-danger btn-sm"> <i class="btn-danger  glyphicon glyphicon-trash"></i></a></li>       
	 ';
	
 	$valid['data'][] = array( 
 		//$x,	
 		// code
 		$row[3],

 		// compte
 		$row[4],	
 		// classe
 		$row[2],
 		
 		// button
 		$button 		
 		); 

 		//$x++;	
 } // /while

echo mysqli_error($connect);

$connect->close();

echo json_encode($valid);

?>