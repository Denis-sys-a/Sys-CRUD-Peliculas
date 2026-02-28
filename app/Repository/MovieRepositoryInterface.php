<?php

interface MovieRepositoryInterface
{
    public function create(array $movieData): bool;

    public function update(int $id, array $movieData): bool;

    public function delete(int $id): bool;

    public function findById(int $id): ?array;

    public function findAll(): array;

    public function countAll(): int;
}