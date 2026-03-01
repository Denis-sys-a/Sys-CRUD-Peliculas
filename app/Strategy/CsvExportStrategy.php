<?php

class CsvExportStrategy implements ExportStrategyInterface
{
    public function export(array $peliculas): void
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="peliculas_' . date('Y-m-d') . '.csv"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Título', 'Director', 'Género', 'Año', 'Duración (min)', 'Clasificación', 'Sinopsis', 'Cartel (ruta local)']);

        foreach ($peliculas as $pelicula) {
            fputcsv($output, [
                $pelicula['id'],
                $pelicula['titulo'],
                $pelicula['director'],
                $pelicula['genero'],
                $pelicula['anio_estreno'],
                $pelicula['duracion_min'],
                $pelicula['clasificacion'],
                $pelicula['sinopsis'],
                $pelicula['cartel_url'] ?? '',
            ]);
        }

        fclose($output);
    }
}