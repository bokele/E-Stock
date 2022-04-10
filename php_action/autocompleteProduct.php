<?php


// Get search term
$searchTerm = $_GET['term'];

// Get matched data from skills table
$productSql = "SELECT * FROM product WHERE active = 1 AND status = 1 AND quantity != 0";
$productData = $connect->query($productSql);

// Generate skills data array
$productData = array();
if($query->num_rows > 0){
    while($row = $query->fetch_assoc()){
        $data['id'] = $row['id'];
        $data['value'] = $row['product_name'];
        array_push($productData, $data);
    }
}

// Return results as json encoded array
echo json_encode($productData);

?>