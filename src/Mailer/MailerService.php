<?php

declare(strict_types=1);

namespace App\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpKernel\UriSigner;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class MailerService
{
    public function __construct(
        private readonly TransportInterface $mailer,
        private readonly UriSigner $uriSigner
    ) {
    }

    /**
     * @param string $subject
     * @param array<string,mixed> $context
     * @param string $template
     * @return void
     */
    public function sendEmail(string $subject, array $context, string $template): void
    {
        $signUrl = $this->uriSigner->sign($context['url']);
        $email = (new TemplatedEmail())
            ->from($context["user"]->getEmail())
            ->to('me@example.com')
            ->subject($subject)
            ->htmlTemplate('email/' . $template . '.html.twig')
            ->context([
                ...$context,
                'sign_url' => $signUrl
            ])
        ;
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            echo $e->getMessage();
        }
    }
}
