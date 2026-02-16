<?php

namespace App\Presentation\Admin\UI\Home;

use App\Domain\Home\HomeFacade;
use App\Presentation\Admin\UI\BasePresenter;

final class HomePresenter extends BasePresenter
{
    public function __construct(
        private HomeFacade $homeFacade,
    ) {}

    public function renderDefault(): void
    {
        $data = $this->homeFacade->getDashboardData();

        // Inquiry
        $this->template->inquiriesCount = $data['inquiries']['responded'];
        $this->template->newInquiriesCount = $data['inquiries']['waiting'];

        // Trips
        $this->template->tripsCount = $data['tripsCount'];

        // Reservations
        $this->template->reservationsCount = $data['reservations']['confirmed'];
        $this->template->pendingReservationsCount = $data['reservations']['pending'];

        // Views
        $this->template->viewsCount = $data['conversion']['views'];

        // Conversion
        $this->template->conversionViews = $data['conversion']['views'];
        $this->template->conversionReservations = $data['conversion']['reservations'];
        $this->template->conversionRate = $data['conversion']['rate'];

        // Abandoned
        $this->template->abandonedPercent = $data['abandoned'];

        // Charts
        $this->template->reservationsByMonth = $data['monthlyReservations'];
        $this->template->topBestTrips = $data['topTrips'];
        $this->template->topWorstTrips = $data['worstTrips'];
        $this->template->mostVisitedTrip = $data['mostVisitedTrip'];
        $this->template->tripsProfit = $data['profit'];

        // Ratings (zatím null)
        $this->template->ratingsSummary = null;
    }
}