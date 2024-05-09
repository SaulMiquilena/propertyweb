<?php
  require_once 'db.php';

  $properties = getProperties();

  $html = '<div class="container">
            <h1 class="text-center">Propiedades</h1>
            
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyModal">
                Agregar
              </button>
            </div>

            <div class="table-responsive">
              <table class="table table-striped table-hover mt-4">
                <thead>
                  <tr>
                    <th>Tipo de Propiedad</th>
                    <th>Dueño</th>
                    <th>Número</th>
                    <th>Dirección</th>
                    <th>Área</th>
                    <th>Área de Construcción</th>
                    <th width="5%">Acción</th>
                  </tr>
                </thead>
                <tbody>';

  if (count($properties) == 0) {
    $html .= '<tr>
                <td colspan="7" class="text-center">No hay propiedades</td>
              </tr>';
  } else {
    foreach ($properties as $property) { 
      $propertyType = getPropertyType($property['PropertyTypeId']);
      $owner = getOwner($property['OwnerId']);
  
      $html .= '<tr>
                  <td>' . $propertyType['Description'] . '</td>
                  <td>' . $owner['Name'] . '</td>
                  <td>' . $property['Number'] . '</td>
                  <td>' . $property['Address'] . '</td>
                  <td>' . $property['Area'] . '</td>
                  <td>' . $property['ConstructionArea'] . '</td>
                  <td>
                    <div class="dropdown">
                      <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-expanded="false">
                        Acción
                      </button>
                      <ul class="dropdown-menu">
                        <li><button type="button" 
                          data-id="' . $property['Id'] . '" 
                          data-propertytype="' . $propertyType['Id'] . '" 
                          data-owner="' . $owner['Id'] . '"
                          data-number="' . $property['Number'] . '"
                          data-address="' . $property['Address'] . '"
                          data-area="' . $property['Area'] . '"
                          data-constructionarea="' . $property['ConstructionArea'] . '"
                          class="dropdown-item editar_propiedad">Editar</button></li>
                        <li><button type="button" data-id="' . $property['Id'] . '" class="dropdown-item eliminar_propiedad">Eliminar</button></li>
                      </ul>
                    </div>
                  </td>
                </tr>';
    }
  }

  $html .= '</tbody>
          </table>
        </div>
      </div>';

  //Modal para agregar propiedad
  $html .= '<div class="modal fade" id="addPropertyModal" tabindex="-1" aria-labelledby="addPropertyModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addPropertyModalLabel">Propiedad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="addPropertyForm" class="needs-validation" novalidate>
                      <div class="mb-3">
                        <input type="hidden" name="id" id="id">
                        <label for="propertyType" class="form-label">Tipo de Propiedad</label>
                        <select class="form-select" id="propertyType" name="PropertyTypeId" required>
                          <option value="">Seleccione un tipo de propiedad</option>';

  $propertyTypes = getPropertyTypes();
  foreach ($propertyTypes as $propertyType) {
    $html .= '<option value="' . $propertyType['Id'] . '">' . $propertyType['Description'] . '</option>';
  }

  $html .= '</select>
          </div>
          <div class="mb-3">
            <label for="owner" class="form-label">Dueño</label>
            <select class="form-select" id="owner" name="OwnerId" required>
              <option value="">Seleccione un dueño</option>';
  
  $owners = getOwners();
  foreach ($owners as $owner) {
    $html .= '<option value="' . $owner['Id'] . '">' . $owner['Name'] . '</option>';
  }

  $html .= '</select>
            </div>
            <div class="mb-3">
              <label for="number" class="form-label">Número</label>
              <input type="text" class="form-control" id="number" name="Number" required>
              <div class="invalid-feedback">Por favor ingrese un número válido.</div>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">Dirección</label>
              <input type="text" class="form-control" id="address" name="Address" required>
              <div class="invalid-feedback">Por favor ingrese una dirección válida.</div>
            </div>
            <div class="mb-3">
              <label for="area" class="form-label">Área</label>
              <input type="text" class="form-control" id="area" name="Area" required>
              <div class="invalid-feedback">Por favor ingrese un área válida.</div>
            </div>
            <div class="mb-3">
              <label for="constructionArea" class="form-label">Área de Construcción</label>
              <input type="text" class="form-control" id="constructionArea" name="ConstructionArea">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary" id="agregar_propiedad">Guardar</button>
        </div>
      </div>
    </div>
  </div>';

  echo $html;
