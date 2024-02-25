<?php

namespace App\Services;

use App\Services\Interfaces\CsvResponseServiceInterface;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class CsvResponseService implements CsvResponseServiceInterface
{
    /**
     * Constructor for the CsvResponse class.
     *
     * @param ConsoleOutput $_output        The ConsoleOutput instance
     */
    public function __construct(
        private readonly ConsoleOutput $_output
    ) {}

    /**
     * Render CSV table result.
     *
     * @param array $csvData            The CSV data to be rendered
     * @param array $header             An array containing the headers
     * @param bool $headerOption        A flag for table header
     * @return void
     */
    public function renderCsvTable(array $csvData, array $header, bool $headerOption = false): void
    {
        $table = new Table($this->_output);

        $headerOption && $table->setHeaders($header);

        foreach ($csvData as $row) {
            $table->addRow($row);
        }

        $table->render();
    }

    /**
     * Render CSV processing result.
     *
     * @param int $goodRowsCount            The number of valid rows
     * @param int $skippedRowsCount         The number of skipped rows
     * @return void
     */
    public function renderCsvResult(int $goodRowsCount, int $skippedRowsCount): void
    {
        $this->_output->writeln([
            '<info>CSV Processing Result</info>',
            '=====================',
            sprintf('Good rows: <info>%d</info>', $goodRowsCount),
            sprintf('Skipped rows: <error>%d</error>', $skippedRowsCount),
            sprintf('Total rows: <info>%d</info>', $goodRowsCount + $skippedRowsCount),
            '=====================',
        ]);
    }

    /**
     * Outputs a CSV error response.
     *
     * @param string $error         The error message to be displayed
     * @return void
     */
    public function csvErrorResponse(string $error): void
    {
        $this->_output->writeln("<error> $error </error>");
    }
}
