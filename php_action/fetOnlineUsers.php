

<?php 	

require_once 'core.php';

$sql = "SELECT id_user, date_enter, date_close,user_online.status, username FROM user_online INNER JOIN users ON id_user = user_id";
$result = $connect->query($sql);



$output = array('data' => array());

if($result->num_rows > 0) { 

 // $row = $result->fetch_array();
 $activeUtlisateur = ""; 
 $role ="";
 $connection="";

 while($row = $result->fetch_array()) {
 	$online = $row[3];
		
		if ($online == 1) {
			$connection = '<div class="user-text-online"><span class="user-circle-online btn btn-success btn-circle"></span></div>';
		}else{
			$connection = '<div class="user-text-online"><span class="user-circle-online btn btn-danger btn-circle"></span></div>';
		}


 

 


 	$output['data'][] = array( 		
 		$row[4], 
 		$row[1],
 		$row[2],
 		$connection,		
 		); 	
 } // /while 

}// if num_rows

$connect->close();

echo json_encode($output);