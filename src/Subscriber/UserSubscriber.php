<?php

namespace App\Subscriber;

use App\Event\UserEmailEvent;
use App\Mailer\MailerService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly MailerService $mailerService,
        private readonly TranslatorInterface $translator,
        private readonly UrlGeneratorInterface $urlGenerator
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserEmailEvent::ACTIVATION_EMAIL => 'onUserCreate',
            UserEmailEvent::RESET_EMAIL => 'onForgottenPassword'
        ];
    }
    public function onUserCreate(UserEmailEvent $event): void
    {
        $this->mailerService->sendEmail(
            $this->translator->trans('email.activation.subject', [], 'emails'),
            [
                'user' => $event->getUser(),
                'url' => $this->urlGenerator->generate(
                    'app_user_activation',
                    [
                        'token' => $event->getUser()->getActivationToken()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ],
            'activation'
        );
    }

    public function onForgottenPassword(UserEmailEvent $event): void
    {
        $this->mailerService->sendEmail(
            $this->translator->trans('email.forgotten.subject', [], 'emails'),
            [
                'user' => $event->getUser(),
                'url' => $this->urlGenerator->generate(
                    'app_user_reset_password',
                    [
                        'token' => $event->getUser()->getResetToken()
                    ],
                    UrlGeneratorInterface::ABSOLUTE_URL
                )
            ],
            'forgotten_password'
        );
    }
}
