<?php

namespace App\Services\Interfaces;

interface CsvResponseServiceInterface
{
    public function renderCsvTable(array $csvData, array $header, bool $headerOption);
    public function renderCsvResult(int $goodRowsCount, int $skippedRowsCount);
    public function csvErrorResponse(string $error);
}
