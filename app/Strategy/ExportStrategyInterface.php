<?php

interface ExportStrategyInterface
{
    public function export(array $peliculas): void;
}