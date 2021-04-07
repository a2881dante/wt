<?php


namespace App\Helpers;


use League\Csv\Reader;

use App\Models\ZipCode;
use App\Repositories\ZipCodeRepository;

class CsvToDbHelper
{
    public function importCsvToDB($filename)
    {
        $str = file_get_contents($filename);
        $csv = Reader::createFromString( $str, 'r' );
        $csv->setHeaderOffset(0);

        $headerTitles = $csv->getHeader();
        $records = $csv->getRecords();

        foreach ($records as $record) {
            $data = [];
            foreach ($headerTitles as $value) {
                $data[$value] = self::formatData($value, $record[$value]);
            }
            ZipCode::updateOrCreate(['zip' => $data['zip']], $data);
        }
    }

    private function formatData($key, $value)
    {
        switch($key) {
            case 'zcta':
            case 'imprecise':
            case 'military':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'lat':
            case 'lng':
            case 'density':
                return floatval($value);
            case 'population':
                return intval($value);
            default:
                return $value;
        }
    }
}