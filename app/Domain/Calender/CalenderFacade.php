<?php

namespace App\Domain\Calendar;

use App\Domain\Reservations\ReservationRepository;
use App\Domain\Transfer\TransferRepository;
use Nette\Utils\DateTime;

final class CalendarFacade
{
    public function __construct(
        private ReservationRepository $reservationRepository,
        private TransferRepository $transferRepository,
    ) {}

    public function getEvents(): array
    {
        $eventsByDate = [];

        $transfers = $this->transferRepository
            ->getAll()
            ->where('status', 'confirm');

        foreach ($transfers as $t) {
            $dateKey = is_string($t->pickup_date)
                ? $t->pickup_date
                : $t->pickup_date->format('Y-m-d');

            $eventsByDate[$dateKey][] = [
                'id'     => (int) $t->id,
                'type'   => 'transfer',
                'title'  => 'Transfer',
                'name'   => $t->customer_name,
                'time'   => $t->pickup_time?->format('%H:%I'),
            ];
        }

        $reservations = $this->reservationRepository
            ->getAll()
            ->where('status', 'confirm');

        foreach ($reservations as $r) {
            $dateKey = is_string($r->date)
                ? $r->date
                : $r->date->format('Y-m-d');

            $eventsByDate[$dateKey][] = [
                'id'     => (int) $r->id,
                'type'   => 'reservation',
                'title'  => $r->trip->title,
                'name'   => $r->customer_name,
            ];
        }

        return $eventsByDate;
    }

    public function getCurrentMonth(): DateTime
    {
        return new DateTime('today');
    }

    public function getReservation(int $id)
    {
        return $this->reservationRepository->getById($id) ?? throw new \RuntimeException('Rezervace neexistuje.');
    }

    public function getTransfer(int $id)
    {
        return $this->transferRepository->getById($id) ?? throw new \RuntimeException('Transfer neexistuje.');
    }
}