<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class ZipCode extends Model
{
    protected $table = 'zip_codes';

    protected $fillable = [
        'id',
        'zip',
        'lat',
        'lng',
        'city',
        'state_id',
        'state_name',
        'zcta',
        'parent_zcta',
        'population',
        'density',
        'county_fips',
        'county_fips_all',
        'county_names_all',
        'county_name',
        'county_weights',
        'imprecise',
        'military',
        'timezone',
    ];

    public $timestamps = false;
}


