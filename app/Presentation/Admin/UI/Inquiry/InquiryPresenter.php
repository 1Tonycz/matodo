<?php

namespace App\Presentation\Admin\UI\Inquiry;

use App\Domain\Inquiry\InquiryFacade;
use App\Presentation\Admin\Forms\InquiryReplyFormFactory;
use App\Presentation\Admin\UI\BasePresenter;
use Nette\Application\UI\Form;

final class InquiryPresenter extends BasePresenter
{
    private ?object $respondInquiry = null;

    public function __construct(
        private InquiryFacade $inquiryFacade,
        private InquiryReplyFormFactory $replyFormFactory,
    )
    {}

    public function renderDefault(): void
    {
        // získání všech dotazů
        $this->template->inquiries = $this->inquiryFacade->getOrdered();

        // modal
        $this->template->respondInquiry = $this->respondInquiry;
    }

    public function handleRespond(int $id): void
    {
        try{
            $inquiry = $this->inquiryFacade->getById($id);
            $this->respondInquiry = $inquiry;

            $this['replyForm']->setDefaults([
                'id'    => $inquiry->id,
                'subject' => 'Odpověď na váš dotaz',
                'reply' => $inquiry->admin_respond ?? '',
            ]);

        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
            $this->redirect('this');
        }
    }

    protected function createComponentReplyForm(): Form
    {
        return $this->replyFormFactory->create([$this, 'replyFormSucceeded']);
    }

    public function replyFormSucceeded(Form $form, array $values): void
    {
        try {
            $this->inquiryFacade->respond(
                (int) $values['id'],
                $values['subject'],
                $values['reply']
            );

            $this->flashMessage('Odpověď byla uložena a odeslána.', 'success');

        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }

        $this->redirect('this');
    }

    public function handleDelete(int $id): void
    {
        try {
            $this->inquiryFacade->delete($id);
            $this->flashMessage('Dotaz byl smazán.', 'success');

        } catch (\RuntimeException $e) {
            $this->flashMessage($e->getMessage(), 'error');
        }

        $this->redirect('this');
    }
}
