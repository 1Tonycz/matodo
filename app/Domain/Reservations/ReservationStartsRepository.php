<?php

namespace App\Domain\Reservations;

use App\Infrastructure\Database\BaseRepository;

class ReservationStartsRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'reservation_starts';
    }
}