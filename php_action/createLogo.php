<?php

require_once 'core.php';
date_default_timezone_set('Africa/Bujumbura');
$valid['success'] = array('success' => false, 'messages' => array());

if ($_POST) {

  $societe_id = $_POST['societe_id'];

  $type = explode('.', $_FILES['logoImage']['name']);
  $type = $type[count($type) - 1];
  $url = '/assests/images/' . uniqid(rand()) . '.' . $type;
  if (in_array($type, array('gif', 'jpg', 'jpeg', 'png', 'JPG', 'GIF', 'JPEG', 'PNG'))) {
    if (is_uploaded_file($_FILES['logoImage']['tmp_name'])) {
      if (move_uploaded_file($_FILES['logoImage']['tmp_name'], $url)) {

        $sql = "UPDATE societe SET logoSociete = '$url' WHERE societe_id = '$societe_id'";

        if ($connect->query($sql) === TRUE) {
          $valid['success'] = true;
          $valid['messages'] = "le logo est bien ajouter";
        } else {
          $valid['success'] = false;
          $valid['messages'] = "Error while updating logo image" . mysqli_error($connect);
        }
      } else {
        return false;
      } // /else  
    } // if
  } // if in_array    

  $connect->close();

  echo json_encode($valid);
} // /if $_POST