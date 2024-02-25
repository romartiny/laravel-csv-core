<?php

namespace App\Console\Commands;

use App\Services\Interfaces\CsvServiceInterface;
use Exception;
use Illuminate\Console\Command;

class CsvImport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:csv-import
                            {path : Path to csv file}
                            {--test : Whether records should be saved to the database}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse the contents and then insert the data into a MySQL database table';

    /**
     * @param CsvServiceInterface $_csvService
     */
    public function __construct(
        private readonly CsvServiceInterface $_csvService
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @throws Exception
     */
    public function handle(): void
    {
        $csvPath = $this->argument('path');
        $testOption = $this->option('test');

        $this->_csvService->storeCsvData($csvPath, $testOption);
    }
}
