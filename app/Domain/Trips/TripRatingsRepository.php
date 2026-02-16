<?php

namespace App\Domain\Trips;

use App\Infrastructure\Database\BaseRepository;

class TripRatingsRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'trip_ratings';
    }
}