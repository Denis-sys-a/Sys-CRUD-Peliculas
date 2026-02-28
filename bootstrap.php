<?php

require_once __DIR__ . '/app/Core/DatabaseSingleton.php';
require_once __DIR__ . '/app/Repository/MovieRepositoryInterface.php';
require_once __DIR__ . '/app/Repository/MySqlMovieRepository.php';
require_once __DIR__ . '/app/Strategy/ExportStrategyInterface.php';
require_once __DIR__ . '/app/Strategy/CsvExportStrategy.php';
require_once __DIR__ . '/app/Strategy/JsonExportStrategy.php';
require_once __DIR__ . '/app/Controller/MovieController.php';

$config = require __DIR__ . '/config/config.php';
$database = DatabaseSingleton::getInstance($config);
$repository = new MySqlMovieRepository($database->getConnection());
$movieController = new MovieController($repository);