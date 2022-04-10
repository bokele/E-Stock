<?php
require_once 'core.php';		
	//Get search term
$searchTerm = $_GET['term'];

// Get matched data from skills table
$query = $connect->query("SELECT * FROM comptabilite_compte_principal WHERE libelle_compte LIKE '%".$searchTerm."%' OR 	code_compte LIKE '%".$searchTerm."%' AND status = '1' ORDER BY code_compte ASC");

// Generate skills data array
$skillData = array();
if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $data['id'] = $row['id_compte_principal'];
        $data['value'] = $row['code_compte']."-".$row['libelle_compte'];
        array_push($skillData, $data);
    }
}

// Return results as json encoded array
echo json_encode($skillData);

?>