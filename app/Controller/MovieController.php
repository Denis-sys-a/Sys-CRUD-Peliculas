<?php

class MovieController
{
    public function __construct(private MovieRepositoryInterface $repository)
    {
    }

    public function create(array $input, array $files = []): bool
    {
        $data = $this->sanitizeInput($input);
        $data['cartel_url'] = $this->resolvePosterPath($files['cartel_imagen'] ?? null, '');

        return $this->repository->create($data);
    }

    public function update(int $id, array $input, array $files = []): bool
    {
        $currentMovie = $this->repository->findById($id);
        if (!$currentMovie) {
            return false;
        }

        $data = $this->sanitizeInput($input);
        $currentPoster = (string) ($currentMovie['cartel_url'] ?? '');
        $data['cartel_url'] = $this->resolvePosterPath($files['cartel_imagen'] ?? null, $currentPoster);

        return $this->repository->update($id, $data);
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

    private function resolvePosterPath(?array $posterFile, string $currentPoster): string
    {
        if (!$posterFile || ($posterFile['error'] ?? UPLOAD_ERR_NO_FILE) === UPLOAD_ERR_NO_FILE) {
            return $currentPoster;
        }

        if (($posterFile['error'] ?? UPLOAD_ERR_OK) !== UPLOAD_ERR_OK) {
            return $currentPoster;
        }

        if (!is_uploaded_file($posterFile['tmp_name'] ?? '')) {
            return $currentPoster;
        }

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($posterFile['tmp_name']);
        $allowedTypes = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
        ];

        if (!isset($allowedTypes[$mimeType])) {
            return $currentPoster;
        }

        $targetDirectory = dirname(__DIR__, 2) . '/assets/img';
        if (!is_dir($targetDirectory)) {
            mkdir($targetDirectory, 0775, true);
        }

        $fileName = uniqid('cartel_', true) . '.' . $allowedTypes[$mimeType];
        $targetFilePath = $targetDirectory . '/' . $fileName;

        if (!move_uploaded_file($posterFile['tmp_name'], $targetFilePath)) {
            return $currentPoster;
        }

        return 'assets/img/' . $fileName;
    }

    private function resolveStrategy(string $format): ExportStrategyInterface
    {
        return strtolower($format) === 'json'
            ? new JsonExportStrategy()
            : new CsvExportStrategy();
    }
}