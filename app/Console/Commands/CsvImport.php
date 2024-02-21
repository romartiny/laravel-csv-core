<?php

namespace App\Console\Commands;

use App\Http\Controllers\CsvImportController;
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
     * @param CsvImportController $_csvImportController
     */
    public function __construct(
        private readonly CsvImportController $_csvImportController
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $csvPath = $this->argument('path');
        $testOption = $this->option('test');

        $this->_csvImportController->importCsv($csvPath, $testOption);
    }
}
