<?php

namespace App\Controller\User;

use App\Entity\Token;
use App\Entity\User;
use App\Event\UserEmailEvent;
use App\Form\ForgottenPasswordType;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserForgottenPasswordController extends AbstractController
{
    #[Route('/utilisateur/mot-de-passe-oublié', name: 'app_user_forgotten_password')]
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        TokenRepository $tokenRepository,
        TokenGeneratorInterface $tokenGenerator,
        TranslatorInterface $translator,
        EventDispatcherInterface $dispatcher
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
                $this->addFlash('danger', $translator->trans('flashes.error.forgotten', [], 'flashes'));
                return $this->redirectToRoute('app_user_forgotten_password');
            }

            $token = new Token();
            $tokenRepository->save($token, true);
            $userRepository->createResetPasswordToken($user, $token);
            $dispatcher->dispatch(new UserEmailEvent($user), UserEmailEvent::RESET_EMAIL);
            $this->addFlash('success', $translator->trans('flashes.success.forgotten', [], 'flashes'));
            return $this->redirectToRoute('home');
        }

        return $this->render('user/user_forgotten_password/index.html.twig', [
            'form' => $form->createView(),
            'add_header' => false,
            'fix_footer' => true
        ]);
    }
}
