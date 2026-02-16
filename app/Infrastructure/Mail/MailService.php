<?php

namespace App\Infrastructure\Mail;

use Latte\Engine;
use Nette\Bridges\ApplicationLatte\LatteFactory;
use Nette\Mail\Mailer;
use Nette\Mail\Message;

final class MailService
{
    private Engine $latte;
    public function __construct(
        private Mailer $mailer,
        LatteFactory $latteFactory
    ){
        $this->latte = $latteFactory->create();
    }

    public function sendAdminRespond(string $to, string $subject, array $params): void
    {
        $html = $this->latte->renderToString(__DIR__ . '/Templates/AdminRespond.latte', $params);

        $mail = (new Message())
            ->setFrom('info@matodo.cz')
            ->addTo($to)
            ->addBcc('info@matodo.cz')
            ->setSubject($subject)
            ->setHtmlBody($html);
        $this->mailer->send($mail);
    }

    public function sendReservationConfirmation(string $to,  array $params): void
    {
        $html = $this->latte->renderToString(__DIR__ . '/Templates/ReservationConfirmation.latte', $params);

        $mail = (new Message())
            ->setFrom('info@matodo.cz')
            ->addTo($to)
            ->addBcc('info@matodo.cz')
            ->setSubject('Rekapiluce rezervace výletu')
            ->setHtmlBody($html);
        $this->mailer->send($mail);
    }

    public function sendReservationConfirm(string $to,  array $params): void
    {
        $html = $this->latte->renderToString(__DIR__ . '/Templates/ReservationConfirm.latte', $params);

        $mail = (new Message())
            ->setFrom('info@matodo.cz')
            ->addTo($to)
            ->addBcc('info@matodo.cz')
            ->setSubject('Potvrzení rezervace výletu')
            ->setHtmlBody($html);
        $this->mailer->send($mail);
    }

    public function sendCustomEmail(string $to, string $subject, array $params): void
    {
        $html = $this->latte->renderToString(__DIR__ . '/Templates/CustomEmail.latte', $params);

        $mail = (new Message())
            ->setFrom('info@matodo.cz')
            ->addTo($to)
            ->addBcc('info@matodo.cz')
            ->setSubject($subject)
            ->setHtmlBody($html);
        $this->mailer->send($mail);
    }

    public function sendTransferConfirm(string $to,  array $params): void
    {
        $html = $this->latte->renderToString(__DIR__ . '/Templates/TransferConfirm.latte', $params);

        $mail = (new Message())
            ->setFrom('info@matodo.cz')
            ->addTo($to)
            ->addBcc('info@matodo.cz')
            ->setSubject('Potvrzení rezervace transféru.')
            ->setHtmlBody($html);
        $this->mailer->send($mail);
    }

}