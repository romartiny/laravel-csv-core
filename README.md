# Laravel CSV Parser Documentation
## Introduction
Laravel CSV Parser is a tool designed to simplify the process of importing CSV data into your Laravel application's database. It provides a convenient Artisan command php artisan app:csv-import to facilitate this task.

## Installation
Clone the repository
```bash
git clone https://github.com/romartiny/laravel-csv-core.git
```
Switch to the repo folder
```bash
cd laravel-csv-core
```
Install all the dependencies using composer
```bash
composer install
```
Copy the example env file and make the required configuration changes in the .env file
```bash
cp .env.example .env
```
Run the database migrations (**Set the database connection in .env before migrating**)
```bash
php artisan migrate
```

## Run the application
Run the command to parse the csv and save it to database
```bash
php artisan app:csv-import path/to/csv
```

### Test Mode
**Adding the --test flag at the end of the command will run the import in test mode. In this mode, the data will be displayed but not saved to the database. This is useful for previewing the import results before committing them to the database.**
```php
--test
```
## Configuration
Adding data to env changes the conditionals in the application
```dotenv
CSV_CONDITION_MIN_COST=5
CSV_CONDITION_MAX_COST=1000
CSV_CONDITION_MIN_STOCK=10
CSV_CONDITION_DISCONTINUED=yes

CSV_FIELDS_COST=decProductCost
CSV_FIELDS_STOCK=intProductStock
```
