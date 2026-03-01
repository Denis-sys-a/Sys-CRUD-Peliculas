# TareaCRUD

## Alumno: Giovanni Denis Jara Hilario :D

V Semestre

# CRUD de Películas (PHP + MySQL)

Un nuevo proyecto de CRUD simple sobre Peliculas pero esta vez aplicando patrones backend:

- **Repository**: Se aplica con con `MovieRepositoryInterface` (contrato) y `MySqlMovieRepository` (implementación concreta). El controlador `MovieController` no consulta SQL directamente: delega operaciones como `create`, `update`, `delete`, `findById` y `findAll` al repositorio. Esto separa la lógica de negocio de la persistencia y facilita cambiar la fuente de datos en el futuro (por ejemplo, otro motor o un repositorio mock para pruebas).

- **Singleton**: Se utiliza en (`DatabaseSingleton`) para garantizar que exista una sola instancia de conexion a MySQL durante la ejecucion de la aplicacion. Esto me ayuda mucho para evitar crear conexiones repetidas en cada endpoint (`acciones/`) y centraliza la configuracion de la BD desde `bootstrap.php`, donde se llama a `DatabaseSingleton:getInstance($config)`

- **Strategy**: Se usa para la exportación de películas con comportamientos intercambiables. `MovieController::export()` selecciona la estrategia según el formato solicitado y ejecuta la interfaz común `ExportStrategyInterface`. Las estrategias concretas `CsvExportStrategy` y `JsonExportStrategy` permiten cambiar la forma de exportar sin modificar el resto del flujo.

Ademas de las tres principales, tambien estan las siguientes:

- **DependencyInjection(Inyeccion de Dependencias)**: `MovieController` recibe `MovieRepositoryInterface` por constructor, en lugar de instanciar internamente `MySqlMovieRepository`. La razon es para reducir acoplamiento.

## Estructura

- **ArquitecturaPorCapas(estilo MVC pero simplificado)**:
- Por la estructura (`Controller`, `Repository`, y endpoints en `acciones/`, y vistas PHP separadas) sigue una **separación de responsabilidades por capas**, cercana a un MVC.
- `app/Controller`:logica de aplicacion.
- `app/Repository`: acceso a datos.
- `acciones/`: puntos de entrada HTTP.
- `index.php`: `formulario.php`, `peliculas.php`, `visualizar.php`: presentación.

## Base de datos

Importar `bd/bd.sql` para crear `bd_peliculas` con tabla `peliculas`.

## Ejecucion rápida

```bash
http://localhost/Sys-CRUD-Peliculas/
```
