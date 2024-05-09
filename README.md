# propertyweb
Proyecto de gestión de propiedades

## Demo del proyecto
Visita `https://propertyweb.saulmiquilena.xyz/`

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

