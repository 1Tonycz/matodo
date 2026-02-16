<?php

namespace App\Presentation\Front\UI\Auth;

use Nette;
use Nette\Application\UI\Form;
use Nette\Application\UI\Presenter;

final class AuthPresenter extends Presenter
{
    public function renderDefault(): void
    {
        $this->setLayout('admin');
    }
    public function createComponentSignInForm(): Form
    {
        $form = new Form;

        $form->addText('name', 'Uživatel:')
            ->setRequired('Zadejte uživatelské jméno.');

        $form->addPassword('password', 'Heslo:')
            ->setRequired('Zadejte heslo.');

        $form->addSubmit('send', 'Přihlásit');

        $form->onSuccess[] = [$this, 'signInFormSucceeded'];

        return $form;
    }

    public function signInFormSucceeded(Form $form, array $values): void
    {
        try {
            $this->getUser()->setExpiration('20 minutes', true);
            $this->getUser()->login($values['name'], $values['password']);
            $this->redirect(':Admin:Home:default');
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError($e->getMessage());
        }
    }

    public function actionOut(): void
    {
        $this->getUser()->logout();
        $this->flashMessage('Byl jste odhlášen.');
        $this->redirect('Home:default');
    }
}
