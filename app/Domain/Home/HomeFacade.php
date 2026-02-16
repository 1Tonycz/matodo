<?php

namespace App\Domain\Home;

use App\Domain\Inquiry\InquiriesRepository;
use App\Domain\Reservations\ReservationRepository;
use App\Domain\Reservations\ReservationStartsRepository;
use App\Domain\Trips\TripsRepository;
use App\Domain\Trips\TripViewsRepository;
use Nette\Caching\Cache;
use Nette\Caching\Storage;

final class HomeFacade
{
    private Cache $cache;
    public function __construct(
        private InquiriesRepository         $inquiriesRepository,
        private TripsRepository             $tripsRepository,
        private ReservationRepository       $reservationsRepository,
        private TripViewsRepository         $tripViewsRepository,
        private ReservationStartsRepository $reservationStartsRepository,
        Storage $storage,
    )
    {
        $this->cache = new Cache($storage, 'dashboard');
    }

    public function getDashboardData(): array
    {
        return $this->cache->load('dashboard-data', function (&$dependencies) {

            // Expirace
            $dependencies[Cache::Expire] = '3 minutes';

            return $this->computeDashboardData();
        });
    }

    private function computeDashboardData(): array
    {
        return [
            'inquiries' => $this->getInquiryStats(),
            'reservations' => $this->getReservationStats(),
            'conversion' => $this->getConversionStats(),
            'abandoned' => $this->getAbandonedPercent(),
            'monthlyReservations' => $this->getReservationsByMonth(),
            'topTrips' => $this->getTopTrips(),
            'worstTrips' => $this->getWorstTrips(),
            'mostVisitedTrip' => $this->getMostVisitedTrip(),
            'profit' => $this->getTripsProfit(),
            'tripsCount' => $this->tripsRepository->getAll()->count(),
        ];
    }
    private function getInquiryStats(): array
    {
        return [
            'responded' => $this->inquiriesRepository->getAll()
                ->where('status', 'responded')->count(),

            'waiting' => $this->inquiriesRepository->getAll()
                ->where('status', 'waiting')->count(),
        ];
    }
    private function getReservationStats(): array
    {
        return [
            'confirmed' => $this->reservationsRepository->getAll()
                ->where('status', 'confirm')->count(),

            'pending' => $this->reservationsRepository->getAll()
                ->where('status', 'pending')->count(),
        ];
    }
    private function getConversionStats(): array
    {
        $views = $this->tripViewsRepository->getAll()->count();
        $confirmed = $this->reservationsRepository->getAll()
            ->where('status', 'confirm')->count();

        return [
            'views' => $views,
            'reservations' => $confirmed,
            'rate' => $views > 0 ? ($confirmed / $views) * 100 : 0,
        ];
    }
    private function getAbandonedPercent(): int
    {
        $false = $this->reservationStartsRepository->getAll()
            ->where('completed', false)->count();

        $true = $this->reservationStartsRepository->getAll()
            ->where('completed', true)->count();

        $total = $false + $true;

        return $total === 0 ? 0 : round(($false / $total) * 100);
    }
    private function getReservationsByMonth(): array
    {
        $months = [
            1 => 'Led', 2 => 'Úno', 3 => 'Bře', 4 => 'Dub',
            5 => 'Kvě', 6 => 'Čvn', 7 => 'Čvc', 8 => 'Srp',
            9 => 'Zář', 10 => 'Říj', 11 => 'Lis', 12 => 'Pro',
        ];

        $year = (int) date('Y');

        $rows = $this->reservationsRepository->getAll()
            ->select('MONTH(`date`) AS month, COUNT(*) AS cnt')
            ->where('YEAR(`date`) = ?', $year)
            ->where('status = ?', 'confirm')
            ->group('MONTH(`date`)');

        $result = [];
        foreach ($months as $abbr) {
            $result[$abbr] = 0;
        }

        foreach ($rows as $row) {
            $result[$months[(int) $row->month]] = (int) $row->cnt;
        }

        return $result;
    }
    private function getTopTrips(): array
    {
        $tops = $this->reservationsRepository->getAll()
            ->where('status', 'confirm')
            ->select('trip_id, COUNT(*) AS cnt')
            ->group('trip_id')
            ->order('cnt DESC')
            ->limit(3);

        $result = [];

        foreach ($tops as $top) {
            $result[] = (object) [
                'name' => $top->trip->title,
                'reservations' => (int) $top->cnt,
            ];
        }

        return $result;
    }
    private function getWorstTrips(): array
    {
        $worsts = $this->reservationsRepository->getAll()
            ->where('status', 'confirm')
            ->select('trip_id, COUNT(*) AS cnt')
            ->group('trip_id')
            ->order('cnt ASC')
            ->limit(3);

        $result = [];

        foreach ($worsts as $worst) {
            $result[] = (object) [
                'name' => $worst->trip->title,
                'reservations' => (int) $worst->cnt,
            ];
        }

        return $result;
    }
    private function getMostVisitedTrip(): ?object
    {
        $mostVisited = $this->tripViewsRepository->getAll()
            ->select('trip_id, COUNT(*) AS cnt')
            ->group('trip_id')
            ->order('cnt DESC')
            ->limit(1)
            ->fetch();

        if (!$mostVisited) {
            return null;
        }

        $confirmedReservations = $this->reservationsRepository
            ->getBy('trip_id', $mostVisited->trip_id)
            ->where('status', 'confirm')
            ->count();

        return (object) [
            'name' => $mostVisited->trip->title,
            'views' => (int) $mostVisited->cnt,
            'reservations' => (int) $confirmedReservations,
            'conversion' => $mostVisited->cnt > 0
                ? round(($confirmedReservations / $mostVisited->cnt) * 100)
                : 0,
        ];
    }
    private function getTripsProfit(): array
    {
        $allTrips = $this->tripsRepository->getAll();

        $result = [];

        foreach ($allTrips as $trip) {

            $reservationCount = $this->reservationsRepository
                ->getBy('trip_id', $trip->id)
                ->where('status', 'confirm')
                ->count();

            $revenue = $reservationCount * $trip->price;
            $costs = $reservationCount * $trip->cost;

            $result[] = (object) [
                'name' => $trip->title,
                'reservations' => $reservationCount,
                'revenue' => $revenue,
                'costs' => $costs,
                'profit' => $revenue - $costs,
            ];
        }

        return $result;
    }
}