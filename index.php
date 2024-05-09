<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Property Web</title>

    <!-- Bootstrap CSS -->
    <link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="vendor/components/jquery/jquery.min.js"></script>
    <script src="vendor/twbs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary p-3 bg-dark border-bottom border-body" data-bs-theme="dark">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php">Property Web</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
          <div class="navbar-nav">
            <a class="nav-link active" aria-current="page" href="#" data-page="properties">Propiedades</a>
            <a class="nav-link" href="#" data-page="property_types">Tipos de Propiedad</a>
            <a class="nav-link" href="#" data-page="owners">Dueños</a>
          </div>
        </div>
      </div>
    </nav>
    <!-- Navbar -->

    <!-- Content -->
    <div class="container mt-5" id="content">
      <!-- Se cargan las vistas aqui -->
    </div>

    <div id="modalContent">
      <!-- Se cargan los modales aqui -->
    </div>

    <script>
      $(document).ready(function() {
        // Cargar la vista de propiedades por defecto
        $.ajax({
          url: 'properties.php',
          type: 'GET',
          success: function(data) {
            $('#content').html(data);
          },
        });

        // Cargar las vistas al hacer click en el navbar
        $('.nav-link').click(function(e) {
          e.preventDefault();

          $('.nav-link').removeClass('active');
          $(this).addClass('active');

          var page = $(this).data('page');

          $.ajax({
            url: page + '.php',
            type: 'GET',
            success: function(data) {
              $('#content').html(data);
            },
            error: function() {
              let toasthtml = `
                <div aria-live="polite" aria-atomic="true" class="d-flex justify-content-center align-items-center w-100">
                  <div id="toastMessage" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
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
        });
      });
    </script>
  </body>
</html>