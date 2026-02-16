<?php

namespace App\Domain\Error;

use App\Infrastructure\Database\BaseRepository;

class ErrorRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'error';
    }
}