<?php
require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
    header('location:../');
    exit;
}

$ok = $peliculaController->update((int) $_POST['id'], $_POST, $_FILES);

if ($ok) {
    header('location:../');
    exit;
}

echo 'Error al actualizar la película.';