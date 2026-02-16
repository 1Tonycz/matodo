<?php

namespace App\Domain\Transfer;

use App\Infrastructure\Mail\MailService;

class TransferFacade
{
    public function __construct(
        private TransferRepository $transferRepository,
        private MailService $mailService,
    ) {}

    public function getTransfers()
    {
        return $this->transferRepository->getAll();
    }

    public function getStats(): array
    {
        $all = $this->transferRepository->getAll();

        return [
            'total'     => $all->count(),
            'waiting'   => $all->where('status', 'pending')->count(),
            'confirmed' => $all->where('status', 'confirm')->count(),
        ];
    }

    public function getById(int $id)
    {
        return $this->transferRepository->getById($id);
    }

    public function delete(int $id): void
    {
        $transfer = $this->transferRepository->getById($id);

        if (!$transfer) {
            throw new \RuntimeException('Transfer neexistuje.');
        }

        $transfer->delete();
    }

    public function confirm(int $id, float $price): void
    {
        $transfer = $this->transferRepository->getById($id);

        if (!$transfer) {
            throw new \RuntimeException('Transfer neexistuje.');
        }

        $this->transferRepository->update($id, [
            'status' => 'confirm',
            'price'  => $price,
        ]);

        $params = [
            'name'      => $transfer->customer_name,
            'date'      => $transfer->pickup_date,
            'time'      => $transfer->pickup_time,
            'passagers' => $transfer->passagers,
            'pickup'    => $transfer->pickup_location,
            'dropoff'   => $transfer->dropoff_location,
            'price'     => $price,
        ];

        $this->mailService->sendTransferConfirm(
            $transfer->customer_email,
            $params
        );
    }

    public function sendCustomEmail(int $id, string $subject, string $message): void
    {
        $transfer = $this->transferRepository->getById($id);

        if (!$transfer) {
            throw new \RuntimeException('Transfer neexistuje.');
        }

        $this->mailService->sendCustomEmail(
            $transfer->customer_email,
            $subject,
            ['message' => $message]
        );
    }
    //Pro Front Module
    public function create(array $data): void
    {
        $this->transferRepository->insert([
            'customer_name' => $data['name'],
            'customer_email' => $data['email'],
            'customer_phone' => $data['phone'],
            'passagers' => $data['passagers'],
            'pickup_location' => $data['pickup'],
            'dropoff_location' => $data['destination'],
            'pickup_date' => $data['date'],
            'pickup_time' => $data['time']->format('H:i:s'),
            'note' => $data['note'],
            'status' => 'pending',
        ]);
    }
}