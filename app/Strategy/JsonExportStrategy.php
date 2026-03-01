<?php

class JsonExportStrategy implements ExportStrategyInterface
{
    public function export(array $peliculas): void
    {
        header('Content-Type: application/json; charset=utf-8');
        header('Content-Disposition: attachment; filename="peliculas_' . date('Y-m-d') . '.json"');

        echo json_encode($peliculas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }
}