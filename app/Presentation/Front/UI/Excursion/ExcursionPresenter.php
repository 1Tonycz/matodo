<?php

namespace App\Presentation\Front\UI\Excursion;

use App\Domain\Reservations\ReservationFacade;
use App\Presentation\Front\Forms\ReservationFormFactory;
use App\Domain\Trips\TripFacade;
use App\Infrastructure\Mail\MailService;
use App\Presentation\Front\UI\BasePresenter;
use Nette\Application\UI\Form;
use Nette\Bridges\ApplicationLatte\Template;

/**
 * @property-read Template $template
 */
final class ExcursionPresenter extends BasePresenter
{
    private bool $showReservationModal = false;


    public function __construct(
        protected TripFacade $tripFacade,
        protected ReservationFacade $reservationFacade,
        protected ReservationFormFactory $reservationFormFactory,
    ) {
    }

    public function renderDefault(int $id): void
    {
        try{
            $trip = $this->tripFacade->getById($id);
            // ceny za osobu podle pickup z DB
            $priceMap = [
                'pc'       => (int) $trip->price_pc,
                'bayahibe' => (int) $trip->price,
                'jd'       => (int) $trip->price_jd,
            ];

            // dostupné termíny
            $allowedDates = $this->tripFacade->getAllowedDates($id);

        }
        catch (\RuntimeException $e){
            $this->error($e->getMessage());
        }


        $included = json_decode($trip->included, true) ?? [];
        $notIncluded = json_decode($trip->not_included, true) ?? [];

        $this->template->trip = $trip;
        $this->template->included = $included;
        $this->template->notIncluded = $notIncluded;

        $this->template->pickupPrices = $priceMap;
        $this->template->pickupPricesJson = json_encode($priceMap);

        $this->template->allowedDates = $allowedDates;
        $this->template->allowedDatesJson = json_encode($allowedDates);

        $this->template->showReservationModal = $this->showReservationModal;
        $this->template->canonicalUrl = $this->link('//Excursion:default', $id);

        // view log
        $this->tripFacade->viewLog($trip->id);
    }

    public function handleReservation(int $id): void
    {
        try{
            $trip = $this->tripFacade->getById($id);
            $this->showReservationModal = true;

            //vytvoří záznam a vratí použitý token
            $token = $this->tripFacade->viewReservationLog($id);

            $this['reservationForm']->setDefaults([
                'token'   => $token,
                'trip_id' => $trip->id,
                'persons' => 1,
                'pickup'  => 'pc',
            ]);

        }
        catch (\RuntimeException $e){
            $this->error($e->getMessage());

        }

        $this->redrawControl('content');
    }

    protected function createComponentReservationForm(): Form
    {
        return $this->reservationFormFactory->create([$this, 'reservationFormSucceeded']);
    }

    public function reservationFormSucceeded(Form $form, array $values): void
    {
        try {
            $this->tripFacade->createReservation($values);

            $this->flashMessage(
                'Rezervace byla odeslána, do 24 hodin se Vám ozveme.',
                'success'
            );

            $this->redirect('this');

        } catch (\RuntimeException $e) {
            $form->addError($e->getMessage());
        }
    }
}
