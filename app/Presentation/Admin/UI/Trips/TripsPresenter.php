<?php

namespace App\Presentation\Admin\UI\Trips;

use App\Domain\Trips\TripFacade;
use App\Presentation\Admin\Forms\TripFormFactory;
use App\Presentation\Admin\Forms\ScheduleFormFactory;
use App\Domain\Trips\TripImageStorage;
use App\Presentation\Admin\UI\BasePresenter;
use Nette\Application\UI\Form;

final class TripsPresenter extends BasePresenter
{
    // Pro zobrazení modálních oken
    private bool $showTripModal = false;
    private bool $showScheduleModal = false;

    public function __construct(
        private TripFacade       $tripFacade,
        private TripImageStorage $tripImageStorage,
        private TripFormFactory  $tripFormFactory,
        private ScheduleFormFactory $scheduleFormFactory,
    ){}

    public function renderDefault(): void
    {
        //Načítání výletu a modály
        $this->template->trips = $this->tripFacade->getAllTrips();
        $this->template->showTripModal = $this->showTripModal;
        $this->template->showScheduleModal = $this->showScheduleModal;
    }

    public function handleNew(): void
    {
        //Zobrazení modálu
        $this->showTripModal = true;
        //Nastavení výchozích hodnot pro nový výlet
        $this['tripForm']->setDefaults([
            'price' => 0,
            'cost' => 0,
            'duration' => '2 hodiny',
            'groupSize' => 5,
        ]);
    }

    protected function createComponentTripForm(): Form
    {
        return $this->tripFormFactory->create([$this, 'tripFormSucceeded']);
    }

    public function tripFormSucceeded(Form $form, array $values): void
    {
        $id = (int) $values['id'];  // 0 = nový, >0 = editace
        $image = $values['image'];

        $imgFolder = null;
        $imgName   = null;

        // pokud editujeme, načteme si původní trip kvůli obrázku
        $trip = null;
        if ($id) {
            $trip = $this->tripFacade->getById($id);
            if (!$trip) {
                $this->flashMessage('Výlet nebyl nalezen.', 'error');
                $this->redirect('this');
                return;
            }
        }

        // Zpracování obrázků

        if ($image->isOk() && $image->isImage()) {

            // původní obrázek smazat
            if ($trip && $trip->img_folder && $trip->img_name) {
                $this->tripImageStorage->delete(
                    $trip->img_folder,
                    $trip->img_name
                );
            }

            [$imgFolder, $imgName] = $this->tripImageStorage->save($image);

        } elseif (!$id) {
            $this->flashMessage('Musíte nahrát obrázek k novému výletu.', 'error');
            $this->redirect('this');
        }

        // Zpracování JSON; sestavení pole $data pro uložení; insert/update;
        $this->tripFacade->saveTrip($values, $imgFolder, $imgName);

        $this->flashMessage($id ? 'Výlet byl upraven.' : 'Výlet byl vytvořen.', 'success');
        $this->redirect('this');
    }


    public function handleDelete(int $id): void
    {
        //Načtění ověření existence; smazaní obrázků poté z DB
        $trip = $this->tripFacade->getById($id);
        if ($trip) {
            $this->tripImageStorage->delete($trip->img_folder, $trip->img_name);
            $this->tripFacade->deleteTrip($id);
            $this->flashMessage('Výlet byl smazán.', 'success');
        } else {
            $this->flashMessage('Výlet nebyl nalezen.', 'error');
        }
        $this->redirect('this');
    }

    public function handleEdit(int $id): void
    {
        //Ověření existence
        $trip = $this->tripFacade->getById($id);
        if (!$trip) {
            $this->flashMessage('Výlet nebyl nalezen.', 'error');
            $this->redirect('this');
        }
        //Zobrazení modálu
        $this->showTripModal = true;
        //Načtění již uložených dat
        $this['tripForm']->setDefaults([
            'id'              => $trip->id,
            'price'           => $trip->price,
            'price_pc'        => $trip->price_pc,
            'price_jd'        => $trip->price_jd,
            'cost'            => $trip->cost,
            'title'           => $trip->title,
            'description'     => $trip->description,
            'full_description'=> $trip->full_description,
            'duration'        => $trip->duration,
            'groupSize'       => $trip->group_size,
            'location'        => $trip->location,
            'included'        => implode("\n", json_decode($trip->included, true) ?? []),
            'not_included'    => implode("\n", json_decode($trip->not_included, true) ?? []),
        ]);
    }

    public function handleAddSchedule(int $id): void
    {
        //Zobrazení modálu
        $this->showScheduleModal = true;
        $this['scheduleForm']->setDefaults([
            'trip_id' => $id,
            'max_guest' => 6,
        ]);
    }

    protected function createComponentScheduleForm(): Form
    {
        return $this->scheduleFormFactory->create([$this, 'scheduleFormSucceeded']);
    }

    public function scheduleFormSucceeded(Form $form, array $values): void
    {
        //Zpracování dat pro insert do DB
        $data = [
            'trip_id'        => $values['trip_id'],
            'date'           => $values['date']->format('Y-m-d'),
            'max_guest'    => $values['max_guest'],
            'available_spots'=> $values['max_guest'],
            'notes' => $values['notes'] !== '' ? $values['notes'] : null,
        ];

        $this->tripFacade->addSchedule($data);
        $this->flashMessage('Termín byl vytvořen.', 'success');
        $this->redirect('this');
    }
}