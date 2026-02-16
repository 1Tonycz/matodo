<?php

namespace App\Infrastructure\Security;

use App\Domain\User\ProfilesRepository;
use Nette;
use Nette\Security\Authenticator;
use Nette\Security\SimpleIdentity;

class ProfilesAuthenticator implements Authenticator
{
    public function __construct(
        private ProfilesRepository $db
    ) {
    }

    public function authenticate(string $user, string $password): SimpleIdentity
    {
        $row = $this->db->getAll()->where('name', $user)->fetch();

        if (!$row) {
            throw new Nette\Security\AuthenticationException('Nesprávné přihlašovací údaje.');
        }

        if (!password_verify($password, $row->password)) {
            throw new Nette\Security\AuthenticationException('Nesprávné přihlašovací údaje.');
        }

        return new SimpleIdentity(
            $row->id,
            $row->role,
            ['name' => $row->name]
        );
    }
}
