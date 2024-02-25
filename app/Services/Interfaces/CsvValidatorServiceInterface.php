<?php

namespace App\Services\Interfaces;

interface CsvValidatorServiceInterface
{
    public function csvValidateRow(array $headers, array $csvRow): bool;
}
