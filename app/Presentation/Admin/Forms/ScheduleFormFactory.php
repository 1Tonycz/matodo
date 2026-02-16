<?php

namespace App\Presentation\Admin\Forms;

use Nette\Application\UI\Form;

final class ScheduleFormFactory extends Form
{
    public function create(callable $onSuccess): Form
    {
        $form = new Form;

        $form->addHidden('trip_id');

        $form->addDate('date', 'Datum')
            ->setRequired('Zadejte datum.');

        $form->addInteger('max_guest', 'Maximální počet hostů')
            ->setRequired('Zadejte maximální počet hostů.');

        $form->addText('notes', 'Poznámky');

        $form->addSubmit('send', 'Uložit Termín');

        $form->onSuccess[] = $onSuccess;

        return $form;
    }


}