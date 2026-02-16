<?php

namespace App\Infrastructure\Model;

use App\Domain\Error\ErrorRepository;

final class LogErrorModel
{
    public function __construct(
        public ErrorRepository $errorRepository
    ){}
    public function log(bool $form,\Exception $e, string $temp): void
    {
        $this->errorRepository->insert([
            'Form' => $form,
            'Error' => $e->getMessage(),
            'Template' => $temp
        ]);
    }

}