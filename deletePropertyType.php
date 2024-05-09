<?php
  require 'db.php';

  $id = $_POST['id'];

  $deletePropertyType = deletePropertyType($id);

  if ($deletePropertyType) {
    echo 'success';
  } else {
    echo 'error';
  }
?>