<?php

namespace App\Domain\Trips;

use App\Infrastructure\Database\BaseRepository;

class TripSchedulesRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'trip_schedules';
    }

    public function getAllAvailableForTrip(int $tripId)
    {
        return $this->getBy('trip_id', $tripId)
            ->where('is_active', 1)
            ->where('available_spots > ?', 0)
            ->order('date ASC');
    }
}