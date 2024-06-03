GESTIÓN DE BIBLIOTECA
-------------------

Proyecto realizado con PHP 8.2, Yii2 Framework y base de datos MongoDB.

OBJETIVO
------------

API REST para administrar biblioteca virtual de libros y autores mediante endpoints CRUD utilizando JWT tokens para autenticación y autorización a los recursos.

REQUERIMIENTOS
------------

* Tener instalado mongodb
* Tener instalado PHP 7.4 o superior.

INSTALACIÓN
------------

### Instalación via Composer

Si no tiene Composer [Composer](https://getcomposer.org/), puede instalarlo siguiendo las instrucciones en [getcomposer.org](https://getcomposer.org/doc/00-intro.md#installation-nix).

Clona el proyecto del repositorio:

~~~
git clone https://github.com/HenryGye/biblioteca-ho.git
~~~

Ejecuta el comando:

~~~
composer install
~~~

Una vez terminado iniciar el proyecto ejecutando el comando:

~~~
php yii serve
~~~

CONFIGURACIÓN DEL PROYECTO
-------------

### Base de datos MongoDB

* Crear la base de datos `biblioteca_ho`.
* Crear el usuario de la base de datos (puede crear con otros datos si desea pero se debe configurar en el web.php):

```
db.createUser({
    user: "biblioteca_ho",
    pwd: "biblioteca_ho",
    roles: [
        { role: "readWrite", db: "biblioteca_ho" }
    ]
})
```

* Editar el archivo config\mongodb.php con el host y el puerto en la cadena de conexion a mongodb:

```php
return [
    'class' => '\yii\mongodb\Connection',
    'dsn' => 'mongodb://biblioteca_ho:biblioteca_ho@localhost:27017/biblioteca_ho',
];
```

* Cadena de conexión por defecto `mongodb://biblioteca_ho:biblioteca_ho@localhost:27017/biblioteca_ho`

* Crear coleccion libros y autores en mongodb:

```
db.createCollection('libros')
db.createCollection('autores')
```

* Crear los índices de las colecciones

Índice de libros
```
db.libros.createIndex({ "generos": 1 })
db.libros.createIndex({ "autores": 1 })
db.libros.createIndex({ "genero": 1, "autores": 1 })
db.libros.createIndex({ "anio_publicacion": 1 })
```

Índice de autores
```
db.autores.createIndex({ "nombre_completo": 1 })
db.autores.createIndex({ "nacionalidad": 1 })
db.autores.createIndex({ "nacionalidad": 1, "nombre_completo": 1 })
```

