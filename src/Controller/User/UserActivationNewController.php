<?php

namespace App\Controller\User;

use App\Entity\Token;
use App\Entity\User;
use App\Event\UserEmailEvent;
use App\Form\NewActivationFormType;
use App\Repository\TokenRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class UserActivationNewController extends AbstractController
{
    #[Route('/utilisateur/nouvelle_activation', name: 'app_user_new_activation')]
    public function __invoke(
        Request $request,
        UserRepository $userRepository,
        TokenRepository $tokenRepository,
        TokenGeneratorInterface $tokenGenerator,
        EventDispatcherInterface $dispatcher,
        TranslatorInterface $translator,
    ): Response {

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }
        $form = $this->createForm(NewActivationFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $userRepository->findOneBy(['email' => $form->getData()['email']]);

            if ($user == null) {
                $this->addFlash('danger', $translator->trans('flashes.error.new_activation', [], 'flashes'));
                return $this->redirectToRoute('app_user_new_activation');
            }
            if ($user->isIsActivated()) {
                $this->addFlash('danger', $translator->trans('flashes.error.already_activation', [], 'flashes'));
                return $this->redirectToRoute('home');
            }

            $token = new Token();
            $tokenRepository->save($token, true);
            $userRepository->createActivationToken($user, $token);
            $dispatcher->dispatch(new UserEmailEvent($user), UserEmailEvent::ACTIVATION_EMAIL);
            $this->addFlash('success', $translator->trans('flashes.success.new_activation', [], 'flashes'));
            return $this->redirectToRoute('app_login');
        }

        return $this->render('user/user_activation_new/index.html.twig', [
            'form' => $form->createView(),
            'add_header' => false,
            'fix_footer' => true
        ]);
    }
}
