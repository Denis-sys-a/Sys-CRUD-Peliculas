<?php
require_once __DIR__ . '/bootstrap.php';

if (!isset($_GET['id'])) {
    header('location:./');
    exit;
}

$pelicula = $movieController->getOne((int) $_GET['id']);
if (!$pelicula) {
    header('location:./');
    exit;
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalle de película</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Detalle de la película</h1>
        <div class="card shadow-sm">
            <div class="card-body">
                <a href="./" class="btn btn-outline-secondary mb-3">← Volver</a>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Título: <strong><?php echo htmlspecialchars($pelicula['titulo']); ?></strong></li>
                    <li class="list-group-item">Director: <strong><?php echo htmlspecialchars($pelicula['director']); ?></strong></li>
                    <li class="list-group-item">Género: <strong><?php echo htmlspecialchars($pelicula['genero']); ?></strong></li>
                    <li class="list-group-item">Año: <strong><?php echo $pelicula['anio_estreno']; ?></strong></li>
                    <li class="list-group-item">Duración: <strong><?php echo $pelicula['duracion_min']; ?> min</strong></li>
                    <li class="list-group-item">Clasificación: <strong><?php echo $pelicula['clasificacion']; ?></strong></li>
                    <li class="list-group-item">Sinopsis: <strong><?php echo htmlspecialchars($pelicula['sinopsis']); ?></strong></li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>