?>

<script>
  $('#agregar_propiedad').click(function(e) {
    e.preventDefault();
    
    var form = $('#addPropertyForm');
    if (form[0].checkValidity() === false) {
      e.stopPropagation();
    } else {
      var data = $('#addPropertyForm').serialize();

      $.ajax({
        url: 'addProperty.php',
        type: 'POST',
        data: data,
        success: function(data) {
          $('#addPropertyModal').modal('hide');
          $('#addPropertyTypeModal').modal('hide');
          if (data = 'success') {
            let toasthtml = `
              <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
                <div id="toastMessage" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="toast-header">
                    <strong class="me-auto">Exito</strong><button type="button" onclick="reloadProperty();" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body">
                    Propiedad creada
                  </div>
                </div>
              </div>`;
            $('#modalContent').html(toasthtml);

          } else {
            let toasthtml = `
              <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
                <div id="toastMessage" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="toast-header">
                    <strong class="me-auto">Error</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body">
                    Ha ocurrido un error
                  </div>
                </div>
              </div>`;
            $('#modalContent').html(toasthtml);            
          }

          let toastMessage = document.getElementById('toastMessage');
          let toast = bootstrap.Toast.getOrCreateInstance(toastMessage);

          toast.show();
        },
        error: function() {
          let toasthtml = `
            <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
              <div id="toastMessage" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="me-auto">Error</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                  Ha ocurrido un error
                </div>
              </div>
            </div>`;
          $('#content').html(toasthtml);
          const toastMessage = document.getElementById('toastMessage');
          const toast = bootstrap.Toast.getOrCreateInstance(toastMessage);

          toast.show();
        }
      });
    }

    form.addClass('was-validated');
  });

  $('.editar_propiedad').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    
    $('#addPropertyForm')[0].reset();

    $('#id').val(id);

    var propertyType = $(this).data('propertytype');
    var owner = $(this).data('owner');
    var number = $(this).data('number');
    var address = $(this).data('address');
    var area = $(this).data('area');
    var constructionArea = $(this).data('constructionarea');

    $('#propertyType').val(propertyType);
    $('#owner').val(owner);
    $('#number').val(number);
    $('#address').val(address);
    $('#area').val(area);
    $('#constructionArea').val(constructionArea);

    $('#addPropertyModal').modal('show');
  });

  $('.eliminar_propiedad').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    $.ajax({
      url: 'deleteProperty.php',
      type: 'POST',
      data: { id: id },
      success: function(data) {
        if (data = 'success') {
          let toasthtml = `
            <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
              <div id="toastMessage" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="me-auto">Exito</strong><button type="button" onclick="reloadProperty();" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                  Propiedad eliminada
                </div>
              </div>
            </div>`;
          $('#modalContent').html(toasthtml);
        } else {
          let toasthtml = `
            <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
              <div id="toastMessage" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="me-auto">Error</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                  Ha ocurrido un error
                </div>
              </div>
            </div>`;
          $('#modalContent').html(toasthtml);
        }

        let toastMessage = document.getElementById('toastMessage');
        let toast = bootstrap.Toast.getOrCreateInstance(toastMessage);

        toast.show();
      },
      error: function() {
        let toasthtml = `
          <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
            <div id="toastMessage" class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
              <div class="toast-header">
                <strong class="me-auto">Error</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
              </div>
              <div class="toast-body">
                Ha ocurrido un error
              </div>
            </div>
          </div>`;
        $('#modalContent').html(toasthtml);
        const toastMessage = document.getElementById('toastMessage');
        const toast = bootstrap.Toast.getOrCreateInstance(toastMessage);
        
        toast.show();
      }
    });
  });

  function reloadProperty() {
    $.ajax({
      url: 'properties.php',
      type: 'GET',
      success: function(data) {
        $('#content').html(data);
      },
    });
  }

  $(document).ready(function() {
    const dropdowns = document.querySelectorAll('.dropdown-toggle');
    const dropdown = [...dropdowns].map((dropdownToggleEl) => new bootstrap.Dropdown(dropdownToggleEl, {
      popperConfig(defaultBsPopperConfig) {
        return {...defaultBsPopperConfig, strategy: 'fixed' };
      }
    }));
  });
</script>
