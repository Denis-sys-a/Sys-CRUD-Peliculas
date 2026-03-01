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

$cartelGuardado = trim((string) ($pelicula['cartel_url'] ?? ''));
$cartelSrc = '';

if ($cartelGuardado !== '') {
    if (filter_var($cartelGuardado, FILTER_VALIDATE_URL)) {
        $cartelSrc = $cartelGuardado;
    } else {
        $rutaRelativa = str_replace('\\', '/', $cartelGuardado);
        $rutaRelativa = preg_replace('#^\./#', '', $rutaRelativa);
        $rutaRelativa = ltrim($rutaRelativa, '/');

        $rutaFisica = __DIR__ . '/' . $rutaRelativa;
        if (is_file($rutaFisica)) {
            $cartelSrc = './' . $rutaRelativa;
        }
    }
}
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detalles de esta película</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/home.css">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 main-title">Detalle de la película</h1>
        <div class="app-shell detail-shell">
            <div>
                <a href="./" class="btn btn-outline-secondary mb-3">← Volver</a>
                <div class="row g-3 align-items-start">
                    <div class="col-md-8">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Título: <strong><?php echo htmlspecialchars($pelicula['titulo']); ?></strong></li>
                            <li class="list-group-item">Director: <strong><?php echo htmlspecialchars($pelicula['director']); ?></strong></li>
                            <li class="list-group-item">Género: <strong><?php echo htmlspecialchars($pelicula['genero']); ?></strong></li>
                            <li class="list-group-item">Año: <strong><?php echo $pelicula['anio_estreno']; ?></strong></li>
                            <li class="list-group-item">Duración: <strong><?php echo $pelicula['duracion_min']; ?> min</strong></li>
                            <li class="list-group-item">Clasificación: <strong><?php echo htmlspecialchars($pelicula['clasificacion']); ?></strong></li>
                            <li class="list-group-item">Sinopsis: <strong><?php echo htmlspecialchars($pelicula['sinopsis']); ?></strong></li>
                        </ul>
                    </div>
                    <div class="col-md-4 text-center">
                        <?php if ($cartelSrc !== ''): ?>
                            <img src="<?php echo htmlspecialchars($cartelSrc); ?>"
                                alt="Cartel de <?php echo htmlspecialchars($pelicula['titulo']); ?>"
                                class="img-fluid rounded shadow-sm"
                                style="max-height: 380px; object-fit: cover;" />
                        <?php else: ?>
                            <div class="border rounded p-4 text-muted bg-light">
                                Sin cartel disponible
                                <?php if ($cartelGuardado !== ''): ?>
                                    <div class="small mt-2">No se encontro la imagen guardada.</div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>