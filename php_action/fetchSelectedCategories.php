<?php 	

require_once 'core.php';

$categoriesId = $_POST['categoriesId'];

$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_id = $categoriesId";
$result = $connect->query($sql);

if($result->num_rows > 0) { 
 $row = $result->fetch_array();
} // if num_rows

$connect->close();

echo json_encode($row);


/*if ($_POST['action'] == "brandName" ) {
	$sql = "SELECT categories_id, categories_name, categories_active, categories_status FROM categories WHERE categories_status = 1 AND categories_active = 1 AND  ORDER BY categories_name ASC";
	$result = $connect->query($sql);

	while($row = $result->fetch_array()) {
		echo "<option value='".$row[0]."'>".$row[1]."</option>";
	} // while
}*/
?>