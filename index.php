<?php
require_once __DIR__ . '/bootstrap.php';

$peliculaEditar = null;
if (isset($_GET['id'])) {
    $peliculaEditar = $peliculaController->getOne((int) $_GET['id']);
}

$peliculas = $peliculaController->getAll();
$totalPeliculas = $peliculaController->totalPeliculas();
?>
<!doctype html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CRUD de Peliculas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.1/css/dataTables.bootstrap5.css">
</head>
<body>
    <h1 class="text-center mt-5 mb-4 fw-bold">Sistema CRUD de Peliculas</h1>

    <div class="container app-shell">
        <div class="row justify-content-md-center">
            <div class="col-md-4 form-column">
                <?php include 'formulario.php'; ?>
            </div>
            <div class="col-md-8">
                <h2 class="text-center">Catalogo de peliculas geniales
                    <span class="float-end d-flex gap-2">
                        <a href="acciones/exportar.php?format=csv" class="btn btn-success" title="Exportar CSV"><i class="bi bi-filetype-csv"></i></a>
                        <a href="acciones/exportar.php?format=json" class="btn btn-dark" title="Exportar JSON"><i class="bi bi-filetype-json"></i></a>
                    </span>
                </h2>
                <hr>
                <?php echo "Total de películas: <strong>{$totalPeliculas}</strong>"; ?>
                <?php include 'peliculas.php'; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="assets/home.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.1/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            $("#table_peliculas").DataTable({
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json",
                };
            });
        });
    </script>
</body>
</html>