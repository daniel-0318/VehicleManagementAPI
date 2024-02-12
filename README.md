## README del proyecto Laravel

**Introducción:**

Este archivo contiene información esencial para configurar y ejecutar el proyecto Laravel.

**Requisitos:**

* PHP >= 8.1
* Composer
* Servidor web (Apache, Nginx, etc.)

**Instalación:**

1. Clonar el proyecto desde GitHub:

```
git clone https://github.com/daniel-0318/VehicleManagementAPI
```

2. Instalar las dependencias con Composer:

```
composer install
```

3. Crear la base de datos y configurar el archivo `.env` con la información de conexión.

**Migraciones:**

1. Ejecutar las migraciones para crear las tablas de la base de datos:

```
php artisan migrate
```

2. Si hay cambios en la estructura de las tablas, ejecutar:

```
php artisan migrate:refresh
```

**Seeds:**

1. Poblar la base de datos con datos de prueba (opcional):

```
php artisan db:seed
```

**Inicio de sesión:**

* Todos los usuarios creados con los seeds pueden iniciar sesión con la contraseña **"password"**.

**Servidor:**

1. Iniciar el servidor de desarrollo:

```
php artisan serve
```

2. Acceder a la API con la url base de: http://localhost:8000/api