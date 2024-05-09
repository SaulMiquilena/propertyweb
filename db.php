<?php
  $host = 'localhost';
  $db = 'propertyweb';
  $user = 'propertyweb';
  $password = 'propertyweb';

  try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
  }

  function getProperties() {
    global $conn;

    $sql = 'SELECT * FROM `Property` WHERE `Deleted` = 0';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function getPropertyTypes() {
    global $conn;

    $sql = 'SELECT * FROM `PropertyType` WHERE `Deleted` = 0';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function getOwners() {
    global $conn;

    $sql = 'SELECT * FROM `Owner` WHERE `Deleted` = 0';
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll();
  }

  function getProperty($id) {
    global $conn;

    $sql = 'SELECT * FROM `Property` WHERE id = :id AND `Deleted` = 0';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
  }

  function getPropertyType($id) {
    global $conn;

    $sql = 'SELECT * FROM `PropertyType` WHERE id = :id AND `Deleted` = 0';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
  }

  function getOwner($id) {
    global $conn;

    $sql = 'SELECT * FROM `Owner` WHERE id = :id AND `Deleted` = 0';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt->fetch();
  }

  function createProperty($data) {
    global $conn;

    $sql = 'INSERT INTO `Property` (`PropertyTypeId`, `OwnerId`, `Number`, `Address`, `Area`, `ConstructionArea`) VALUES (:PropertyTypeId, :OwnerId, :Number, :Address, :Area, :ConstructionArea)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':PropertyTypeId', $data['PropertyTypeId']);
    $stmt->bindParam(':OwnerId', $data['OwnerId']);
    $stmt->bindParam(':Number', $data['Number']);
    $stmt->bindParam(':Address', $data['Address']);
    $stmt->bindParam(':Area', $data['Area']);
    $stmt->bindParam(':ConstructionArea', $data['ConstructionArea']);
    return $stmt->execute();
  }

  function createPropertyType($data) {
    global $conn;

    $sql = 'INSERT INTO `PropertyType` (`Description`) VALUES (:description)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':description', $data['Description']);
    return $stmt->execute();
  }

  function createOwner($data) {
    global $conn;

    $sql = 'INSERT INTO `Owner` (`Name`, `Telephone`, `Email`, `IdentificationNumber`, `Address`) VALUES (:Name, :Telephone, :Email, :IdentificationNumber, :Address)';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Name', $data['Name']);
    $stmt->bindParam(':Telephone', $data['Telephone']);
    $stmt->bindParam(':Email', $data['Email']);
    $stmt->bindParam(':IdentificationNumber', $data['IdentificationNumber']);
    $stmt->bindParam(':Address', $data['Address']);
    return $stmt->execute();
  }

  function updateProperty($data) {
    global $conn;

    $sql = 'UPDATE `Property` SET `PropertyTypeId` = :PropertyTypeId, `OwnerId` = :OwnerId, `Number` = :Number, `Address` = :Address, `Area` = :Area, `ConstructionArea` = :ConstructionArea WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':PropertyTypeId', $data['PropertyTypeId']);
    $stmt->bindParam(':OwnerId', $data['OwnerId']);
    $stmt->bindParam(':Number', $data['Number']);
    $stmt->bindParam(':Address', $data['Address']);
    $stmt->bindParam(':Area', $data['Area']);
    $stmt->bindParam(':ConstructionArea', $data['ConstructionArea']);
    $stmt->bindParam(':id', $data['Id']);
    return $stmt->execute();
  }

  function updatePropertyType($data) {
    global $conn;

    $sql = 'UPDATE `PropertyType` SET `Description` = :description WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':description', $data['Description']);
    $stmt->bindParam(':id', $data['Id']);
    return $stmt->execute();
  }

  function updateOwner($data) {
    global $conn;

    $sql = 'UPDATE `Owner` SET `Name` = :Name, `Telephone` = :Telephone, `Email` = :Email, `IdentificationNumber` = :IdentificationNumber, `Address` = :Address WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':Name', $data['Name']);
    $stmt->bindParam(':Telephone', $data['Telephone']);
    $stmt->bindParam(':Email', $data['Email']);
    $stmt->bindParam(':IdentificationNumber', $data['IdentificationNumber']);
    $stmt->bindParam(':Address', $data['Address']);
    $stmt->bindParam(':id', $data['Id']);
    return $stmt->execute();
  }

  function deleteProperty($id) {
    global $conn;

    $sql = 'UPDATE `Property` SET `Deleted` = 1 WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
  }

  function deletePropertyType($id) {
    global $conn;

    $sql = 'UPDATE `PropertyType` SET `Deleted` = 1 WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
  }

  function deleteOwner($id) {
    global $conn;

    $sql = 'UPDATE `Owner` SET `Deleted` = 1 WHERE id = :id';
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);
    return $stmt->execute();
  }
?>