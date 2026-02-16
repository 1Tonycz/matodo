<?php

namespace App\Domain\Trips;

use App\Infrastructure\Database\BaseRepository;

class TripViewsRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'trip_views';
    }
}