<?php

namespace App\Presentation\Admin\UI\Reservations;

use App\Domain\Reservations\ReservationFacade;
use App\Presentation\Admin\UI\BasePresenter;
use Nette\Application\UI\Form;
use App\Presentation\Admin\Forms\ReservationConfirmFormFactory;
use App\Presentation\Admin\Forms\ReservationEmailFormFactory;

final class ReservationsPresenter extends BasePresenter
{
    private bool $showConfirmModal = false;
    private bool $showEmailModal = false;
    private bool $showDetailModal = false;

    /** @var mixed|null */
    private $confirmReservationRow;

    /** @var mixed|null */
    private $emailReservationRow;

    /** @var mixed|null */
    private $detailReservationRow;

    public function __construct(
        private ReservationFacade $reservationFacade,
        private ReservationConfirmFormFactory $confirmFormFactory,
        private ReservationEmailFormFactory $emailFormFactory,
    ) {}

    public function renderDefault(): void
    {
        //Získání všech rezervací
        $this->template->reservations        = $this->reservationFacade->getOrdered();

        //Modály
        $this->template->showConfirmModal    = $this->showConfirmModal;
        $this->template->showEmailModal      = $this->showEmailModal;
        $this->template->showDetailModal     = $this->showDetailModal;

        $this->template->confirmReservation  = $this->confirmReservationRow;
        $this->template->emailReservation    = $this->emailReservationRow;
        $this->template->detailReservation   = $this->detailReservationRow;
    }

    public function handleEmail(int $id): void
    {
        try{
            $reservation = $this->reservationFacade->getById($id);
            $this->showEmailModal   = true;
            $this->emailReservationRow = $reservation;

            $this['emailForm']->setDefaults([
                'id' => $reservation->id,
                'subject' => 'Dotaz k Vaší rezervaci ' . $reservation->trip->title,
            ]);
        }
        catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
            $this->redirect('this');
        }
    }

    public function handleConfirm(int $id): void
    {
        try{
            $reservation = $this->reservationFacade->getById($id);

            $this->showConfirmModal    = true;
            $this->confirmReservationRow = $reservation;

            $this['reservationConfirmForm']->setDefaults([
                'id'   => $reservation->id,
                'time' => '09:00',
            ]);
        }
        catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
            $this->redirect('this');
        }
    }

    public function handleCancel(int $id): void
    {
        try {
            $this->reservationFacade->cancel($id);

            $this->flashMessage('Rezervace byla zrušena.', 'success');
        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }

        $this->redirect('this');
    }

    public function handleDetail(int $id): void
    {
        try {
            $reservation = $this->reservationFacade->getById($id);
            $this->showDetailModal   = true;
            $this->detailReservationRow = $reservation;
        }
        catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
            $this->redirect('this');
        }
    }

    public function createComponentReservationConfirmForm(): Form
    {
        return $this->confirmFormFactory->create([$this, 'confirmReservation']);
    }

    public function createComponentEmailForm(): Form
    {
        return $this->emailFormFactory->create([$this, 'sendEmail']);
    }

    public function confirmReservation(Form $form, array $values): void
    {
        try {
            $this->reservationFacade->confirm(
                (int) $values['id'],
                $values['time']
            );

            $this->flashMessage('Rezervace byla potvrzena.', 'success');
        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }

        $this->redirect('this');
    }

    public function sendEmail(Form $form, array $values): void
    {
        try {
            $this->reservationFacade->sendCustomEmail(
                (int) $values['id'],
                $values['subject'],
                $values['message']
            );

            $this->flashMessage('E-mail byl odeslán.', 'success');
        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }

        $this->redirect('this');
    }
}
