<?php

namespace App\Presentation\Admin\Forms;

use Nette\Application\UI\Form;

final class TransferConfirmFormFactory extends Form
{
    public function create(callable $onSuccess): Form
    {
        $form = new Form;
        $form->addHidden('id');
        $form->addFloat('price', 'Cena za transfer')
            ->setRequired('Zadejte částku transféru.');

        $form->addSubmit('send', 'Potvrdit transfer');
        $form->onSuccess[] = $onSuccess;
        return $form;
    }

}