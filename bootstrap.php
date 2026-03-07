<?php

require_once __DIR__ . '/app/Core/DatabaseSingleton.php';
require_once __DIR__ . '/app/Repository/PeliculaRepositoryInterface.php';
require_once __DIR__ . '/app/Repository/MySqlPeliculaRepository.php';
require_once __DIR__ . '/app/Strategy/ExportStrategyInterface.php';
require_once __DIR__ . '/app/Strategy/CsvExportStrategy.php';
require_once __DIR__ . '/app/Strategy/JsonExportStrategy.php';
require_once __DIR__ . '/app/Controller/PeliculaController.php';

$config = require __DIR__ . '/config/config.php';
$localConfigPath = __DIR__ . '/config/config.local.php';
if (file_exists($localConfigPath)) {
    $localConfig = require $localConfigPath;
    if (is_array($localConfig)) {
        $config = array_merge($config, $localConfig);
    }
}

try {
    $database = DatabaseSingleton::getInstance($config);
    $repository = new MySqlPeliculaRepository($database->getConnection());
    $peliculaController = new PeliculaController($repository);
} catch (RuntimeException $exception) {
    http_response_code(500);
    echo '<h2>Error de conexión a MySQL</h2>';
    echo '<p>' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>';
    echo '<p>Solución rápida: copia <code>config/config.local.example.php</code> como <code>config/config.local.php</code> y coloca tu contraseña real.</p>';
    exit;
}