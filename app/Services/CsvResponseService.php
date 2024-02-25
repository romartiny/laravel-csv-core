<?php

namespace App\Services;

use App\Services\Interfaces\CsvResponseServiceInterface;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\ConsoleOutput;

class CsvResponseService implements CsvResponseServiceInterface
{
    /*
     * Title for the CSV processing result.
     */
    private string $responseTitle;

    /*
     * Title for the count of good rows in the CSV processing result.
     */
    private string $responseGoodRows;

    /*
     * Title for the count of skipped rows in the CSV processing result.
     */
    private string $responseSkippedRows;

    /*
     * Title for the count of total rows in the CSV processing result.
     */
    private string $responseTotalRows;

    /**
     * Constructor for the CsvResponse class.
     *
     * @param ConsoleOutput $_output        The ConsoleOutput instance
     */
    public function __construct(
        private readonly ConsoleOutput $_output
    )
    {
        $this->responseTitle = Config::get('csv.response.title');
        $this->responseGoodRows = Config::get('csv.response.good_rows');
        $this->responseSkippedRows = Config::get('csv.response.skipped_rows');
        $this->responseTotalRows = Config::get('csv.response.total_rows');
    }

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
            sprintf('<info>%s</info>', $this->responseTitle),
            '=====================',
            sprintf($this->responseGoodRows . '<info>%d</info>', $goodRowsCount),
            sprintf($this->responseSkippedRows . '<error>%d</error>', $skippedRowsCount),
            sprintf($this->responseTotalRows . '<info>%d</info>', $goodRowsCount + $skippedRowsCount),
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
        $this->_output->writeln("<error>$error</error>");
    }
}
