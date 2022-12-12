<?php

declare(strict_types=1);

namespace App\Mailer;

use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;

class MailerService
{
    public function __construct(private readonly TransportInterface $mailer)
    {
    }

    public function sendEmail(string $subject, User $user, string $template): void
    {
        $email = (new TemplatedEmail())
            ->from($user->getEmail())
            ->to('you@example.com')
            ->subject($subject)
            ->htmlTemplate('email/' . $template . '.html.twig')
            ->context([
                'user' => $user
            ])
        ;
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }
    }
}
