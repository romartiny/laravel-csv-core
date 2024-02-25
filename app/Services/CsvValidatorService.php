<?php

namespace App\Services;

use App\Services\Interfaces\CsvValidatorServiceInterface;

class CsvValidatorService implements CsvValidatorServiceInterface
{
    /**
     * Validates a CSV row against the header structure.
     *
     * @param array $headers        The array containing column headers
     * @param array $csvRow         The CSV row
     * @return bool                 Returns true if the CSV row passes validation, otherwise false
     */
    public function csvValidateRow(array $headers, array $csvRow): bool
    {
        if (count($csvRow) != count($headers)) return false;

        foreach ($csvRow as $rowData) {
            if (str_contains($rowData, ',') || str_contains($rowData, "\n") || str_contains($rowData, "\r")) {
                return false;
            }
        }

        return true;
    }
}
