<?php

namespace App\Presentation\Front\Forms;

use Nette\Application\UI\Form;

final class TransferFormFactory extends Form
{
    public function create(callable $onSuccess): Form
    {
        $form = new Form;

        $form->addText('name', 'Jméno a příjmení')
            ->setRequired('Zadejte své jméno a příjmení.');

        $form->addEmail('email', 'Email')
            ->addRule($form::EMAIL, 'Zadejte platný email.')
            ->setRequired('Zadejte svůj email.');

        $form->addText('phone', 'Telefon')
            ->addRule($form::PATTERN, 'Zadejte platné telefonní číslo.', '\+?[0-9 ]{9,15}')
            ->setRequired('Zadejte své telefonní číslo.');

        $form->addInteger('passagers', 'Počet cestujících')
            ->setRequired('Zadejte počet cestujících.')
            ->addRule($form::MIN, 'Minimálně 1 cestující.', 1)
            ->addRule($form::MAX, 'Maximálně 6 cestujících.', 6);

        $form->addText('pickup', 'Místo vyzvednutí')
            ->setRequired('Zadejte místo vyzvednutí.');

        $form->addText('destination', 'Cíl cesty')
            ->setRequired('Zadejte cíl cesty.');

        $form->addText('date', 'Datum')
            ->setHtmlType('text')
            ->setHtmlAttribute('autocomplete', 'off')
            ->setHtmlAttribute('placeholder', 'Vyberte datum')
            ->setRequired('Vyberte datum.');

        $form->addTime('time', 'Čas vyzvednutí')
            ->setHtmlAttribute('placeholder', 'Vyberte čas')
            ->setRequired('Zadejte čas vyzvednutí.');

        $form->addTextArea('note', 'Poznámka');

        $form->addSubmit('send', 'Odeslat rezervaci');

        $form->onSuccess[] = $onSuccess;

        return $form;
    }

}