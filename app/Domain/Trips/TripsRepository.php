<?php

namespace App\Domain\Trips;

use App\Infrastructure\Database\BaseRepository;

class TripsRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'trips';
    }


}