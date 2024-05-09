<?php
  require 'db.php';

  $number = $_POST['Number'];
  $address = $_POST['Address'];
  $area = $_POST['Area'];
  $propertyType = $_POST['PropertyTypeId'];
  $owner = $_POST['OwnerId'];
  $constructionArea = $_POST['ConstructionArea'];

  $id = isset($_POST['id']) ? $_POST['id'] : '';

  $data = [
    'Number' => $number,
    'Address' => $address,
    'Area' => $area,
    'PropertyTypeId' => $propertyType,
    'OwnerId' => $owner,
    'ConstructionArea' => $constructionArea,
  ];
  
  if (!empty($id)) {
    $data['Id'] = $id;

    $updateProperty = updateProperty($data);

    if ($updateProperty) {
      echo 'success';
    } else {
      echo 'error';
    }   

  } else {
    $createProperty = createProperty($data);

    if ($createProperty) {
      echo 'success';
    } else {
      echo 'error';
    }  
  }

?>