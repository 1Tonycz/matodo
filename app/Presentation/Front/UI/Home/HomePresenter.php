<?php

namespace App\Presentation\Front\UI\Home;

use App\Domain\Inquiry\InquiryFacade;
use App\Domain\Transfer\TransferFacade;
use App\Domain\Trips\TripFacade;
use App\Infrastructure\Model\LogErrorModel;
use App\Presentation\Front\Forms\ContactFormFactory;
use App\Presentation\Front\Forms\TransferFormFactory;
use App\Presentation\Front\UI\BasePresenter;
use Nette\Application\UI\Form;

final class HomePresenter extends BasePresenter
{
    private bool $showTransferModal = false;

    protected string $temp = 'home';

    public function __construct(
        LogErrorModel $log,
        private ContactFormFactory $contactFormFactory,
        private TransferFormFactory $transferFormFactory,
        private InquiryFacade $inquiryFacade,
        private TransferFacade $transferFacade,
        private TripFacade $tripFacade,
    ) {
        parent::__construct($log);
    }

    public function renderDefault(): void
    {
        $this->template->canonicalUrl = $this->link('//Home:default');
        $this->template->trips = $this->tripFacade->getAllTrips();
        $this->template->showTransferModal = $this->showTransferModal;
    }

    protected function createComponentContactForm(): Form
    {
        return $this->contactFormFactory->create([$this, 'contactSuccess']);
    }

    public function contactSuccess(Form $form, array $values): void
    {
        try {
            $this->inquiryFacade->create(
                $values['Name'],
                $values['Email'],
                $values['Message']
            );

            $this->flashMessage('Děkujeme ozveme se Vám do 24h.', 'success');

        } catch (\Throwable $e) {
            $this->log->log(true, $e, $this->temp);
            $this->flashMessage('Něco se pokazilo, zkuste to prosím později.', 'danger');
        }

        $this->redirect('this');
    }

    protected function createComponentTransferForm(): Form
    {
        return $this->transferFormFactory->create([$this, 'transferSucceeded']);
    }

    public function transferSucceeded(Form $form, array $values): void
    {
        try {
            $this->transferFacade->create($values);

            $this->flashMessage('Děkujeme ozveme se Vám do 24h.', 'success');

        } catch (\Throwable $e) {
            $this->log->log(true, $e, $this->temp);
            $this->flashMessage('Něco se pokazilo, zkuste to prosím později.', 'danger');
        }

        $this->redirect('this');
    }

    public function handleTransfer(): void
    {
        $this->showTransferModal = true;
        $this->redrawControl('content');
    }
}