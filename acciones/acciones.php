<?php
require_once __DIR__ . '/../bootstrap.php';
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../');
    exit;
}

$ok = $movieController->create($_POST);
if ($ok) {
    header('location:../');
    exit;
}
echo 'Error al crear la película.';