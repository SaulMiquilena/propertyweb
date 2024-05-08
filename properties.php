<?php
  require_once 'db.php';

  $properties = getProperties();

  $html = '<div class="container">
            <table class="table table-striped table-hover">
              <thead>
                <tr>
                  <th scope="col">Tipo de Propiedad</th>
                  <th scope="col">Dueño</th>
                  <th scope="col">Número</th>
                  <th scope="col">Dirección</th>
                  <th scope="col">Área</th>
                  <th scope="col">Área de Construcción</th>
                </tr>
              </thead>
              <tbody>';
  
  foreach ($properties as $property) {
    $propertyType = getPropertyType($property['PropertyTypeId']);
    $owner = getOwner($property['OwnerId']);

    $html .= '<tr>
                <td>' . $propertyType['Name'] . '</td>
                <td>' . $owner['Name'] . '</td>
                <td>' . $property['Number'] . '</td>
                <td>' . $property['Address'] . '</td>
                <td>' . $property['Area'] . '</td>
                <td>' . $property['ConstructionArea'] . '</td>
              </tr>';
  }

  $html .= '</tbody>
          </table>
        </div>';

  echo $html;
?>

