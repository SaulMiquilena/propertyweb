<?php
  require 'db.php';

  $name = $_POST['name'];
  $telephone = $_POST['telephone'];
  $email = $_POST['email'];
  $identificationNumber = $_POST['identificationNumber'];
  $address = $_POST['address'];

  $id = isset($_POST['id']) ? $_POST['id'] : '';

  $data = [
    'Name' => $name,
    'Telephone' => $telephone,
    'Email' => $email,
    'IdentificationNumber' => $identificationNumber,
    'Address' => $address,
  ];
  
  if (!empty($id)) {
    $data['Id'] = $id;

    $updateOwner = updateOwner($data);

    if ($updateOwner) {
      echo 'success';
    } else {
      echo 'error';
    }     

  } else {
    $createOwner = createOwner($data);

    if ($createOwner) {
      echo 'success';
    } else {
      echo 'error';
    }  
  }
?>