<?php

namespace App\Presentation\Admin\UI\Calendar;

use App\Domain\Calendar\CalendarFacade;
use App\Presentation\Admin\UI\BasePresenter;

final class CalendarPresenter extends BasePresenter
{
    public function __construct(
        private CalendarFacade $calendarFacade,
    ) {}

    private bool $showDetailModal = false;
    private bool $showTransferDetailModal = false;

    private $detailReservationRow = null;
    private $detailTransferRow = null;

    public function renderDefault(): void
    {
        // Získání událostí pro kalendář
        $this->template->eventsByDate = $this->calendarFacade->getEvents();
        $this->template->currentMonth = $this->calendarFacade->getCurrentMonth();

        //Detail akce pro transfer i rezervaci
        $this->template->detailTransfer = $this->detailTransferRow;
        $this->template->detailReservation = $this->detailReservationRow;

        //modály
        $this->template->showTransferDetailModal = $this->showTransferDetailModal;
        $this->template->showDetailModal = $this->showDetailModal;
    }

    public function handleDetail(int $id): void
    {
        try {
            $this->detailReservationRow = $this->calendarFacade->getReservation($id);
            $this->showDetailModal = true;
        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }
    }

    public function handleTransferDetail(int $id): void
    {
        try {
            $this->detailTransferRow = $this->calendarFacade->getTransfer($id);
            $this->showTransferDetailModal = true;
        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }
    }
}