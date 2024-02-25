<?php

namespace App\Providers;

use App\Repositories\CsvProductRepository;
use App\Repositories\Interfaces\CsvProductRepositoryInterface;
use App\Services\CsvResponseService;
use App\Services\CsvService;
use App\Services\CsvValidateConditionService;
use App\Services\CsvValidatorService;
use App\Services\Interfaces\CsvResponseServiceInterface;
use App\Services\Interfaces\CsvServiceInterface;
use App\Services\Interfaces\CsvValidateConditionServiceInterface;
use App\Services\Interfaces\CsvValidatorServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CsvServiceInterface::class, CsvService::class);
        $this->app->bind(CsvResponseServiceInterface::class, CsvResponseService::class);
        $this->app->bind(CsvServiceInterface::class, CsvService::class);
        $this->app->bind(CsvValidateConditionServiceInterface::class, CsvValidateConditionService::class);
        $this->app->bind(CsvValidatorServiceInterface::class, CsvValidatorService::class);
        $this->app->bind(CsvProductRepositoryInterface::class, CsvProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
