# Laravel CSV Parser Documentation
## Introduction
Laravel CSV Parser is a tool designed to simplify the process of importing CSV data into your Laravel application's database. It provides a convenient Artisan command php artisan app:csv-import to facilitate this task.

## Important 
No off-the-shelf libraries for data parsing and validation were used in the implementation of this project. In the future, it is possible to add a simpler validation via https://packagist.org/packages/oshomo/csv-utils, but this library has many disadvantages. 3 libraries were found, but unfortunately they didn't work the way the application expects. If I had more time, it would be possible to implement new methods to save good and bad strings from CSV to temporary files, from where the iterator would read them and output them to the console. This would be better done for the application to be able to handle more than 140000 rows.

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
