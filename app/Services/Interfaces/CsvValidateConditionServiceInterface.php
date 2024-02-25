<?php

namespace App\Services\Interfaces;

interface CsvValidateConditionServiceInterface
{
    public function checkCsvConditions(array $csvRow): bool;
}
