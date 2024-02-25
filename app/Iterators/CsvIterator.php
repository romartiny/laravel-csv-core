<?php

namespace App\Iterators;

use Iterator;
use ReturnTypeWillChange;

/**
 * Iterator for CSV Documents.
 *
 * @template T
 * @implements Iterator<int, T>
 */
class CsvIterator implements Iterator
{
    private $fileHandle;

    private int $position;

    /**
     * @var array|bool|null
     */
    private $currentRow = null;

    public array $headers;

    private array $fieldNames;

    /**
     * @see https://php.net/iterator.rewind
     * @return array|false
     */
    #[ReturnTypeWillChange]
    public function rewind(): array|bool
    {
        rewind($this->fileHandle);
        $this->position = 0;
        return $this->currentRow = fgetcsv($this->fileHandle);
    }

    /**
     * @see https://php.net/iterator.current
     * @return array|null
     */
    #[ReturnTypeWillChange]
    public function current(): ?array
    {
        if ($this->currentRow === false) {
            return null;
        }

        return $this->advance($this->currentRow, $this->fieldNames);
    }

    /**
     * @see https://php.net/iterator.key
     * @return int
     */
    #[ReturnTypeWillChange]
    public function key(): int
    {
        return $this->position;
    }

    /**
     * @see https://php.net/iterator.next
     * @return void
     */
    #[ReturnTypeWillChange]
    public function next(): void
    {
        $this->position++;
        $this->currentRow = fgetcsv($this->fileHandle);
    }

    /**
     * @see https://php.net/iterator.valid
     * @return bool
     */
    #[ReturnTypeWillChange]
    public function valid(): bool
    {
        return !feof($this->fileHandle) && $this->currentRow !== false;
    }

    /**
     * Constructs a CSV Iterator.
     *
     * @param string $csvPath            Path to CSV file
     * @param array $productFillable     Fillable data for keys
     */
    public function __construct(string $csvPath, array $productFillable)
    {
        $this->fileHandle = fopen($csvPath, 'r');
        $csvHeaders = fgetcsv($this->fileHandle);

        $this->fieldNames = $productFillable;
        $this->headers = $this->advance($csvHeaders, $productFillable);
    }

    /**
     * Destruct a CSV Iterator.
     *
     * @return void
     */
    public function __destruct()
    {
        fclose($this->fileHandle);
    }

    /**
     * Replacing standard keys with keys from the fillable model
     *
     * @param array $row
     * @param array|null $fieldNames
     * @return array
     */
    private function advance(array $row, array $fieldNames = null): array
    {
        if ($fieldNames === null) {
            return [];
        }

        $parsedRow = [];
        foreach ($fieldNames as $index => $header) {
            if (isset($row[$index])) {
                $parsedRow[$header] = $row[$index];
            } else {
                $parsedRow[$header] = '';
            }
        }
        return $parsedRow;
    }
}
