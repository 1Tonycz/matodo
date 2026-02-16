<?php

namespace App\Presentation\Admin\UI;

use Nette\Application\UI\Presenter;

abstract class BasePresenter extends Presenter
{
    public function startup()
    {
        parent::startup();

        if (!$this->getUser()->isLoggedIn()) {
            $this->redirect(':Front:Home:default');
        }

        if (!$this->getUser()->isInRole('admin')) {
            $this->error('Nemáte oprávnění.');
        }
    }
}
