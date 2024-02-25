<?php

namespace App\Services\Interfaces;

interface CsvServiceInterface
{
    public function processCsvData(string $csvPath, string $testOption);
}
