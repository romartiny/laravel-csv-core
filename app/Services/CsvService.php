<?php

namespace App\Services;

use App\Repositories\Interfaces\CsvProductRepositoryInterface;
use App\Services\Interfaces\CsvResponseServiceInterface as CsvResponseInterface;
use App\Services\Interfaces\CsvValidateConditionServiceInterface as CsvValidateConditionInterface;
use App\Services\Interfaces\CsvValidatorServiceInterface as CsvValidatorInterface;
use App\Services\Interfaces\CsvServiceInterface;
use App\Iterators\CsvIterator;
use App\Models\Product;
use Exception;

class CsvService implements CsvServiceInterface
{
    /*
     * Array with good csv rows.
     */
    private array $goodCsvRows = [];

    /*
     * Array with skipped csv rows.
     */
    private array $skippedCsvRows = [];

    /*
     * Number of good csv rows.
     */
    private int $goodRowsCount = 0;

    /*
     * Number of skipped csv rows.
     */
    private int $skippedRowsCount = 0;

    /*
     * Headers for the table.
     */
    private array $headers;

    /**
     * Constructor for the CsvService class.
     *
     * @param CsvProductRepositoryInterface $_csvProductRepository          The CSV product repository
     * @param CsvResponseInterface $_csvResponse                            The CSV response service
     * @param CsvValidatorInterface $_csvValidator                          The CSV validator service
     * @param CsvValidateConditionInterface $_csvValidateCondition          The CSV validation condition service
     * @param Product $_product                                             The product model
     */
    public function __construct(
        private readonly CsvProductRepositoryInterface  $_csvProductRepository,
        private readonly CsvResponseInterface           $_csvResponse,
        private readonly CsvValidatorInterface          $_csvValidator,
        private readonly CsvValidateConditionInterface  $_csvValidateCondition,
        private readonly Product                        $_product
    ) {}

    /**
     * Checks if a row of data is valid based on provided headers and data.
     *
     * @param array $headers  The headers of the CSV file
     * @param array $data     The data of a single row
     * @return bool           Returns true if the row is valid
     */
    private function isValidRow(array $headers, array $data): bool
    {
        if ($headers === $data) {
            return true;
        }

        return $this->_csvValidateCondition->checkCsvConditions($data)
            && $this->_csvValidator->csvValidateRow($headers, $data);
    }

    /**
     * Renders the CSV response with CSV rows
     *
     * @return void
     */
    private function renderCsvResponse(): void
    {
        $this->_csvResponse->renderCsvTable($this->goodCsvRows, $this->headers, true);
        $this->_csvResponse->renderCsvTable($this->skippedCsvRows, $this->headers);
        $this->_csvResponse->renderCsvResult($this->goodRowsCount, $this->skippedRowsCount);
    }

    /**
     * Parses a single row and appends it to the target array.
     *
     * @param array $row            The row of data to be parsed
     * @param array $targetArray    The array to which the parsed row will be appended
     * @param int $counter          The counter to be incremented
     * @return void
     */
    private function parseRow(array $row, array &$targetArray, int &$counter): void
    {
        $targetArray[] = $row;
        $counter++;
    }

    /**
     * Checks a CSV row for validity and processes it accordingly.
     *
     * @param array $currentRow     The CSV row to be checked
     * @return void
     */
    private function checkCsvRows(array $currentRow): void
    {
        if ($currentRow === $this->headers) {
            return;
        }

        if ($this->isValidRow($this->headers, $currentRow)) {
            $this->parseRow($currentRow, $this->goodCsvRows, $this->goodRowsCount);
        } else {
            $this->parseRow($currentRow, $this->skippedCsvRows, $this->skippedRowsCount);
        }
    }

    /**
     * Saves the valid CSV rows to the product repository.
     *
     * @return void
     */
    private function saveValidCsvRows(): void
    {
        foreach ($this->goodCsvRows as $goodRow) {
            $this->_csvProductRepository->createProductRow($goodRow);
        }
    }

    /**
     * Stores CSV data from the given file path.
     *
     * @param string $csvPath       The file path of the CSV data
     * @param string $testOption    The test option flag
     * @return void
     * @throws Exception            If an error occurs
     */
    public function processCsvData(string $csvPath, string $testOption): void
    {
        try {
            $csvIterator = new CsvIterator($csvPath, $this->_product->getFillable());

            $this->headers = $csvIterator->headers;

            foreach ($csvIterator as $row) {
                $this->checkCsvRows($row);
            }

            if (!$testOption) {
                $this->saveValidCsvRows();
            }

            $this->renderCsvResponse();
        } catch (Exception $e) {
            $this->_csvResponse->csvErrorResponse($e->getMessage());
        }
    }
}
