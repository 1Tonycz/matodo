<?php

namespace App\Presentation\Front\UI;

use App\Infrastructure\Model\LogErrorModel;
use App\Presentation\Front\Components\Footer\FooterControl;
use Nette\Application\UI\Presenter;

class BasePresenter extends Presenter
{
    protected LogErrorModel $log;

    public function __construct(LogErrorModel $log)
    {
        parent::__construct();
        $this->log = $log;
    }

    protected function getBasePath(): string
    {
        return __DIR__ . "/../../../www";
    }

    protected function createComponentFooter(): FooterControl
    {
        return new FooterControl();
    }

}
