<?php

interface PeliculaRepositoryInterface
{
    public function create(array $peliculaData): bool;

    public function update(int $id, array $peliculaData): bool;

    public function delete(int $id): bool;

    public function findById(int $id): ?array;

    public function findAll(): array;

    public function countAll(): int;
}