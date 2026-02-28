<?php

class MovieController
{
    public function __construct(private MovieRepositoryInterface $repository)
    {
    }

    public function create(array $input): bool
    {
        return $this->repository->create($this->sanitizeInput($input));
    }

    public function update(int $id, array $input): bool
    {
        return $this->repository->update($id, $this->sanitizeInput($input));
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    public function getOne(int $id): ?array
    {
        return $this->repository->findById($id);
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function totalMovies(): int
    {
        return $this->repository->countAll();
    }

    public function export(string $format): void
    {
        $movies = $this->repository->findAll();
        $strategy = $this->resolveStrategy($format);
        $strategy->export($movies);
    }

    private function sanitizeInput(array $input): array
    {
        return [
            'titulo' => trim($input['titulo'] ?? ''),
            'director' => trim($input['director'] ?? ''),
            'genero' => trim($input['genero'] ?? ''),
            'anio_estreno' => (int) ($input['anio_estreno'] ?? 0),
            'duracion_min' => (int) ($input['duracion_min'] ?? 0),
            'clasificacion' => trim($input['clasificacion'] ?? ''),
            'sinopsis' => trim($input['sinopsis'] ?? ''),
        ];
    }

    private function resolveStrategy(string $format): ExportStrategyInterface
    {
        return strtolower($format) === 'json'
            ? new JsonExportStrategy()
            : new CsvExportStrategy();
    }
}