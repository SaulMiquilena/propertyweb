# propertyweb
Proyecto de gestión de propiedades

## Sobre el proyecto
Es una aplicación de una sola página (SPA), las prácticas empleadas en la aplicación, son separación de interes y modularidad.

Se sigue la estructura general de el patrón Modelo-Vista-Controlador (MVC), donde el marcado HTML representa la Vista, los archivos PHP (`properties.php`, `property_types.php`, `owners.php `) maneja la lógica y la recuperación de datos, y el código JavaScript maneja el comportamiento dinámico y la interacción con el servidor usando AJAX.

En el archivo `db.php` se encapsulan las operaciones de la base de datos dentro de funciones que proporcionan una interfaz para acceder y manipular datos.

En el archivo `propertyweb.sql` se encuentran las tablas para la base de datos llamada `propertyweb`, es una exportación de MySQL.

La estructura:

Modelo:
  - `db.php`
    
Vista:
  - `index.php`
  - `owners.php`
  - `property_types.php`
  - `properties.php`
    
Controlador:
  - `addOwner.php`
  - `deleteOwner.php`
  - `addPropertyType.php`
  - `deleteOwner.php`
  - `addProperty.php`
  - `deleteProperty.php`

## Demo del proyecto
Visita [https://propertyweb.saulmiquilena.xyz/](https://propertyweb.saulmiquilena.xyz/)

## Empezando
Para comenzar con este proyecto, sigue estos pasos:

1. Clona el repositorio:
  ```bash
  git clone https://github.com//SaulMiquilena/propertyweb.git
  ```

2. Instala las dependencias necesarias:
  ```bash
  composer install
  ```

3. Configura la base de datos:
  - Crea una nueva base de datos MySQL con nombre propertyweb.
  - Crea un nuevo usuario con las siguientes credenciales:
    - Nombre de usuario: propertyweb
    - Contraseña: propertyweb
  - Otorga los privilegios necesarios al usuario.

4. Crea las tablas en la base de datos:
  - Importa el archivo `propertyweb.sql` en la base de datos:
    ```bash
    mysql -u propertyweb -p propertyweb < propertyweb.sql
    ```

5. Ejecuta la aplicación:
  ```bash
  php -S localhost:8000 -t public
  ```

6. Abre tu navegador web y visita `http://localhost:8000` para acceder a la aplicación.

