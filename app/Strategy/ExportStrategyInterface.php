<?php

interface ExportStrategyInterface
{
    public function export(array $movies): void;
}