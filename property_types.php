<?php
  require 'db.php';

  $propertyTypes = getPropertyTypes();

  $html = '<div class="container">
              <h1 class="text-center">Tipos de Propiedad</h1>
                        
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPropertyTypeModal">
                  Agregar
                </button>
              </div>

              <div class="table-responsive">
                <table class="table table-striped table-hover mt-4">
                  <thead>
                    <tr>
                      <th width="95%">Descripción</th>
                      <th width="5%">Acción</th>
                    </tr>
                  </thead>
                  <tbody>';

  if (count($propertyTypes) == 0) {
    $html .= '<tr>
                <td colspan="2" class="text-center">No hay tipos de propiedad</td>
              </tr>';
    } else {
      foreach ($propertyTypes as $propertyType) {
        $html .= '
          <tr>
            <td>' . $propertyType['Description'] . '</td>
            <td>
              <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-expanded="false">
                  Acción
                </button>
                <ul class="dropdown-menu">
                  <li><button type="button" 
                    data-id="' . $propertyType['Id'] . '" 
                    data-description="' . $propertyType['Description'] . '"
                    class="dropdown-item editar_propiedad_tipo">Editar
                  </button></li>
                  <li><button type="button" data-id="' . $propertyType['Id'] . '" class="dropdown-item eliminar_propiedad_tipo">Eliminar</button></li>
                </ul>
              </div>
            </td>
          </tr>';
      }
    }

  $html .= '
        </tbody>
      </table>
    </div>
  </div>';


  //Modal para agregar tipo de propiedad
  $html .= '<div class="modal fade" id="addPropertyTypeModal" tabindex="-1" aria-labelledby="addPropertyTypeModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addPropertyTypeModalLabel">Tipo de Propiedad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="addPropertyTypeForm" class="needs-validation" novalidate>
                      <div class="mb-3">
                        <input type="hidden" name="id" id="id">
                        <label for="description" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="agregar_propiedad_tipo">Guardar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>';

  echo $html;
?>

<script>
  $('#agregar_propiedad_tipo').click(function(e) {
    e.preventDefault();
    
    var form = $('#addPropertyTypeForm');
    if (form[0].checkValidity() === false) {
      e.stopPropagation();
    } else {
      var data = $('#addPropertyTypeForm').serialize();

      $.ajax({
        url: 'addPropertyType.php',
        type: 'POST',
        data: data,
        success: function(data) {
          $('#addPropertyTypeModal').modal('hide');
          if (data = 'success') {
            let toasthtml = `
              <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
                <div id="toastMessage" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="toast-header">
                    <strong class="me-auto">Exito</strong><button type="button" onclick="reloadPropertyType();" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body">
                    Tipo de propiedad creada
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
              <div id="toastMessage" class="toast align-items-center text-bg-danger border-0t" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="me-auto">Error</strong><button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                  Ha ocurrido un error
                </div>
              </div>
            </div>`;
          $('#modalCcontent').html(toasthtml);
          let toastMessage = document.getElementById('toastMessage');
          let toast = bootstrap.Toast.getOrCreateInstance(toastMessage);

          toast.show();
        }
      });
    }

    form.addClass('was-validated');
  });

  $('.editar_propiedad_tipo').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    
    $('#addPropertyTypeForm')[0].reset();

    $('#id').val(id);

    var description = $(this).data('description');
    $('#description').val(description);


    $('#addPropertyTypeModal').modal('show');
  });

  $('.eliminar_propiedad_tipo').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    $.ajax({
      url: 'deletePropertyType.php',
      type: 'POST',
      data: { id: id },
      success: function(data) {
        if (data = 'success') {
          let toasthtml = `
            <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
              <div id="toastMessage" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="me-auto">Exito</strong><button type="button" onclick="reloadPropertyType();" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                  Tipo de propiedad eliminada
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

  function reloadPropertyType() {
    $.ajax({
      url: 'property_types.php',
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