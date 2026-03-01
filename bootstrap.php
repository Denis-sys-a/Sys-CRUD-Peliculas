<?php

require_once __DIR__ . '/app/Core/DatabaseSingleton.php';
require_once __DIR__ . '/app/Repository/PeliculaRepositoryInterface.php';
require_once __DIR__ . '/app/Repository/MySqlPeliculaRepository.php';
require_once __DIR__ . '/app/Strategy/ExportStrategyInterface.php';
require_once __DIR__ . '/app/Strategy/CsvExportStrategy.php';
require_once __DIR__ . '/app/Strategy/JsonExportStrategy.php';
require_once __DIR__ . '/app/Controller/PeliculaController.php';

$config = require __DIR__ . '/config/config.php';
$database = DatabaseSingleton::getInstance($config);
$repository = new MySqlPeliculaRepository($database->getConnection());
$peliculaController = new PeliculaController($repository);