<?php
  require 'db.php';

  $description = $_POST['description'];
  $id = isset($_POST['id']) ? $_POST['id'] : '';

  $data = [
    'Description' => $description,
  ];
  
  if (!empty($id)) {
    $data['Id'] = $id;

    $updatePropertyType = updatePropertyType($data);

    if ($updatePropertyType) {
      echo 'success';
    } else {
      echo 'error';
    }    

  } else {
    $createPropertyType = createPropertyType($data);

    if ($createPropertyType) {
      echo 'success';
    } else {
      echo 'error';
    } 
  }

?>