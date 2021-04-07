<?php

namespace App\Repositories;


use App\Models\ZipCode;

class ZipCodeRepository extends BaseRepository
{
    public function __construct(ZipCode $model)
    {
        parent::__construct($model);
    }

    public function getByCode($zipCode)
    {
        return $this->model
            ->where('zip', $zipCode)
            ->first();
    }

    public function getByCityPartname($cityPartname)
    {
        return $this->model
            ->where('city', 'like', "${cityPartname}%")
            ->get();
    }
}