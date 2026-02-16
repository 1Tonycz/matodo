<?php

namespace App\Domain\Reservations;

use App\Infrastructure\Mail\MailService;
use App\Domain\Reservations\ReservationRepository;

class ReservationFacade
{
    public function __construct(
        private ReservationRepository $reservationRepository,
        private MailService $mailService,
    ) {}

    public function getOrdered()
    {
        return $this->reservationRepository
            ->getAll()
            ->order('created_at DESC');
    }

    public function getById(int $id)
    {
        return $this->reservationRepository->getById($id);
    }

    public function cancel(int $id): void
    {
        $this->reservationRepository->update($id, [
            'status' => 'canceled',
        ]);
    }

    public function confirm(int $id, string $time): void
    {
        $reservation = $this->reservationRepository->getById($id);

        if (!$reservation) {
            throw new \RuntimeException('Rezervace neexistuje.');
        }

        $this->reservationRepository->update($id, [
            'status' => 'confirm',
            'time'   => $time,
        ]);

        $params = [
            'name'        => $reservation->customer_name,
            'date'        => $reservation->date,
            'persons'     => $reservation->guests,
            'pickup'      => $reservation->pickup_point,
            'trip'        => $reservation->trip->title,
            'time'        => $time,
            'total_price' => $reservation->guests * $reservation->trip->price,
            'deposit'     => ($reservation->guests * $reservation->trip->price) * 0.10,
        ];

        $this->mailService->sendReservationConfirm(
            $reservation->customer_email,
            $params
        );
    }

    public function sendCustomEmail(int $id, string $subject, string $message): void
    {
        $reservation = $this->reservationRepository->getById($id);

        if (!$reservation) {
            throw new \RuntimeException('Rezervace neexistuje.');
        }

        $this->mailService->sendCustomEmail(
            $reservation->customer_email,
            $subject,
            ['message' => $message]
        );
    }

    //Front-end


}