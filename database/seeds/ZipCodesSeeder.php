<?php

use Illuminate\Database\Seeder;

use App\Helpers\CsvToDbHelper;

class ZipCodesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CsvToDbHelper::importCsvToDB('database/files/uszips.csv');
    }
}
