<?php

namespace App\Presentation\Admin\Forms;

use Nette\Application\UI\Form;

final class InquiryReplyFormFactory extends Form
{
    public function create(callable $onSuccess): Form
    {
        $form = new Form;

        $form->addHidden('id');

        $form->addText('subject', 'Předmět:')
            ->setDefaultValue('Odpověď na váš dotaz')
            ->setRequired('Zadejte předmět.');

        $form->addTextArea('reply', 'Odpověď:')
            ->setRequired('Napište odpověď.');

        $form->addSubmit('send', 'Uložit odpověď');

        $form->onSuccess[] = $onSuccess;

        return $form;
    }

}