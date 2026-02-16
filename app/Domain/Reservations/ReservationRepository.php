<?php

namespace App\Domain\Reservations;

use App\Infrastructure\Database\BaseRepository;

class ReservationRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'reservation';
    }
}