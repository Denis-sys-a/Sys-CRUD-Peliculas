<?php

declare(strict_types=1);

final class InMemoryPeliculaRepository implements PeliculaRepositoryInterface
{
    public array $items = [];
    public ?array $lastCreatedData = null;
    public ?array $lastUpdatedData = null;
    public ?int $lastUpdatedId = null;
    public ?int $lastDeletedId = null;

    public function create(array $peliculaData): bool
    {
        $this->lastCreatedData = $peliculaData;
        $nextId = empty($this->items) ? 1 : (max(array_keys($this->items)) + 1);
        $this->items[$nextId] = ['id' => $nextId] + $peliculaData;

        return true;
    }

    public function update(int $id, array $peliculaData): bool
    {
        $this->lastUpdatedId = $id;
        $this->lastUpdatedData = $peliculaData;

        if (!isset($this->items[$id])) {
            return false;
        }

        $this->items[$id] = ['id' => $id] + $peliculaData;

        return true;
    }

    public function delete(int $id): bool
    {
        $this->lastDeletedId = $id;

        if (!isset($this->items[$id])) {
            return false;
        }

        unset($this->items[$id]);

        return true;
    }

    public function findById(int $id): ?array
    {
        return $this->items[$id] ?? null;
    }

    public function findAll(): array
    {
        return array_values($this->items);
    }

    public function countAll(): int
    {
        return count($this->items);
    }
}