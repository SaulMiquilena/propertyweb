<?php
  require 'db.php';

  $id = $_POST['id'];

  $deleteProperty = deleteProperty($id);

  if ($deleteProperty) {
    echo 'success';
  } else {
    echo 'error';
  }
?>