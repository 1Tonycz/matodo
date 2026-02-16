<?php

namespace App\Domain\Inquiry;

use App\Infrastructure\Mail\MailService;

final class InquiryFacade
{
    public function __construct(
        private InquiriesRepository $inquiriesRepository,
        private MailService $mailService,
    ) {}

    public function getOrdered()
    {
        return $this->inquiriesRepository
            ->getAll()
            ->order('created_at DESC')
            ->fetchAll();
    }

    public function getById(int $id)
    {
        return $this->inquiriesRepository->getById($id)
            ?? throw new \RuntimeException('Dotaz nebyl nalezen.');
    }

    public function respond(int $id, string $subject, string $reply): void
    {
        $inquiry = $this->getById($id);

        if ($inquiry->status === 'responded') {
            throw new \RuntimeException('Na tento dotaz již byla odeslána odpověď.');
        }

        $this->inquiriesRepository->update($id, [
            'admin_respond' => $reply,
            'status'        => 'responded',
            'responded_at'  => new \DateTimeImmutable(),
        ]);

        $this->mailService->sendAdminRespond(
            $inquiry->email,
            $subject,
            [
                'message' => $inquiry->message,
                'respond' => $reply,
            ]
        );
    }

    public function delete(int $id): void
    {
        $this->getById($id);
        $this->inquiriesRepository->delete($id);
    }
    //Pro Front Module
    public function create(string $name, string $email, string $message): void
    {
        $this->inquiriesRepository->insert([
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'status' => 'waiting',
            'admin_respond' => null,
        ]);
    }
}