# TareaCRUD
Alumno: Giovanni Denis Jara Hilario :D
-------------
V Semestre
# CRUD de Películas (PHP + MySQL)

Proyecto CRUD simple de películas aplicando patrones backend:

- **Repository**: encapsula acceso a datos (`MySqlMovieRepository`).
- **Singleton**: una única conexión BD (`DatabaseSingleton`).
- **Strategy**: exportación intercambiable CSV/JSON (`CsvExportStrategy`, `JsonExportStrategy`).

## Estructura

- `app/Core`: clases base (Singleton de BD).
- `app/Repository`: contratos e implementación para datos de películas.
- `app/Strategy`: estrategias de exportación.
- `app/Controller`: lógica de aplicación.
- `acciones/`: endpoints de crear/actualizar/eliminar/exportar.

## Base de datos

Importa `bd/bd.sql` para crear `bd_peliculas` con tabla `peliculas`.

## Ejecución rápida

```bash
php -S 0.0.0.0:8000
```

Luego abre `http://localhost:8000`.# Sys-CRUD-Peliculas
