<?php
  require 'db.php';

  $owners = getOwners();

  $html = '<div class="container">
              <h1 class="text-center">Dueños de Propiedad</h1>
                        
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOwnerModal">
                  Agregar
                </button>
              </div>

              <div class="table-responsive">
                <table class="table table-striped table-hover mt-4">
                  <thead>
                    <tr>
                      <th>Nombre</th>
                      <th>Telefono</th>
                      <th>Email</th>
                      <th>Número de Identificación</th>
                      <th>Dirección</th>                    
                      <th width="5%">Acción</th>
                    </tr>
                  </thead>
                  <tbody>';

  if (count($owners) == 0) {
    $html .= '<tr>
                <td colspan="6" class="text-center">No hay dueños de propiedad</td>
              </tr>';
    } else {
      foreach ($owners as $owner) {
        $html .= '
          <tr>
            <td>' . $owner['Name'] . '</td>
            <td>' . $owner['Telephone'] . '</td>
            <td>' . $owner['Email'] . '</td>
            <td>' . $owner['IdentificationNumber'] . '</td>
            <td>' . $owner['Address'] . '</td>
            <td>
              <div class="dropdown">
                <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" data-boundary="window" aria-expanded="false">
                  Acción
                </button>
                <ul class="dropdown-menu">
                  <li><button type="button" 
                    data-id="' . $owner['Id'] . '" 
                    data-name="' . $owner['Name'] . '"
                    data-telephone="' . $owner['Telephone'] . '"
                    data-email="' . $owner['Email'] . '"
                    data-identificationnumber="' . $owner['IdentificationNumber'] . '"
                    data-address="' . $owner['Address'] . '"
                    class="dropdown-item editar_owner">Editar</button></li>
                  <li><button type="button" data-id="' . $owner['Id'] . '" class="dropdown-item eliminar_owner">Eliminar</button></li>
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


  //Modal para agregar dueño
  $html .= '<div class="modal fade" id="addOwnerModal" tabindex="-1" aria-labelledby="addOwnerModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="addOwnerModalLabel">Dueño de Propiedad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <form id="addOwnerForm" class="needs-validation" novalidate>
                      <div class="mb-3">
                        <input type="hidden" name="id" id="id">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                        <div class="invalid-feedback">
                          Por favor ingrese un nombre
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="phone" class="form-label">Telefono</label>
                        <input type="tel" class="form-control" id="telephone" name="telephone" pattern="[0-9]{9}" required>
                        <div class="invalid-feedback">
                          Por favor ingrese un telefono válido (9 dígitos)
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                        <div class="invalid-feedback">
                          Por favor ingrese un email
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="identificationNumber" class="form-label">Número de Identificación</label>
                        <input type="text" class="form-control" id="identificationNumber" name="identificationNumber" required>
                        <div class="invalid-feedback">
                          Por favor ingrese un número de identificación
                        </div>
                      </div>
                      <div class="mb-3">
                        <label for="address" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="address" name="address">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary" id="agregar_owner">Guardar</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>';

  echo $html;
?>

<script>
  $('#agregar_owner').click(function(e) {
    e.preventDefault();
    
    var form = $('#addOwnerForm');
    if (form[0].checkValidity() === false) {
      e.stopPropagation();
    } else {
      var data = $('#addOwnerForm').serialize();

      $.ajax({
        url: 'addOwner.php',
        type: 'POST',
        data: data,
        success: function(data) {
          $('#addOwnerModal').modal('hide');
          if (data = 'success') {
            let toasthtml = `
              <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
                <div id="toastMessage" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                  <div class="toast-header">
                    <strong class="me-auto">Exito</strong><button type="button" onclick="reloadOwner();" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                  </div>
                  <div class="toast-body">
                    Dueño creado
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
          $('#modalCcontent').html(toasthtml);
          let toastMessage = document.getElementById('toastMessage');
          let toast = bootstrap.Toast.getOrCreateInstance(toastMessage);

          toast.show();
        }
      });
    }

    form.addClass('was-validated');
  });

  $('.editar_owner').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');
    
    $('#addOwnerForm')[0].reset();

    $('#id').val(id);

    var name = $(this).data('name');
    var telephone = $(this).data('telephone');
    var email = $(this).data('email');
    var identificationNumber = $(this).data('identificationnumber');
    var address = $(this).data('address');

    $('#name').val(name);
    $('#telephone').val(telephone);
    $('#email').val(email);
    $('#identificationNumber').val(identificationNumber);
    $('#address').val(address);

    $('#addOwnerModal').modal('show');
  });

  $('.eliminar_owner').click(function(e) {
    e.preventDefault();
    var id = $(this).data('id');

    $.ajax({
      url: 'deleteOwner.php',
      type: 'POST',
      data: { id: id },
      success: function(data) {
        if (data = 'success') {
          let toasthtml = `
            <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
              <div id="toastMessage" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                  <strong class="me-auto">Exito</strong><button type="button" onclick="reloadOwner();" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                  Dueño eliminado
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

  function reloadOwner() {
    $.ajax({
      url: 'owners.php',
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