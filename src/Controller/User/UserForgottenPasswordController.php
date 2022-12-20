<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\ForgottenPasswordType;
use App\Mailer\MailerService;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserForgottenPasswordController extends AbstractController
{
    #[Route('/utilisateur/mot-de-passe-oublié', name: 'app_user_forgotten_password')]
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        TokenGeneratorInterface $tokenGenerator,
        MailerService $mailerService,
        TranslatorInterface $translator
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createForm(ForgottenPasswordType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $userRepository->findOneBy(['email' => $form->getData()['email']]);

            if ($user == null) {
                $this->addFlash('danger', $translator->trans('error.forgotten', [], 'flashes'));
                return $this->redirectToRoute('app_user_forgotten_password');
            }
            $user->setResetToken($tokenGenerator->generateToken());
            $user->setResetTokenCreatedAt(new \DateTimeImmutable());
            $userRepository->save($user, true);
            $mailerService->sendEmail(
                $translator->trans('forgotten.subject', [], 'emails'),
                [
                    'user' => $user,
                    'url' => $this->generateUrl(
                        'app_user_reset_password',
                        [
                            'token' => $user->getResetToken()
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ],
                'forgotten_password'
            );
            $this->addFlash('success', $translator->trans('success.forgotten', [], 'flashes'));
            return $this->redirectToRoute('home');
        }

        return $this->render('user/user_forgotten_password/index.html.twig', [
            'form' => $form->createView(),
            'fix_footer' => true
        ]);
    }
}
