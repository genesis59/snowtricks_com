<?php

namespace App\Controller\User;

use App\Entity\User;
use App\Form\UserFormType;
use App\Mailer\MailerService;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserCreateController extends AbstractController
{
    #[Route('/utilisateur/inscription', name: 'app_user_create')]
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        TranslatorInterface $translator,
        TokenGeneratorInterface $tokenGenerator,
        MailerService $mailerService
    ): Response {
        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setUuid(Uuid::v4());
            $user->setPassword($passwordHasher->hashPassword($user, $form->getData()->getPassword()));
            $user->setCreatedAt(new \DateTimeImmutable());
            $user->setActivationToken($tokenGenerator->generateToken());
            $user->setActivationTokenCreatedAt(new \DateTimeImmutable());
            $userRepository->save($user, true);

            $mailerService->sendEmail(
                $translator->trans('activation.subject', [], 'emails'),
                [
                    'user' => $user,
                    'url' => $this->generateUrl(
                        'app_user_activation',
                        [
                            'token' => $user->getActivationToken()
                        ],
                        UrlGeneratorInterface::ABSOLUTE_URL
                    )
                ],
                'activation'
            );
            $this->addFlash('success', $translator->trans('success.register', [], 'flashes'));
            return $this->redirectToRoute('home');
        }
        return $this->render('user/user_create/index.html.twig', [
            'form' => $form->createView(),
            'fix_footer' => true
        ]);
    }
}
