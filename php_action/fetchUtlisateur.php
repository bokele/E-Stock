

<?php 	

require_once 'core.php';

//$sql = "SELECT user_id, username, email, telephone, role, status,agence FROM users INNER JOIN agence ON  users.id_agence=agence.id_agence  ORDER BY username ASC";
$sql = "SELECT user_id, username, email, telephone, role, status FROM users   ORDER BY username ASC";
$result = $connect->query($sql);



$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeUtlisateur = ""; 
 $role ="";
 $connection="";

 while($row = $result->fetch_array()) {
 	$utlisatueId = $row[0];

 	$connectOnline = "SELECT idOnline, id_user, date_enter, date_close, status FROM user_online   Where id_user =$utlisatueId";
	$resultOnline = $connect->query($connectOnline);
	while($rowOnline = $resultOnline->fetch_array()) {

		$online = $rowOnline[4];
		
		if ($online == 1) {
			$connection = '<div class="user-text-online"><span class="user-circle-online btn btn-success btn-circle"></span></div>';
		}else{
			$connection = '<div class="user-text-online"><span class="user-circle-online btn btn-danger btn-circle"></span></div>';
		}
	}



 	// active 
 	if($row[5] == 1) {
 		// activate member
 		$activeUtlisateur = "<label class='label label-primary'>Active</label>";
 	} else {
 		// deactivate member
 		$activeUtlisateur = "<label class='label label-danger'>Desactive</label>";
 	}
 	// role

 		

 	if($row[4] == 1) {
 		$role = "<label class='label label-success'>Derecteur(trice)</label>";
 	} elseif($row[4] == 2) {
 		$role = "<label class='label label-warning'>Stock</label>";
 	}elseif($row[4] == 3){
 		$role = "<label class='label label-info'>Facturation</label>";
 	}elseif ($row[4] == 5) {
 		$role = "<label class='label label-primary'>Administrateur</label>";
 	}else{
 		$role = "<label class='label label-default'>Comptable</label>";
 	}


 	$button = '<!-- Single button -->
	
	  <a type="button" data-toggle="modal" id="editCategoriesModalBtn" data-target="#editCategoriesModal" onclick="editUtlisateur('.$utlisatueId.')" class ="btn btn-warning btn-sm"> <i class="glyphicon glyphicon-edit"></i></a>
	    <a type="button" data-toggle="modal" data-target="#removeUtlisateurModal" id="removeCategoriesModalBtn" onclick="removeUtilisateur('.$utlisatueId.')" class ="btn btn-danger btn-sm"> <i class="glyphicon glyphicon-trash"></i></a>      
	  ';

 	$output['data'][] = array( 	
 		"kigobe",	
 		$row[1], 
 		$row[2],
 		$row[3],
 		$role,		
 		$activeUtlisateur,
 		$connection,
 		$button 		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);