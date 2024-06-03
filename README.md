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

# API Endpoint Documentación

#### coleccion postman en raiz del proyecto `API REST Biblioteca PHP YII2.postman_collection.json`

## Endpoint: `/generate-token`

### Description

Este endpoint se utiliza para generar un token JWT (JSON Web Token) que se utilizará para la autenticación de las apis.

### Request

- **Method:** GET
- **URL:** `http://localhost:8080/generate-token`

### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJleHAiOjE3MTczOTEwMzl9.XC_gT7qLFxKmstCkGBQfYwlI_RblfAK_pm40UVH8vYg"
}

 ```

## Endpoint: `/libros`

### Description

Lista todos los libros de la base de datos.

### Request

- **Method:** GET
- **URL:** `http://localhost:8080/libros`
- **Authorization:** Bearer {token}
    

### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
[
    {
        "_id": {
            "$oid": "665c266f3e64593dbf08938a"
        },
        "titulo": "El nombre del viento",
        "autores": [
            {
                "_id": {
                    "$oid": "665c266f3e64593dbf08938b"
                },
                "nombre_completo": "Gabriel García Márquezaa4",
                "fecha_nacimiento": "1927-03-06",
                "nacionalidad": "Colombiano",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            },
            {
                "_id": {
                    "$oid": "665c266f3e64593dbf08938c"
                },
                "nombre_completo": "Gabriel García Márquezaa2",
                "fecha_nacimiento": "1927-03-06",
                "nacionalidad": "Colombiano",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            }
        ],
        "anio_publicacion": 2007,
        "generos": [
            "Fantasía"
        ],
        "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
        "isbn": "978-84-95922-77-8"
    },
    {
        "_id": {
            "$oid": "665c26903e64593dbf08938d"
        },
        "titulo": "El nombre del viento 2",
        "autores": [
            {
                "_id": {
                    "$oid": "665c26903e64593dbf08938e"
                },
                "nombre_completo": "Gabriel García Márquezaa44",
                "fecha_nacimiento": "1927-03-06",
                "nacionalidad": "Colombiano",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            },
            {
                "_id": {
                    "$oid": "665c26903e64593dbf08938f"
                },
                "nombre_completo": "Gabriel García Márquezaa21",
                "fecha_nacimiento": "1927-03-06",
                "nacionalidad": "Colombiano",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            }
        ],
        "anio_publicacion": 2008,
        "generos": [
            "Fantasía"
        ],
        "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
        "isbn": "978-84-95922-77-9"
    },
    {
        "_id": {
            "$oid": "665c26c33e64593dbf089390"
        },
        "titulo": "El nombre del viento 345",
        "autores": [
            {
                "_id": {
                    "$oid": "665c26c33e64593dbf089391"
                },
                "nombre_completo": "Gabriel García Márquezaa445",
                "fecha_nacimiento": "1500-03-06",
                "nacionalidad": "Peruana2",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            },
            {
                "_id": {
                    "$oid": "665c26c33e64593dbf089392"
                },
                "nombre_completo": "Gabriel García Márquezaa213",
                "fecha_nacimiento": "1927-03-06",
                "nacionalidad": "Ecuatorianawww",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            }
        ],
        "anio_publicacion": 2009,
        "generos": [
            "Fantasía",
            "Terror",
            "Novela"
        ],
        "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
        "isbn": "978-84-95922-77-13"
    }
]

 ```

## Endpoint: `/libros?autor=Gabriel García Márquezaa445&genero=Terror&anio=2009`

### Description

Lista los libros filtrado por autor, género o año de publicación

### Request

- **Method:** GET
- **URL:** `http://localhost:8080/libros?autor=Gabriel García Márquezaa445&genero=Terror&anio=2009`
- **Authorization:** Bearer {token}
    

### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
[
    {
        "_id": {
            "$oid": "665c26c33e64593dbf089390"
        },
        "titulo": "El nombre del viento 345",
        "autores": [
            {
                "_id": {
                    "$oid": "665c26c33e64593dbf089391"
                },
                "nombre_completo": "Gabriel García Márquezaa445",
                "fecha_nacimiento": "1500-03-06",
                "nacionalidad": "Peruana2",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            },
            {
                "_id": {
                    "$oid": "665c26c33e64593dbf089392"
                },
                "nombre_completo": "Gabriel García Márquezaa213",
                "fecha_nacimiento": "1927-03-06",
                "nacionalidad": "Ecuatorianawww",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            }
        ],
        "anio_publicacion": 2009,
        "generos": [
            "Fantasía",
            "Terror",
            "Novela"
        ],
        "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
        "isbn": "978-84-95922-77-13"
    }
]

 ```

## Endpoint: `/libros/665c266f3e64593dbf08938a`

### Description

Lista un libro por id.

### Request

- **Method:** GET
- **URL:** `http://localhost:8080/libros/665c266f3e64593dbf08938a`
- **Authorization:** Bearer {token}
    

### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
[
    {
        "_id": {
            "$oid": "665c266f3e64593dbf08938a"
        },
        "titulo": "El nombre del viento",
        "autores": [
            {
                "_id": {
                    "$oid": "665c266f3e64593dbf08938b"
                },
                "nombre_completo": "Gabriel García Márquezaa4",
                "fecha_nacimiento": "1927-03-06",
                "nacionalidad": "Colombiano",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            },
            {
                "_id": {
                    "$oid": "665c266f3e64593dbf08938c"
                },
                "nombre_completo": "Gabriel García Márquezaa2",
                "fecha_nacimiento": "1927-03-06",
                "nacionalidad": "Colombiano",
                "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
                "libros_publicados": [
                    "Cien años de soledad",
                    "El amor en los tiempos del cólera",
                    "Crónica de una muerte anunciada"
                ]
            }
        ],
        "anio_publicacion": 2007,
        "generos": [
            "Fantasía"
        ],
        "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
        "isbn": "978-84-95922-77-8"
    }
]

 ```

## Endpoint: `/libros`

### Description

Registra un libro.

### Request

- **Method:** POST
- **URL:** `http://localhost:8080/libros`
- **Authorization:** Bearer {token}
    
### Request

- **Content-Type:** application/json
- **Body:**


``` json
{
    "titulo": "El nombre del viento 123",
    "autores": [
        {
            "nombre_completo": "Gabriel García 123",
            "fecha_nacimiento": "1927-03-06",
            "nacionalidad": "Colombiano",
            "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
            "libros_publicados": ["Cien años de soledad", "El amor en los tiempos del cólera", "Crónica de una muerte anunciada"]
        },
        {
            "nombre_completo": "Gabriel García 456",
            "fecha_nacimiento": "1927-03-06",
            "nacionalidad": "Colombiano",
            "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
            "libros_publicados": ["Cien años de soledad", "El amor en los tiempos del cólera", "Crónica de una muerte anunciada"]
        }
    ],
    "anio_publicacion": 2009,
    "generos": ["Fantasía", "Terror"],
    "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
    "isbn": "978-84-95922-77-19"
}
```


### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
{
    "titulo": "El nombre del viento 123",
    "autores": [
        "665df3b1a853345b870afb06",
        "665df3b1a853345b870afb07"
    ],
    "anio_publicacion": 2009,
    "generos": [
        "Fantasía",
        "Terror"
    ],
    "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
    "isbn": "978-84-95922-77-19",
    "_id": "665df3b1a853345b870afb05"
}
 ```

## Endpoint: `/libros/665c26c33e64593dbf089390`

### Description

Actualiza un libro.

### Request

- **Method:** PUT
- **URL:** `http://localhost:8080/libros/665c26c33e64593dbf089390`
- **Authorization:** Bearer {token}
    
### Request

- **Content-Type:** application/json
- **Body:**


``` json
{
    "titulo": "El nombre del viento 345",
    "autores": [
        {
            "id": "665c26c33e64593dbf089391",
            "nombre_completo": "Gabriel García Márquezaa445",
            "fecha_nacimiento": "1500-03-06",
            "nacionalidad": "Peruana2",
            "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
            "libros_publicados": ["Cien años de soledad", "El amor en los tiempos del cólera", "Crónica de una muerte anunciada"]
        },
        {
            "id": "665c26c33e64593dbf089392",
            "nombre_completo": "Gabriel García Márquezaa213",
            "fecha_nacimiento": "1927-03-06",
            "nacionalidad": "Ecuatorianawww",
            "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
            "libros_publicados": ["Cien años de soledad", "El amor en los tiempos del cólera", "Crónica de una muerte anunciada"]
        }
    ],
    "anio_publicacion": 2009,
    "generos": ["Fantasía", "Terror", "Novela"],
    "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
    "isbn": "978-84-95922-77-13"
}
```


### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
{
    "_id": "665c26c33e64593dbf089390",
    "titulo": "El nombre del viento 345",
    "autores": [
        "665c26c33e64593dbf089391",
        "665c26c33e64593dbf089392"
    ],
    "anio_publicacion": 2009,
    "generos": [
        "Fantasía",
        "Terror",
        "Novela"
    ],
    "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
    "isbn": "978-84-95922-77-13"
}
 ```

## Endpoint: `/libros/665df3b1a853345b870afb05`

### Description

Elimina un libro.

### Request

- **Method:** DELETE
- **URL:** `http://localhost:8080/libros/665df3b1a853345b870afb05`
- **Authorization:** Bearer {token}
    

### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
{
    "_id": "665df3b1a853345b870afb05",
    "titulo": "El nombre del viento 123",
    "autores": [
        "665df3b1a853345b870afb06",
        "665df3b1a853345b870afb07"
    ],
    "anio_publicacion": 2009,
    "generos": [
        "Fantasía",
        "Terror"
    ],
    "descripcion": "La crónica del asesino de reyes es una trilogía de novelas de fantasía épica escrita por Patrick Rothfuss",
    "isbn": "978-84-95922-77-19"
}
 ```


## Endpoint: `/autores`

### Description

Lista todos los autores de la base de datos.

### Request

- **Method:** GET
- **URL:** `http://localhost:8080/autores`
- **Authorization:** Bearer {token}
    

### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
[
    {
        "_id": {
            "$oid": "665c266f3e64593dbf08938b"
        },
        "nombre_completo": "Gabriel García Márquezaa4",
        "fecha_nacimiento": "1927-03-06",
        "nacionalidad": "Colombiano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665c266f3e64593dbf08938c"
        },
        "nombre_completo": "Gabriel García Márquezaa2",
        "fecha_nacimiento": "1927-03-06",
        "nacionalidad": "Colombiano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665c26903e64593dbf08938e"
        },
        "nombre_completo": "Gabriel García Márquezaa44",
        "fecha_nacimiento": "1927-03-06",
        "nacionalidad": "Colombiano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665c26903e64593dbf08938f"
        },
        "nombre_completo": "Gabriel García Márquezaa21",
        "fecha_nacimiento": "1927-03-06",
        "nacionalidad": "Colombiano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665c26c33e64593dbf089391"
        },
        "nombre_completo": "Gabriel García Márquezaa445",
        "fecha_nacimiento": "1500-03-06",
        "nacionalidad": "Peruana2",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665c26c33e64593dbf089392"
        },
        "nombre_completo": "Gabriel García Márquezaa213",
        "fecha_nacimiento": "1927-03-06",
        "nacionalidad": "Ecuatorianawww",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665d388398505004bf05c872"
        },
        "nombre_completo": "Henry Ortiz",
        "fecha_nacimiento": "1996-06-27",
        "nacionalidad": "Ecuatoriano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665d3c4f98505004bf05c874"
        },
        "nombre_completo": "Henry Ortiz 3",
        "fecha_nacimiento": "1996-06-27",
        "nacionalidad": "Ecuatoriano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665df1aaa853345b870afb03"
        },
        "nombre_completo": "Gabriel García Márquezaa445ddd",
        "fecha_nacimiento": "1927-03-06",
        "nacionalidad": "Colombiano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665df1aaa853345b870afb04"
        },
        "nombre_completo": "Gabriel García Márquezaa213ddd",
        "fecha_nacimiento": "1927-03-06",
        "nacionalidad": "Colombiano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    }
]
 ```


## Endpoint: `/autores?nombre=gabriel&nacionalidad=ecuatoria`

### Description

Lista los autores filtrado por autor o nacionalidad.

### Request

- **Method:** GET
- **URL:** `http://localhost:8080/autores?nombre=gabriel&nacionalidad=ecuatoria`
- **Authorization:** Bearer {token}
    

### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
[
    {
        "_id": {
            "$oid": "665c26c33e64593dbf089392"
        },
        "nombre_completo": "Gabriel García Márquezaa213",
        "fecha_nacimiento": "1927-03-06",
        "nacionalidad": "Ecuatorianawww",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665d388398505004bf05c872"
        },
        "nombre_completo": "Henry Ortiz",
        "fecha_nacimiento": "1996-06-27",
        "nacionalidad": "Ecuatoriano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    },
    {
        "_id": {
            "$oid": "665d3c4f98505004bf05c874"
        },
        "nombre_completo": "Henry Ortiz 3",
        "fecha_nacimiento": "1996-06-27",
        "nacionalidad": "Ecuatoriano",
        "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
        "libros_publicados": [
            "Cien años de soledad",
            "El amor en los tiempos del cólera",
            "Crónica de una muerte anunciada"
        ]
    }
]
 ```


## Endpoint: `/autores/665d3c4f98505004bf05c874`

### Description

Lista un autor por id.

### Request

- **Method:** GET
- **URL:** `http://localhost:8080/autores/665d3c4f98505004bf05c874`
- **Authorization:** Bearer {token}
    

### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
{
    "_id": "665d3c4f98505004bf05c874",
    "nombre_completo": "Henry Ortiz 3",
    "fecha_nacimiento": "1996-06-27",
    "nacionalidad": "Ecuatoriano",
    "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
    "libros_publicados": [
        "Cien años de soledad",
        "El amor en los tiempos del cólera",
        "Crónica de una muerte anunciada"
    ]
}
 ```


## Endpoint: `/autores`

### Description

Registra un libro.

### Request

- **Method:** POST
- **URL:** `http://localhost:8080/autores`
- **Authorization:** Bearer {token}
    
### Request

- **Content-Type:** application/json
- **Body:**


``` json
{
    "nombre_completo": "Henry Ortiz 5",
    "fecha_nacimiento": "1996-06-27",
    "nacionalidad": "Ecuatoriano",
    "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
    "libros_publicados": ["Cien años de soledad", "El amor en los tiempos del cólera", "Crónica de una muerte anunciada"]
}
```


### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
{
    "nombre_completo": "Henry Ortiz 5",
    "fecha_nacimiento": "1996-06-27",
    "nacionalidad": "Ecuatoriano",
    "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
    "libros_publicados": [
        "Cien años de soledad",
        "El amor en los tiempos del cólera",
        "Crónica de una muerte anunciada"
    ],
    "_id": "665df7b9a853345b870afb08"
}
 ```


## Endpoint: `/autores/665df7b9a853345b870afb08`

### Description

Actualiza un autor.

### Request

- **Method:** PUT
- **URL:** `http://localhost:8080/autores/665df7b9a853345b870afb08`
- **Authorization:** Bearer {token}
    
### Request

- **Content-Type:** application/json
- **Body:**


``` json
{
    "nombre_completo": "Henry Ortiz 555",
    "fecha_nacimiento": "1996-06-27",
    "nacionalidad": "Ecuatoriano",
    "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
    "libros_publicados": ["Cien años de soledad", "El amor en los tiempos del cólera", "Crónica de una muerte anunciada"]
}
```


### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
{
    "_id": "665df7b9a853345b870afb08",
    "nombre_completo": "Henry Ortiz 555",
    "fecha_nacimiento": "1996-06-27",
    "nacionalidad": "Ecuatoriano",
    "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
    "libros_publicados": [
        "Cien años de soledad",
        "El amor en los tiempos del cólera",
        "Crónica de una muerte anunciada"
    ]
}
 ```


## Endpoint: `/autores/665df7b9a853345b870afb08`

### Description

Elimina un autor.

### Request

- **Method:** DELETE
- **URL:** `http://localhost:8080/autores/665df7b9a853345b870afb08`
- **Authorization:** Bearer {token}
    

### Response

- **Content-Type:** application/json
- **Body:**
    

``` json
{
    "_id": "665df7b9a853345b870afb08",
    "nombre_completo": "Henry Ortiz 555",
    "fecha_nacimiento": "1996-06-27",
    "nacionalidad": "Ecuatoriano",
    "biografia": "Gabriel José de la Concordia García Márquez fue un escritor, guionista, editor y periodista colombiano.",
    "libros_publicados": [
        "Cien años de soledad",
        "El amor en los tiempos del cólera",
        "Crónica de una muerte anunciada"
    ]
}
 ```