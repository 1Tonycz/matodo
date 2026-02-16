<?php

namespace App\Presentation\Admin\Forms;

use Nette\Application\UI\Form;

class TransferEmailFormFactory extends Form
{
    public function create(callable $onSuccess): Form
    {
        $form = new Form;
        $form->addHidden('id');
        $form->addText('subject', 'Předmět:')
            ->setRequired('Zadejte předmět e-mailu.');
        $form->addTextArea('message', 'Zpráva:')
            ->setRequired('Zadejte zprávu.');
        $form->addSubmit('send', 'Odeslat e-mail');
        $form->onSuccess[] = $onSuccess;
        return $form;
    }

}