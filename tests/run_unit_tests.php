<?php

declare(strict_types=1);

require_once __DIR__ . '/../app/Repository/PeliculaRepositoryInterface.php';
require_once __DIR__ . '/../app/Strategy/ExportStrategyInterface.php';
require_once __DIR__ . '/../app/Strategy/CsvExportStrategy.php';
require_once __DIR__ . '/../app/Strategy/JsonExportStrategy.php';
require_once __DIR__ . '/../app/Controller/PeliculaController.php';
require_once __DIR__ . '/Fakes/InMemoryPeliculaRepository.php';

function assertTrue(bool $condition, string $message): void
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

function assertSame(mixed $expected, mixed $actual, string $message): void
{
    if ($expected !== $actual) {
        throw new RuntimeException($message . " | esperado: " . var_export($expected, true) . " | actual: " . var_export($actual, true));
    }
}

function makeControllerWithOneMovie(): array
{
    $repo = new InMemoryPeliculaRepository();
    $repo->items[1] = [
        'id' => 1,
        'titulo' => 'Interstellar',
        'director' => 'Christopher Nolan',
        'genero' => 'Ciencia ficción',
        'anio_estreno' => 2014,
        'duracion_min' => 169,
        'clasificacion' => 'PG-13',
        'sinopsis' => 'Viaje espacial.',
        'cartel_url' => 'assets/img/interstellar.jpg',
    ];

    return [new PeliculaController($repo), $repo];
}

$tests = [];

$tests['create sanitiza y guarda'] = function (): void {
    [$controller, $repo] = makeControllerWithOneMovie();
    $ok = $controller->create([
        'titulo' => '  Dune  ',
        'director' => ' Denis Villeneuve ',
        'genero' => ' Ciencia ficción ',
        'anio_estreno' => '2021',
        'duracion_min' => '155',
        'clasificacion' => ' PG-13 ',
        'sinopsis' => ' Épica espacial ',
    ]);

    assertTrue($ok, 'create debía devolver true');
    assertSame('Dune', $repo->lastCreatedData['titulo'], 'titulo sanitizado incorrecto');
    assertSame(2021, $repo->lastCreatedData['anio_estreno'], 'anio incorrecto');
    assertSame('', $repo->lastCreatedData['cartel_url'], 'cartel_url inicial incorrecto');
};

$tests['update retorna false si id no existe'] = function (): void {
    $repo = new InMemoryPeliculaRepository();
    $controller = new PeliculaController($repo);
    $ok = $controller->update(999, [
        'titulo' => 'No existe',
        'director' => 'Nadie',
        'genero' => 'Drama',
        'anio_estreno' => 2020,
        'duracion_min' => 120,
        'clasificacion' => 'PG',
        'sinopsis' => 'Sinopsis',
    ]);

    assertTrue($ok === false, 'update debía devolver false para id inexistente');
};

$tests['update conserva cartel actual sin nuevo archivo'] = function (): void {
    [$controller, $repo] = makeControllerWithOneMovie();
    $ok = $controller->update(1, [
        'titulo' => 'Interstellar (edición)',
        'director' => 'Christopher Nolan',
        'genero' => 'Ciencia ficción',
        'anio_estreno' => 2014,
        'duracion_min' => 170,
        'clasificacion' => 'PG-13',
        'sinopsis' => 'Versión extendida.',
    ]);

    assertTrue($ok, 'update debía devolver true');
    assertSame('assets/img/interstellar.jpg', $repo->lastUpdatedData['cartel_url'], 'no conservó cartel actual');
};

$tests['operaciones get/delete/count delegan al repositorio'] = function (): void {
    [$controller, $repo] = makeControllerWithOneMovie();
    $all = $controller->getAll();
    $one = $controller->getOne(1);
    $count = $controller->totalPeliculas();
    $deleted = $controller->delete(1);

    assertSame(1, count($all), 'getAll devolvió cantidad incorrecta');
    assertSame('Interstellar', $one['titulo'], 'getOne devolvió película incorrecta');
    assertSame(1, $count, 'count incorrecto');
    assertTrue($deleted, 'delete debía devolver true');
    assertSame(1, $repo->lastDeletedId, 'id eliminado incorrecto');
};

$tests['export json produce cuerpo json válido'] = function (): void {
    [$controller] = makeControllerWithOneMovie();
    ob_start();
    $controller->export('json');
    $output = (string) ob_get_clean();
    $decoded = json_decode($output, true);

    assertTrue(is_array($decoded), 'json export no es válido');
    assertSame('Interstellar', $decoded[0]['titulo'], 'json export sin película esperada');
};

$tests['export csv produce cabecera y fila'] = function (): void {
    [$controller] = makeControllerWithOneMovie();
    ob_start();
    $controller->export('csv');
    $output = (string) ob_get_clean();

    assertTrue(str_contains($output, 'ID,Título,Director,Género'), 'csv sin cabecera esperada');
    assertTrue(str_contains($output, 'Interstellar'), 'csv sin fila esperada');
};

$passed = 0;
$failed = 0;
$results = [];

foreach ($tests as $name => $test) {
    try {
        $test();
        $results[] = "[OK] {$name}";
        $passed++;
    } catch (Throwable $e) {
        $results[] = "[FAIL] {$name}: {$e->getMessage()}";
        $failed++;
    }
}

foreach ($results as $line) {
    echo $line . PHP_EOL;
}

echo "\nResultado: {$passed} OK, {$failed} FAIL\n";

exit($failed > 0 ? 1 : 0);