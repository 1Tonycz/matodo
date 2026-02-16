<?php

namespace App\Domain\Inquiry;

use App\Infrastructure\Database\BaseRepository;

final class InquiriesRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'inquiries';
    }
}