<?php

namespace App\Services\Interfaces;

interface CsvResponseServiceInterface
{
    public function renderCsvTable(array $csvData, bool $headerOption, array $header);
    public function renderCsvResult(int $goodRowsCount, int $skippedRowsCount);
}
