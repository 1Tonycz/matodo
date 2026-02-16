<?php

namespace App\Domain\Trips;

use App\Domain\Reservations\ReservationStartsRepository;
use App\Domain\Trips\TripsRepository;
use App\Domain\Trips\TripSchedulesRepository;
use App\Domain\Trips\TripRatingsRepository;
use App\Domain\Reservations\ReservationRepository;
use App\Infrastructure\Mail\MailService;

class TripFacade
{
    public function __construct(
        private TripsRepository $tripsRepository,
        private TripSchedulesRepository $tripSchedulesRepository,
        private TripRatingsRepository $tripRatingsRepository,
        private TripViewsRepository $tripViewsRepository,
        private ReservationStartsRepository $reservationStartsRepository,
        private MailService $mailService,
        private ReservationRepository $reservationRepository,
    ) {
    }
    //Databázový operace

    //Využito ve Front i Admin modulu
    public function getAllTrips()
    {
        return $this->tripsRepository->getAll();
    }

    public function deleteTrip(int $id): void
    {
        $this->tripSchedulesRepository->getAll()->where(['trip_id' => $id])->delete();
        $this->tripRatingsRepository->getAll()->where(['trip_id' => $id])->delete();
        $this->tripViewsRepository->getAll()->where(['trip_id' => $id])->delete();
        $this->reservationStartsRepository->getAll()->where(['trip_id' => $id])->delete();
        $this->tripsRepository->delete($id);
    }

    public function addSchedule(array $data): void
    {
        $this->tripSchedulesRepository->insert($data);
    }

    public function getById(int $id)
    {
        return $this->tripsRepository->getById($id);
    }

    // tripFormSucceeded -> JSON; $Data; Update/Insert
    public function saveTrip(array $values, ?string $imgFolder, ?string $imgName): void
    {
        $id = (int) ($values['id'] ?? 0);

        // zpracování textů (včetně)
        $included = preg_split("/\\r\\n|\\r|\\n/", trim((string) $values['included']));
        $included = array_values(array_filter($included, fn($line) => trim($line) !== ''));
        // zpracování textů (neobshahuje)
        $excluded = preg_split("/\\r\\n|\\r|\\n/", trim((string) $values['not_included']));
        $excluded = array_values(array_filter($excluded, fn($line) => trim($line) !== ''));
        //
        $data = [
            'title'            => $values['title'],
            'description'      => $values['description'],
            'full_description' => $values['full_description'],
            'price'            => $values['price'],
            'price_pc'         => $values['price_pc'],
            'price_jd'         => $values['price_jd'],
            'cost'             => $values['cost'],
            'duration'         => $values['duration'],
            'group_size'       => $values['groupSize'],
            'location'         => $values['location'],
            'included'         => json_encode($included),
            'not_included'     => json_encode($excluded),
        ];


        if ($imgFolder !== null && $imgName !== null) {
            $data['img_folder'] = $imgFolder;
            $data['img_name']   = $imgName;
        }

        if ($id) {
            $this->tripsRepository->update($id, $data);
        } else {
            $this->tripsRepository->insert($data);
        }
    }
    //Front module
    public function getAllowedDates(int $id){
        $scheduleRows = $this->tripSchedulesRepository
            ->getBy('trip_id', $id)
            ->where('is_active', 1)
            ->where('available_spots > ?', 0)
            ->order('date ASC');

        $allowedDates = [];
        foreach ($scheduleRows as $row) {
            $d = $row->date;
            $allowedDates[] = $d instanceof \DateTimeInterface ? $d->format('Y-m-d') : (string) $d;
        }
        return $allowedDates;
    }

    public function viewLog(int $id): void
    {
        $this->tripViewsRepository->insert([
            'trip_id' => $id,
        ]);
    }

    public function viewReservationLog(int $id){
        $token = bin2hex(random_bytes(16));
        $this->reservationStartsRepository->insert([
            'token' => $token,
            'trip_id' => $id,
            'completed' => false,
        ]);
        return $token;
    }

    public function createReservation(array $values): void
    {
        try{
            $trip = $this->tripsRepository->getById($values['trip_id']);
            //Server-side ověření počtu osob
            $persons = (int) $values['persons'];
            if ($persons < 1) {
                throw new \RuntimeException('Počet osob musí být alespoň 1.');
            }
            // Server-side ověření termínu
            $allowed = $this->tripSchedulesRepository
                ->getBy('trip_id', $trip->id)
                ->where('is_active', 1)
                ->where('available_spots > ?', 0)
                ->where('date', $values['date'])
                ->fetch();

            if (!$allowed) {
                throw new \RuntimeException('Vybraný termín není k dispozici.');
            }

            $priceMap = [
                'pc'       => (int) $trip->price_pc,
                'bayahibe' => (int) $trip->price,
                'jd'       => (int) $trip->price_jd,
            ];

            $pickupKey = (string) $values['pickup'];
            $pricePerPerson = $priceMap[$pickupKey] ?? 0;
            $totalPrice = $pricePerPerson * $persons;

            $this->reservationRepository->insert([
                'trip_id' => $trip->id,
                'customer_name' => $values['name'],
                'customer_email' => $values['email'],
                'customer_phone' => $values['phone'],
                'date' => $values['date'],
                'guests' => $persons,
                'notes' => $values['note'],
                'status' => 'pending',
                'pickup_point' => $pickupKey,
                'price' => $totalPrice
            ]);
        }
        catch (\RuntimeException $e){

        }

        $dataSchedule = $this->tripSchedulesRepository->getAll()->where('trip_id', $trip->id)
            ->where('date', $values['date'])->fetch();

        $this->tripSchedulesRepository->getAll()->where('trip_id', $trip->id)
            ->where('date', $values['date'])
            ->update([
                'available_spots' => ($dataSchedule->available_spots - $persons),
            ]);

        $rSR = $this->reservationStartsRepository->getBy('token', $values['token'])->fetch();
        if (!$rSR) {
            throw new \RuntimeException('Neplatný token rezervace.');
        }

        $this->reservationStartsRepository->update($rSR->id, [
            'completed' => 1,
        ]);

        $params = [
            'customer_name' => $values['name'],
            'date' => $values['date'],
            'guests' => $persons,
            'trip_name' => $trip['title'],
            'trip_price' => $pricePerPerson,
            'total_price' => $totalPrice,
            'note' => $values['note'],
            'pickup_point' => $pickupKey,
        ];

        $this->mailService->sendReservationConfirmation($values['email'], $params);
    }
}