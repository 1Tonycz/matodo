<?php

namespace App\Presentation\Admin\Forms;

use Nette\Application\UI\Form;

class ReservationConfirmFormFactory
{
    public function create(callable $onSuccess): Form
    {
        $form = new Form;
        $form->addHidden('id');
        $form->addText('time', 'Čas vyzvednutí:')
            ->setHtmlType('time')
            ->setRequired('Zadejte čas vyzvednutí.');

        $form->addSubmit('send', 'Potvrdit rezervaci');
        $form->onSuccess[] = $onSuccess;
        return $form;
    }
}