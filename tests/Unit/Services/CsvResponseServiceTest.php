<?php

namespace Tests\Unit\Services;

use App\Services\CsvResponseService;
use Illuminate\Contracts\Console\Kernel;
use PHPUnit\Framework\MockObject\Exception;
use ReflectionClass;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Output\ConsoleOutput as SymfonyConsoleOutput;
use Illuminate\Support\Facades\Config;
use Symfony\Component\Console\Helper\Table;
use Tests\TestCase;

class CsvResponseServiceTest extends TestCase
{
    /**
     * Test CSV result response message.
     *
     * @throws Exception
     */
    public function test_render_csv_result(): void
    {
        // Mock ConsoleOutput
        $outputMock = $this->createMock(SymfonyConsoleOutput::class);
        $outputMock->expects($this->exactly(1))->method('writeln');

        // Mock Config facade
        Config::shouldReceive('get')->andReturn('Title', 'Good Rows: ', 'Skipped Rows: ', 'Total Rows: ');

        // Create instance of CsvResponseService
        $csvResponseService = new CsvResponseService($outputMock);

        // Call the method under test
        $csvResponseService->renderCsvResult(10, 5);
    }

    /**
     * Test CSV error response message.
     *
     * @throws Exception
     */
    public function test_csv_error_response(): void
    {
        // Mock ConsoleOutput
        $outputMock = $this->createMock(SymfonyConsoleOutput::class);
        $outputMock->expects($this->exactly(1))->method('writeln')->with('<error>Error message</error>');

        // Mock Config facade
        Config::shouldReceive('get')->andReturn('Title', 'Good Rows: ', 'Skipped Rows: ', 'Total Rows: ');

        // Create instance of CsvResponseService
        $csvResponseService = new CsvResponseService($outputMock);

        // Call the method under test
        $csvResponseService->csvErrorResponse('Error message');
    }
}
