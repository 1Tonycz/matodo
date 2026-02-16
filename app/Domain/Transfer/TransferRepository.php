<?php

namespace App\Domain\Transfer;

use App\Infrastructure\Database\BaseRepository;

class TransferRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'transfer';
    }
}