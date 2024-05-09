<?php
  require 'db.php';

  $id = $_POST['id'];

  $deleteOwner = deleteOwner($id);

  if ($deleteOwner) {
    echo 'success';
  } else {
    echo 'error';
  }
?>