<?php

namespace App\Domain\User;

use App\Infrastructure\Database\BaseRepository;

class ProfilesRepository extends BaseRepository
{

    protected function getTableName(): string
    {
        return 'profiles';
    }
}