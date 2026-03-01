<?php
require_once __DIR__ . '/../bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../');
    exit;
}

$ok = $peliculaController->create($_POST, $_FILES);
if ($ok) {
    header('location:../');
    exit;
}
echo 'Error al crear la película.';