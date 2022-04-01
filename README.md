# Slim PHP v4 - API REST

API RESTFUL con el framework [Slim PHP](https://www.slimframework.com).

API simple para administrar "clientes"

## :wrench: INSTALACIÓN RÁPIDA:

### Requerimientos:

- Git.
- Composer.
- PHP >= 8.0
- MySQL/MariaDB.

### Usando Git:

En su terminal ejecute estos comandos:

```bash
$ git clone https://github.com/fernandorzbs/slimv4-apirest && cd slimv4-apirest
$ cp .env.example .env
$ composer install
$ composer init-db
$ composer start
```


### Importar con POSTMAN:
Colección en postman está lista con todos los endpoints.


[![Run in Postman](https://run.pstmn.io/button.svg)](https://app.getpostman.com/run-collection/5285489-5d6ecca3-9d3b-44e6-a19e-0e59816bc6a2?action=collection%2Ffork&collection-url=entityId%3D5285489-5d6ecca3-9d3b-44e6-a19e-0e59816bc6a2%26entityType%3Dcollection%26workspaceId%3D920bcb4c-e64f-4f24-9696-eaae2a461673)

## :floppy_disk: ENDPOINTS:

#### INFO:

- Home: `GET /`

#### CLIENTES:
- Todos los clientes: `GET /clientes`
- Cliente por ID: `GET /clientes/{id}`
- Crear Cliente: `POST /clientes/add`
- Actualizar Cliente: `PUT /clientes/update/{id}`
- Eliminar Cliente: `DELETE /clientes/delete/{id}`


## :package: DEPENDENCIAS:

### LISTA DE DEPENDENCIAS REQUERIDAS:

- [slim/slim](https://github.com/slimphp/Slim): Micro framework PHP para APIs simples y potentes.
- [Slim-Psr7](https://github.com/slimphp/Slim-Psr7).
- [vlucas/phpdotenv](https://github.com/vlucas/phpdotenv): Carga las variables de entorno de `.env` a `getenv()`, `$_ENV` y `$_SERVER`.
- [firebase/php-jwt](https://github.com/firebase/php-jwt): Una biblioteca simple para codificar y decodificar JSON Web Tokens (JWT) en PHP.
- [selective/basepath](https://github.com/selective-php/basepath): Un detector de ruta base de URL para Slim 4.


## License
[MIT](https://choosealicense.com/licenses/mit/)