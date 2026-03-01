<?php

class MySqlPeliculaRepository implements PeliculaRepositoryInterface
{
    public function __construct(private mysqli $connection)
    {
    }

    public function create(array $peliculaData): bool
    {
        $sql = 'INSERT INTO peliculas (titulo, director, genero, anio_estreno, duracion_min, clasificacion, sinopsis, cartel_url)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param(
            'sssissss',
            $peliculaData['titulo'],
            $peliculaData['director'],
            $peliculaData['genero'],
            $peliculaData['anio_estreno'],
            $peliculaData['duracion_min'],
            $peliculaData['clasificacion'],
            $peliculaData['sinopsis'],
            $peliculaData['cartel_url']
        );

        return $stmt->execute();
    }

    public function update(int $id, array $peliculaData): bool
    {
        $sql = 'UPDATE peliculas
                SET titulo = ?, director = ?, genero = ?, anio_estreno = ?, duracion_min = ?, clasificacion = ?, sinopsis = ?, cartel_url = ?
                WHERE id = ?';
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param(
            'sssissssi',
            $peliculaData['titulo'],
            $peliculaData['director'],
            $peliculaData['genero'],
            $peliculaData['anio_estreno'],
            $peliculaData['duracion_min'],
            $peliculaData['clasificacion'],
            $peliculaData['sinopsis'],
            $peliculaData['cartel_url'],
            $id
        );

        return $stmt->execute();
    }

    public function delete(int $id): bool
    {
        $stmt = $this->connection->prepare('DELETE FROM peliculas WHERE id = ?');
        $stmt->bind_param('i', $id);

        return $stmt->execute();
    }

    public function findById(int $id): ?array
    {
        $stmt = $this->connection->prepare('SELECT * FROM peliculas WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        return $result ?: null;
    }

    public function findAll(): array
    {
        $result = $this->connection->query('SELECT * FROM peliculas ORDER BY id ASC');

        return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
    }

    public function countAll(): int
    {
        $result = $this->connection->query('SELECT COUNT(*) AS total FROM peliculas');
        $row = $result ? $result->fetch_assoc() : ['total' => 0];

        return (int) $row['total'];
    }
}