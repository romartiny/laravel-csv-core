<?php

namespace App\Services\Interfaces;

interface CsvServiceInterface
{
    public function storeCsvData(string $csvPath, string $testOption);
}
