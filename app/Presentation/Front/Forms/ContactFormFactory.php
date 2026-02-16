<?php

namespace App\Presentation\Front\Forms;

use Nette\Application\UI\Form;

final class ContactFormFactory
{
    public function create(callable $onSuccess): Form
    {
        $form = new Form;

        $form->addText('Name', 'Jméno')
            ->setRequired('Vyplňte jméno');

        $form->addText('Email', 'Email')
            ->setRequired('Vyplňte email')
            ->addRule($form::EMAIL, 'Email není ve správném formátu')
            ->setHtmlType('email');

        $form->addTextArea('Message', 'Zpráva')
            ->setRequired('Zprávu je nutné vyplnit')
            ->setHtmlAttribute('rows', 5);

        $form->addSubmit('Send', 'Odeslat');
        $form->onSuccess[] = $onSuccess;

        return $form;
    }

}