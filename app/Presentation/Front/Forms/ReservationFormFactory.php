<?php

namespace App\Presentation\Front\Forms;

use Nette\Application\UI\Form;

final class ReservationFormFactory extends Form
{
    private const PICKUP_OPTIONS = [
        'pc'       => 'Bavaro / Punta Cana',
        'bayahibe' => 'Bayahibe',
        'jd'       => 'Juan Dolio',
    ];

    public function create(callable $onSuccess):Form
    {
        $form = new Form;
        $form->addHidden('token');
        $form->addHidden('trip_id');

        $form->addText('name', 'Jméno a příjmení')
            ->setRequired('Zadejte své jméno a příjmení.');

        $form->addEmail('email', 'Email')
            ->setRequired('Zadejte svůj email.');

        $form->addText('phone', 'Telefon')
            ->setRequired('Zadejte své telefonní číslo.');

        $form->addText('date', 'Datum výletu')
            ->setHtmlType('text')
            ->setHtmlAttribute('autocomplete', 'off')
            ->setHtmlAttribute('placeholder', 'Vyberte datum')
            ->setRequired('Vyberte datum výletu.');

        $form->addInteger('persons', 'Počet osob')
            ->setRequired('Zadejte počet osob.')
            ->addRule($form::MIN, 'Minimálně 1 osoba.', 1);

        $form->addRadioList('pickup', 'Místo vyzvednutí', self::PICKUP_OPTIONS)
            ->setRequired('Vyberte místo vyzvednutí.');

        $form->addTextArea('note', 'Poznámka a přesná lokace vyzvednutí')
            ->setHtmlAttribute('rows', 4)
            ->setHtmlAttribute('placeholder', 'Zadejte přesnou lokaci vyzvednutí.');

        $form->addSubmit('send', 'Odeslat rezervaci');
        $form->onSuccess[] = $onSuccess;

        return $form;
    }

}