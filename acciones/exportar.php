<?php
require_once __DIR__ . '/../bootstrap.php';
$format = $_GET['format'] ?? 'csv';
$peliculaController->export($format);