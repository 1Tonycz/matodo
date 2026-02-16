<?php

namespace App\Presentation\Admin\UI\Transfer;

use App\Domain\Transfer\TransferFacade;
use App\Presentation\Admin\Forms\TransferEmailFormFactory;
use App\Presentation\Admin\Forms\TransferConfirmFormFactory;
use App\Presentation\Admin\UI\BasePresenter;
use Nette\Application\UI\Form;

final class TransferPresenter extends BasePresenter
{
    public function __construct(
        private TransferFacade $transferFacade,
        private TransferEmailFormFactory $transferEmailFormFactory,
        private TransferConfirmFormFactory $transferConfirmFormFactory,
    ){}

    private bool $showTransferDetailModal = false;
    private bool $showEmailModal = false;

    private bool $showConfirmModal = false;

    private $emailTransferRow = null;

    private $confirmTransferRow = null;


    public function renderDefault(): void
    {
        // Získání statistik a seznamu transferů
        $this->template->stats = $this->transferFacade->getStats();;
        $this->template->transfers = $this->transferFacade->getTransfers();

        //Modály
        $this->template->showTransferDetailModal = $this->showTransferDetailModal;
        $this->template->showEmailModal = $this->showEmailModal;
        $this->template->emailTransfer = $this->emailTransferRow;
        $this->template->showConfirmModal = $this->showConfirmModal;
        $this->template->confirmTransfer = $this->confirmTransferRow;
    }

    public function handleDelete(int $id): void
    {
        try {
            $this->transferFacade->delete($id);
            $this->flashMessage('Transfer byl smazán.', 'success');
        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }

        $this->redirect('this');
    }
    public function handleConfirm(int $id): void
    {
        try{
            $reservation = $this->transferFacade->getById($id);
            $this->showConfirmModal    = true;
            $this->confirmTransferRow = $reservation;

            $this['transferConfirmForm']->setDefaults([
                'id'   => $reservation->id,
            ]);
        }catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }
    }

    public function handleEmail(int $id): void
    {
        try{
            $transfer = $this->transferFacade->getById($id);
            $this->showEmailModal   = true;
            $this->emailTransferRow = $transfer;

            $this['emailForm']->setDefaults([
                'id' => $transfer->id,
                'subject' => 'Transfer - ' . $transfer->customer_name,
            ]);
        }
        catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }
    }

    public function handleDetail(int $id): void
    {
        $this->showTransferDetailModal = true;
        $detail = $this->transferFacade->getById($id);
        $this->template->detail = $detail;

    }

    public function createComponentEmailForm(): Form
    {
        return $this->transferEmailFormFactory->create([$this, 'sendEmail']);
    }

    public function sendEmail(Form $form, array $values): void
    {
        try {
            $this->transferFacade->sendCustomEmail(
                (int) $values['id'],
                $values['subject'],
                $values['message']
            );

            $this->flashMessage('E-mail byl odeslán.', 'success');
        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }

        $this->redirect('this');
    }

    public function createComponentTransferConfirmForm(): Form
    {
        return $this->transferConfirmFormFactory->create([$this, 'confirmTransfer']);
    }

    public function confirmTransfer(Form $form, array $values): void
    {
        try {
            $this->transferFacade->confirm(
                (int) $values['id'],
                (float) $values['price']
            );

            $this->flashMessage('Transfer byl potvrzen.', 'success');
        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }

        $this->redirect('this');
    }

}