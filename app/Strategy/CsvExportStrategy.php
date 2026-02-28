<?php

class CsvExportStrategy implements ExportStrategyInterface
{
    public function export(array $movies): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="peliculas_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Título', 'Director', 'Género', 'Año', 'Duración (min)', 'Clasificación', 'Sinopsis']);

        foreach ($movies as $movie) {
            fputcsv($output, [
                $movie['id'],
                $movie['titulo'],
                $movie['director'],
                $movie['genero'],
                $movie['anio_estreno'],
                $movie['duracion_min'],
                $movie['clasificacion'],
                $movie['sinopsis'],
            ]);
        }

        fclose($output);
    }
}